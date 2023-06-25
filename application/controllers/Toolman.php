<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Toolman_m Toolman_m
 * @property Core_m Core_m
 * @property db db
 */

class Toolman extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Core_m", "Toolman_m"]);
		if ($this->session->userdata('utype') != 1) {
			redirect('auth');
		}
	}

	public function index()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$groupData = $this->Core_m->getAll('tool_unique')->result_array();
		for ($i = 0; $i < count($groupData); $i++) {
			$quantity = $this->Toolman_m->getQtyItem($groupData[$i]['tool_code']);
			$groupData[$i]['quantity'] = $quantity;
		}

		$data['user'] = $userData;
		$data['group_data'] = $groupData;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_toolman", $data);
		$this->load->view("component/v_bottom");
	}

	public function getUserTypeName($type)
	{
		if ($type == 1) return 'Toolman';
		if ($type == 2) return 'Kepala Jurusan';
		if ($type == 3) return 'Kepala Bidang Inventaris';
		if ($type == 4) return 'Kepala Sekolah';
	}

	public function getBorrowerType($type)
	{
		if ($type == 1) return 'Individual';
		if ($type == 2) return 'Kelompok';
		if ($type == 3) return 'Kelas';
	}

	public function insertGroup()
	{
		$post = $this->input->post();

		$ins = array(
			'tool_code' => $post['groupcode'],
			'tool_group' => $post['groupname']
		);

		$this->Core_m->insertData($ins, 'tool_unique');
		redirect('toolman');
	}

	public function itemsPage()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$itemMaster = $this->Core_m->getAll('tool_unique')->result_array();
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();

		$data['user'] = $userData;
		$data['item_master'] = $itemMaster;
		$data['tool_data'] = $toolData;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_item_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function insertItems()
	{
		$toolMajor = $this->session->userdata('major'); // Get MAJOR id

		$post = $this->input->post();
		$itemMaster = $this->Toolman_m->getItemMaster($post['toolcode'])->row_array(); // Get data from tool_unique
		$lastIncrement = $itemMaster['last_increment'] + 1; // Increment for unique
		$toolCode = $post['toolcode'] . "" . $lastIncrement;
		$this->Core_m->updateData($itemMaster['id'], array('last_increment' => $lastIncrement), 'tool_unique');

		$ins = array(
			'tool_code' => $toolCode,
			'tool_name' => $post['toolname'],
			'major' => $toolMajor,
			'quantity' => $post['quantity'],
			'available' => $post['available'],
			'broken' => $post['broken'],
			'information' => $post['information'],
		);
		$this->Core_m->insertData($ins, 'tool');
		redirect('toolman/itemsPage');
	}

	public function detailItem($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$toolDataDetail = $this->Core_m->getById($id, 'tool')->row_array();
		$studentDataDetail = $this->Toolman_m->getStudentByMajor($this->session->userdata('major'))->result_array();

		$borrowingDataDetail = $this->Toolman_m->getHistoryBorrow($this->session->userdata('major'), $id, 5)->result_array();

		$data['user'] = $userData;
		$data['toolDetail'] = $toolDataDetail;
		$data['studentData'] = $studentDataDetail;
		$data['borrowingData'] = $borrowingDataDetail;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_item_detail_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function inOutPage()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$borrowingDataDetail = $this->Toolman_m->getHistoryBorrow($this->session->userdata('major'), null, null)->result_array();

		$data['user'] = $userData;
		$data['borrowingData'] = $borrowingDataDetail;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_inout", $data);
		$this->load->view("component/v_bottom");
	}

	public function newBorrow() {
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$studentDataDetail = $this->Toolman_m->getStudentByMajor($this->session->userdata('major'))->result_array();
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();

		$data['user'] = $userData;
		$data['studentData'] = $studentDataDetail;
		$data['tool_data'] = $toolData;

		$jsFile['page'] = 'toolman';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_new_borrow", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function detailBorrow($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$borrowDataDetail = $this->Toolman_m->getDetailBorrow($id)->row_array();

		$data['user'] = $userData;
		$data['borrowData'] = $borrowDataDetail;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_borrow_detail", $data);
		$this->load->view("component/v_bottom");
	}

	public function insertBorrow($id)
	{
		$post = $this->input->post();
		$itemLeftCurrent = $post['itemleftavailable'] - $post['qtyborrow'];
		$this->Core_m->updateData($id, array('available' => $itemLeftCurrent), 'tool');

		$ins = array(
			'tool_id' => $id,
			'borrower_type' => $post['typeborrower'],
			'student_nisn' => $post['idborrower'],
			'major' => $this->session->userdata('major'),
			'quantity' => $post['qtyborrow'],
			// 'image_borrow' => $post['available'],
			'time_borrow' => date('Y-m-d H:i:s'),
			'information' => $post['infoborrow'],
			'status' => $post['statusborrow'],
			'information' => $post['infoborrow'],
		);

		$this->Core_m->insertData($ins, 'tool_history_transaction');
		redirect('toolman/detailitem/' . $id);
	}

	public function updateReturn($id)
	{
		$post = $this->input->post();
		$itemLeftCurrent = $post['itemleftavailable'] + $post['qtyborrow'];
		$this->Core_m->updateData($post['itemid'], array('available' => $itemLeftCurrent), 'tool');

		$ins = array(
			"status" => $post['statusborrow'],
			"information" => $post['infoborrow'],
			"time_return" => date('Y-m-d H:i:s')
		);

		$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
		redirect('toolman/detailBorrow/' . $id);
	}

	public function submission()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$submissionDataDetail = $this->Core_m->getDataSubmission($this->session->userdata('major'))->result_array();

		$data['user'] = $userData;
		$data['submission_data'] = $submissionDataDetail;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_submission_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailSubmission($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$submissionData = $this->Toolman_m->getDataSubmissioById($id)->row_array();
		$submissionHistoryData = $this->Toolman_m->getSubmissionHistoryBySubmissionId($submissionData['id'])->result_array();

		// for ($i=0; $i < count($submissionHistoryData); $i++) { 
		// 	$submissionHistoryData[$i]['decoded_submission_data'] = json_decode($submissionHistoryData[$i]['submission_data'], true);
		// }

		$data['user'] = $userData;
		$data['submission_data'] = $submissionData;
		$data['submission_history'] = $submissionHistoryData;
		$data['submission_item_data'] = json_decode($submissionHistoryData[0]['submission_data'], true);

		$jsFile['page'] = 'toolman';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_detail_submission", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function detailHistorySubmission($id) {
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$submissionHistoryData = $this->Core_m->getById($id, 'submission_history')->row_array();
		$submissionData = $this->Toolman_m->getDataSubmissioById($submissionHistoryData['submission_id'])->row_array();
		
		$data['user'] = $userData;
		$data['submission_data'] = $submissionData;
		$data['submission_item_data'] = json_decode($submissionHistoryData['submission_data'], true);

		$jsFile['page'] = 'toolman';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_detail_history_submission", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function newSubmission()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$data['user'] = $userData;

		$jsFile['page'] = 'toolman';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_new_submission", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function submitSubmission()
	{
		$post = $this->input->post();

		$totalPriceSubmission = 0;
		$arr = array();

		$lengthItemCreated = $post['itemnewcount'];
		if ($lengthItemCreated != null && $lengthItemCreated != '') {
			for ($i = 0; $i <= (int) $lengthItemCreated; $i++) {
				if (isset($post['itemname' . $i])) {
					$arrInside = array();
					$nameItemFilled = $post['itemname' . $i] != null && $post['itemname' . $i] != "";
					$qtyItemFilled = $post['itemqty' . $i] != null && $post['itemqty' . $i] != "";
					$pieceItemFilled = $post['itemsatuan' . $i] != null && $post['itemsatuan' . $i] != "";
					$totalItemFilled = $post['itemtotal' . $i] != null && $post['itemtotal' . $i] != "";
					$dataFullyFilled = $nameItemFilled && $qtyItemFilled && $pieceItemFilled && $totalItemFilled;
					if (isset($post['itemname' . $i]) && $dataFullyFilled) {
						$totalPriceSubmission += $post['itemtotal' . $i];
						$arrInside['title'] = $post['itemname' . $i];
						$arrInside['qty'] = $post['itemqty' . $i];
						$arrInside['piece'] = $post['itemsatuan' . $i];
						$arrInside['total'] = $post['itemtotal' . $i];
						$arrInside['specification'] = $post['itemspecification' . $i];
						array_push($arr, $arrInside);
					}
				}
			}
		}


		if (isset($post['submissionid']) && $post['submissionid'] != null && $post['submissionid'] != "") {
			$data = array(
				"submission_title" => $post['titlesubmission'],
				"submission_type" => $post['typesubmission'],
				"month" => $post['monthsubmission'],
				"price" => $totalPriceSubmission,
				"submission_revision" => (int) $post['submissionrev'] + 1,
				"last_update" => date('Y-m-d H:i:s'),
				"status" => 0,
			);
			$this->Core_m->updateData($post['submissionid'], $data, "submission");

			$insHistory = array(
				"submission_id" => $post['submissionid'],
				"submission_title" => $post['titlesubmission'],
				"price" => $totalPriceSubmission,
				"submission_data" => json_encode($arr),
				"status" => 0
			);

			$this->Core_m->insertData($insHistory, "submission_history");
		} else {
			$ins = array(
				"toolman_id" => $this->session->userdata('id'),
				"major_id" => $this->session->userdata('major'),
				"submission_title" => $post['titlesubmission'],
				"submission_type" => $post['typesubmission'],
				"submission_date" => date('Y-m-d H:i:s'),
				"last_update" => date('Y-m-d H:i:s'),
				"price" => $totalPriceSubmission,
				"submission_revision" => 1,
				"status" => 0
			);

			if ($post['typesubmission'] == "1") {
				$ins['month'] = $post['monthsubmission'];
			}

			$this->Core_m->insertData($ins, "submission");

			$insert_id = $this->db->insert_id();

			$insHistory = array(
				"submission_id" => $insert_id,
				"submission_title" => $post['titlesubmission'],
				"price" => $totalPriceSubmission,
				"submission_data" => json_encode($arr),
				"status" => 0
			);

			$this->Core_m->insertData($insHistory, "submission_history");
		}


		redirect("toolman/submission");
	}

	public function getToolData() {
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();
		if ($toolData == null) {
			echo json_encode("NO DATA");
		} else {
			echo json_encode($toolData);
		}
	}
}
