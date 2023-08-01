<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Toolman_m Toolman_m
 * @property Core_m Core_m
 * @property db db
 * @property config config
 * @property upload upload
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
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$groupData = $this->Core_m->getToolUniqueByMajor($this->session->userdata('major'))->result_array();
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
			'tool_group' => $post['groupname'],
			'major' => $this->session->userdata('major')
		);

		$this->Core_m->insertData($ins, 'tool_unique');
		redirect('toolman');
	}

	public function itemsPage()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$itemMaster = $this->Core_m->getToolUniqueByMajor($this->session->userdata('major'))->result_array();
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
			'is_universal' => $post['toolUniversal'],
			'is_borrowable' => $post['toolBorrowable'],
		);
		$this->Core_m->insertData($ins, 'tool');
		redirect('toolman/itemsPage');
	}

	public function editItem($id)
	{
		$post = $this->input->post();

		$ins = array(
			'tool_name' => $post['toolname'],
			'quantity' => $post['quantity'],
			'available' => $post['available'],
			'broken' => $post['broken'],
			'information' => $post['information'],
			'is_universal' => $post['toolUniversal'],
			'is_borrowable' => $post['toolBorrowable'],
		);
		$this->Core_m->updateData($id, $ins, 'tool');
		redirect('toolman/itemsPage');
	}

	public function detailItem($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

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
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowingDataDetail = $this->Toolman_m->getHistoryBorrow2($this->session->userdata('major'), null, null)->result_array();
		// print_r($borrowingDataDetail);
		$borrowingDataDetailStudent = [];
		$borrowingDataDetailTeacher = [];

		for ($i = 0; $i < count($borrowingDataDetail); $i++) {
			// print($i . " - ". $borrowingDataDetail[$i]['teacher_id']. " ");
			if (empty($borrowingDataDetail[$i]['student_nisn'])) {
				$teacherMajor = $this->Core_m->getById($borrowingDataDetail[$i]['major'], 'school_major')->row_array();
				$borrowingDataDetail[$i]['first_name'] = $borrowingDataDetail[$i]['ufname'];
				$borrowingDataDetail[$i]['last_name'] = $borrowingDataDetail[$i]['ulname'];
				$borrowingDataDetail[$i]['major_name'] = $teacherMajor['abbv_major'];
				array_push($borrowingDataDetailTeacher, $borrowingDataDetail[$i]);
			} else {
				array_push($borrowingDataDetailStudent, $borrowingDataDetail[$i]);
			}
		}
		// die;

		$data['user'] = $userData;
		$data['borrowingData']['student'] = $borrowingDataDetailStudent;
		$data['borrowingData']['teacher'] = $borrowingDataDetailTeacher;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_inout", $data);
		$this->load->view("component/v_bottom");
	}

	public function newBorrow()
	{
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
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowDataDetail = $this->Toolman_m->getDetailBorrow($id)->row_array();
		$dataMajor = $this->Core_m->getById($borrowDataDetail['major'], 'school_major')->row_array();
		$borrowDataDetail['major_name'] = $dataMajor['abbv_major'];
		$borrowDataDetail['toolDatas'] = [];
		$tools = explode(",", $borrowDataDetail['tool_id']);

		for ($i = 0; $i < count($tools); $i++) {
			$toolData = $this->Core_m->getById($tools[$i], 'tool')->row_array();
			array_push($borrowDataDetail['toolDatas'], $toolData);
		}

		$data['user'] = $userData;
		$data['borrowData'] = $borrowDataDetail;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("toolman/v_borrow_detail", $data);
		$this->load->view("component/v_bottom");
	}

	public function insertBorrow()
	{
		$post = $this->input->post();

		$toolIds = [];
		$quantityItems = [];

		for ($i = 0; $i <= (int) $post['itemnewborrowcount']; $i++) {
			$validName = isset($post['itemborrowname' . $i]) && $post['itemborrowname' . $i] != null && $post['itemborrowname' . $i] != "";
			$validCount = isset($post['itemborrowcount' . $i]) && $post['itemborrowcount' . $i] != null && $post['itemborrowcount' . $i] != "" && $post['itemborrowcount' . $i] != 0;
			if ($validName && $validCount) {
				array_push($toolIds, $post['itemborrowname' . $i]);
				array_push($quantityItems, $post['itemborrowcount' . $i]);
			}
		}

		for ($i = 0; $i < count($toolIds); $i++) {
			$toolData = $this->Core_m->getById($toolIds[$i], 'tool')->row_array();
			$itemLeftCurrent = $toolData['available'] - $quantityItems[$i];
			$this->Core_m->updateData($toolIds[$i], array('available' => $itemLeftCurrent), 'tool');
		}
		// $itemLeftCurrent = $post['itemleftavailable'] - $post['qtyborrow'];
		// $this->Core_m->updateData($id, array('available' => $itemLeftCurrent), 'tool');

		$ins = array(
			'tool_id' => implode(',', $toolIds),
			'borrower_type' => $post['typeborrower'],
			'student_nisn' => $post['idborrower'],
			'major' => $this->session->userdata('major'),
			'quantity' => implode(',', $quantityItems),
			// 'image_borrow' => $post['available'],
			'time_borrow' => date('Y-m-d H:i:s'),
			'information' => $post['infoborrow'],
			'status' => $post['statusborrow'],
		);

		$this->Core_m->insertData($ins, 'tool_history_transaction');
		redirect('toolman/inOutPage');
	}

	public function updateReturn($id)
	{
		$post = $this->input->post();

		if ($post['statusborrow'] == "1") {
			$ins = array(
				"information" => $post['infoborrow']
			);

			$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
			redirect('toolman/detailBorrow/' . $id);
		} else {
			$toolIds = [];
			$quantityItems = [];

			for ($i = 0; $i <= (int) $post['itemnewborrowcount']; $i++) {
				$validName = isset($post['itemborrowname' . $i]) && $post['itemborrowname' . $i] != null && $post['itemborrowname' . $i] != "";
				$validCount = isset($post['itemborrowcount' . $i]) && $post['itemborrowcount' . $i] != null && $post['itemborrowcount' . $i] != "" && $post['itemborrowcount' . $i] != 0;
				if ($validName && $validCount) {
					array_push($toolIds, $post['itemborrowname' . $i]);
					array_push($quantityItems, $post['itemborrowcount' . $i]);
				}
			}

			for ($i = 0; $i < count($toolIds); $i++) {
				$toolData = $this->Core_m->getById($toolIds[$i], 'tool')->row_array();
				$itemLeftCurrent = $toolData['available'] + $quantityItems[$i];
				$this->Core_m->updateData($toolIds[$i], array('available' => $itemLeftCurrent), 'tool');
			}

			// $itemLeftCurrent = $post['itemleftavailable'] + $post['qtyborrow'];
			// $this->Core_m->updateData($post['itemid'], array('available' => $itemLeftCurrent), 'tool');

			$ins = array(
				"status" => $post['statusborrow'],
				"information" => $post['infoborrow'],
				"time_return" => date('Y-m-d H:i:s')
			);

			$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
			redirect('toolman/inOutPage');
		}
	}

	public function updateBorrowStatus($id)
	{
		$post = $this->input->post();

		// print_r($post);
		// die;

		if ($post['statusborrow'] == "1") {
			$ins = array(
				"status" => $post['statusborrow'],
				"information_toolman" => $post['infoborrowtoolman'],
				"time_borrow" => date('Y-m-d H:i:s')
			);

			$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
			redirect('toolman/detailBorrow/' . $id);
		} else {
			$dataBorrow = $this->Core_m->getById($id, 'tool_history_transaction')->row_array();
			$toolIds = explode(",", $dataBorrow['tool_id']);
			$quantityItems = explode(",", $dataBorrow['quantity']);

			for ($i = 0; $i < count($toolIds); $i++) {
				$toolData = $this->Core_m->getById($toolIds[$i], 'tool')->row_array();
				$itemLeftCurrent = $toolData['available'] + $quantityItems[$i];
				$this->Core_m->updateData($toolIds[$i], array('available' => $itemLeftCurrent), 'tool');
			}

			$ins = array(
				"status" => $post['statusborrow'],
				"information_toolman" => $post['infoborrowtoolman'],
				"time_return" => date('Y-m-d H:i:s')
			);

			$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
			redirect('toolman/inOutPage');
		}
	}

	public function acceptBorrow($id)
	{
		$ins = array(
			"borrow_accepted" => 1,
		);
		$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
		redirect('toolman/detailBorrow/' . $id);
	}

	public function rejectBorrow($id)
	{
		$dataBorrow = $this->Core_m->getById($id, 'tool_history_transaction')->row_array();

		$ins = array(
			"borrow_accepted" => 2,
		);

		$toolIds = explode(",", $dataBorrow['tool_id']);
		$quantityItems = explode(",", $dataBorrow['quantity']);

		for ($i = 0; $i < count($toolIds); $i++) {
			$toolData = $this->Core_m->getById($toolIds[$i], 'tool')->row_array();
			$itemLeftCurrent = $toolData['available'] + $quantityItems[$i];
			$this->Core_m->updateData($toolIds[$i], array('available' => $itemLeftCurrent), 'tool');
		}

		$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
		redirect('toolman/detailBorrow/' . $id);
	}

	public function submission()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$submissionDataDetail = $this->Core_m->getDataSubmission($this->session->userdata('major'))->result_array();

		for ($i = 0; $i < count($submissionDataDetail); $i++) {
			$submissionDataDetail[$i]['price'] = $this->formatRupiah($submissionDataDetail[$i]['price']);
		}

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
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$submissionData = $this->Toolman_m->getDataSubmissioById($id)->row_array();
		$submissionData['price'] = $this->formatRupiah($submissionData['price']);
		$submissionHistoryData = $this->Toolman_m->getSubmissionHistoryBySubmissionId($submissionData['id'])->result_array();

		for ($i = 0; $i < count($submissionHistoryData); $i++) {
			$submissionHistoryData[$i]['price'] = $this->formatRupiah($submissionHistoryData[$i]['price']);
		}

		// print_r($submissionData);die;

		$itemMaster = $this->Core_m->getAll('tool_unique')->result_array();
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();


		// for ($i=0; $i < count($submissionHistoryData); $i++) { 
		// 	$submissionHistoryData[$i]['decoded_submission_data'] = json_decode($submissionHistoryData[$i]['submission_data'], true);
		// }

		$data['user'] = $userData;
		$data['item_master'] = $itemMaster;
		$data['tool_data'] = $toolData;
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

	public function detailHistorySubmission($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$submissionHistoryData = $this->Core_m->getById($id, 'submission_history')->row_array();
		$submissionData = $this->Toolman_m->getDataSubmissioById($submissionHistoryData['submission_id'])->row_array();
		$submissionData['price'] = $this->formatRupiah($submissionData['price']);
		// print_r($submissionData);die;

		$data['user'] = $userData;
		$data['submission_data'] = $submissionData;
		$data['submission_item_data'] = json_decode($submissionHistoryData['submission_data'], true);
		$data['submission_history_status'] = $submissionHistoryData['status'];
		$data['submission_history_id'] = $submissionHistoryData['id'];

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
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$itemMaster = $this->Core_m->getToolUniqueByMajor($this->session->userdata('major'))->result_array();
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();

		$data['user'] = $userData;
		$data['item_master'] = $itemMaster;
		$data['tool_data'] = $toolData;

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
						$photo = "";
						if ($_FILES["itemimage" . $i]['name'] != null && $_FILES["itemimage" . $i]['name'] != "") {
							$file_name = strtolower($this->generateRandomString());
							$ext = explode(".", $_FILES["itemimage" . $i]['name']);
							$fileUploaded = $this->ups("itemimage" . $i, $file_name);
							if ($fileUploaded) {
								$photo = $_FILES["itemimage" . $i]['name'];
							}
						}
						$totalPriceSubmission += $post['itemtotal' . $i];
						$arrInside['title'] = $post['itemname' . $i];
						$arrInside['qty'] = $post['itemqty' . $i];
						$arrInside['piece'] = $post['itemsatuan' . $i];
						$arrInside['total'] = $post['itemtotal' . $i];
						$arrInside['image'] = $file_name . '.' . $ext[1];
						$arrInside['specification'] = $post['itemspecification' . $i];
						if (isset($post['itemexist' . $i])) {
							$arrInside['existingItem'] = 1;
							$arrInside['groupItemId'] = 0;
							$arrInside['itemId'] = $post['itemexisting' . $i];
						} else {
							$arrInside['existingItem'] = 0;
							$arrInside['groupItemId'] = $post['itemgroup' . $i];
							$arrInside['itemId'] = 0;
						};
						$arrInside['isInserted'] = 0;
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

	public function submissionItemArrived($id)
	{
		$data = array("status" => 5);

		$this->Core_m->updateData($id, $data, 'submission');
		redirect('toolman/detailSubmission/' . $id);
	}

	public function insertItemToItemList($id)
	{
		$submissionHistoryData = $this->Core_m->getById($id, 'submission_history')->row_array();
		$items = json_decode($submissionHistoryData['submission_data'], true);

		$post = $this->input->post();

		for ($i = 0; $i < count($items); $i++) {
			if (isset($post['iteminsert' . $i])) {
				$existingItem = false;
				if ($items[$i]['existingItem'] == "1") {
					$existingItem = true;
				}

				if ($existingItem) {
					$itemId = $items[$i]['itemId'];
					$getItemData = $this->Core_m->getById($itemId, 'tool')->row_array();
					$updatedQty = (int) $items[$i]['qty'] + (int) $getItemData['quantity'];
					$updatedAvailable = (int) $items[$i]['qty'] + (int) $getItemData['available'];

					$updateData = array(
						"quantity" => $updatedQty,
						"available" => $updatedAvailable,
					);

					$this->Core_m->updateData($getItemData['id'], $updateData, 'tool');

					$items[$i]['isInserted'] = "1";
				} else {
					$groupItemId = $items[$i]['groupItemId'];
					$getGroupData = $this->Core_m->getById($groupItemId, 'tool_unique')->row_array();
					$lastIncrement = $getGroupData['last_increment'] + 1; // Increment for unique
					$toolCode = $getGroupData['tool_code'] . "" . $lastIncrement;

					$ins = array(
						'tool_code' => $toolCode,
						'tool_name' => $items[$i]['title'],
						'major' => $getGroupData['major'],
						'quantity' => $items[$i]['qty'],
						'available' => $items[$i]['qty'],
						'broken' => 0
					);

					$this->Core_m->insertData($ins, 'tool');
					$this->Core_m->updateData($getGroupData['id'], array('last_increment' => $lastIncrement), 'tool_unique');

					$items[$i]['isInserted'] = "1";
				}
			}
		}

		$updateItemsData = array("submission_data" => json_encode($items));
		$this->Core_m->updateData($id, $updateItemsData, 'submission_history');

		redirect('toolman/detailHistorySubmission/' . $id);
	}

	public function getToolData()
	{
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();
		if ($toolData == null) {
			echo json_encode("NO DATA");
		} else {
			echo json_encode($toolData);
		}
	}

	public function getToolDataAndToolGroup()
	{
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();
		$toolGroup = $this->Core_m->getToolUniqueByMajor($this->session->userdata('major'))->result_array();

		$data = array(
			"tool_data" => $toolData,
			"tool_group" => $toolGroup,
		);
		if ($toolData == null && $toolGroup == null) {
			echo json_encode("NO DATA");
		} else {
			echo json_encode($data);
		}
	}

	private function ups($input, $file_name)
	{
		echo $input . "\n";
		$temp = $_FILES[$input]['tmp_name'];

		$config['upload_path']		= $this->config->item('dirUploads');
		$config['allowed_types']	= 'gif|jpg|jpeg|png|csv|xls|doc|docx|xlsx|gif';
		$config['max_size']			= 10240;
		$config['overwrite'] 		= TRUE;
		$config['file_name']			= $file_name;

		$this->upload->initialize($config);
		if (!$this->upload->do_upload($input)) {
			echo "error - " . $input . "\n";
			return false;
		}

		$filesize = getimagesize($temp);
		if ($filesize != null || $filesize != array()) {
			if ($filesize[0] > 2000 || $filesize[1] > 2000) {
				return false;
			}
		}

		return true;
	}

	function generateRandomString()
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$randomString = '';

		for ($i = 0; $i < 12; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}

		return $randomString;
	}

	function formatRupiah($priceRaw)
	{
		$priceReversed = strrev($priceRaw);
		$splits = str_split($priceReversed, 3);

		$rupiahReversed = implode(".", $splits);
		$rupiah = strrev($rupiahReversed);
		return 'Rp. ' . $rupiah;
	}
}
