<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Toolman_m Toolman_m
 * @property Student_m Student_m
 * @property Headprog_m Headprog_m
 * @property Core_m Core_m
 * @property db db
 */

class Headdiv extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Core_m", "Toolman_m", "Student_m", "Headprog_m"]);
		if ($this->session->userdata('utype') != 3) {
			redirect('auth');
		}
	}

	public function index()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		// $itemMaster = $this->Core_m->getAll('tool_unique')->result_array();
		$allMajor = $this->Core_m->getAll('school_major')->result_array();

		$toolDatas = [];
		for ($i = 0; $i < count($allMajor); $i++) {
			$toolData = $this->Core_m->getToolByMajor($allMajor[$i]['id'])->result_array();
			array_push($toolDatas, $toolData);
		}

		$data['user'] = $userData;
		// $data['item_master'] = $itemMaster;
		$data['tool_datas'] = $toolDatas;
		$data['all_major'] = $allMajor;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_item_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailItem($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$toolDataDetail = $this->Core_m->getById($id, 'tool')->row_array();

		$toolHistory = [];
		$allToolHistory = $this->Core_m->getAll('tool_history_transaction')->result_array();
		for ($i=0; $i < count($allToolHistory); $i++) { 
			$toolBorrowed = explode(",", $allToolHistory[$i]['tool_id']);
			$toolBorrowedQty = explode(",", $allToolHistory[$i]['quantity']);
			for ($j=0; $j < count($toolBorrowed); $j++) { 
				if($toolBorrowed[$j] == $id) {
					$allToolHistory[$i]['qty_exact'] = $toolBorrowedQty[$j];
					array_push($toolHistory, $allToolHistory[$i]);
				}
			}
		}

		for ($i=0; $i < count($toolHistory); $i++) {
			if(empty($toolHistory[$i]['student_nisn'])) {
				$teacherData = $this->Core_m->getById($toolHistory[$i]['teacher_id'], 'users')->row_array();
				$toolHistory[$i]['borrower_name'] = $teacherData['first_name'] . " " . $teacherData['last_name']; 
				$toolHistory[$i]['borrower_user_type'] = 'Guru'; 
			} else {
				$studentData = $this->Core_m->getByNisn($toolHistory[$i]['student_nisn'], 'student')->row_array();
				$toolHistory[$i]['borrower_name'] = $studentData['first_name'] . " " . $studentData['last_name']; 
				$toolHistory[$i]['borrower_user_type'] = 'Siswa'; 
			}
		}

		$data['user'] = $userData;
		$data['toolDetail'] = $toolDataDetail;
		$data['toolHistory'] = $toolHistory;

		$jsFile['page'] = 'headdiv';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_item_detail_page", $data);
		$this->load->view("component/v_bottom", $jsFile);
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

		if ($post['toolUniversal'] == "1") {
			$allowedMajor = implode(",", $post['majorcb']);
			$ins['allowed_major'] = $allowedMajor;
		} else {
			$ins['allowed_major'] = NULL;
		}

		$this->Core_m->updateData($id, $ins, 'tool');
		redirect('headdiv');
	}


	public function broken()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		// $itemMaster = $this->Core_m->getAll('tool_unique')->result_array();
		$allMajor = $this->Core_m->getAll('school_major')->result_array();

		$toolDatas = [];
		for ($i = 0; $i < count($allMajor); $i++) {
			$toolData = $this->Core_m->getToolByMajor($allMajor[$i]['id'])->result_array();
			$brokenTool = [];
			for ($j = 0; $j < count($toolData); $j++) {
				if ($toolData[$j]['broken'] > 0) {
					array_push($brokenTool, $toolData[$j]);
				}
			}
			array_push($toolDatas, $brokenTool);
		}

		$data['user'] = $userData;
		// $data['item_master'] = $itemMaster;
		$data['tool_datas'] = $toolDatas;
		$data['all_major'] = $allMajor;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_item_broken_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function inOutPage()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$allMajor = $this->Core_m->getAll('school_major')->result_array();
		$borrowingDatas = [];
		for ($i = 0; $i < count($allMajor); $i++) {
			$borrowData = $this->Toolman_m->getHistoryBorrow2($allMajor[$i]['id'], null, null)->result_array();
			
			$borrowingDataDetailStudent = [];
			$borrowingDataDetailTeacher = [];
	
			for ($j = 0; $j < count($borrowData); $j++) {
				// print($j . " - ". $borrowData[$j]['teacher_id']. " ");
				if (empty($borrowData[$j]['student_nisn'])) {
					$teacherMajor = $this->Core_m->getById($borrowData[$j]['major'], 'school_major')->row_array();
					$borrowData[$j]['first_name'] = $borrowData[$j]['ufname'];
					$borrowData[$j]['last_name'] = $borrowData[$j]['ulname'];
					$borrowData[$j]['major_name'] = $teacherMajor['abbv_major'];
					array_push($borrowingDataDetailTeacher, $borrowData[$j]);
				} else {
					array_push($borrowingDataDetailStudent, $borrowData[$j]);
				}
			}
			
			$borrowingData['student'] = $borrowingDataDetailStudent;
			$borrowingData['teacher'] = $borrowingDataDetailTeacher;
			array_push($borrowingDatas, $borrowingData);
		}

		// die;

		$data['user'] = $userData;
		$data['borrowingDatas'] = $borrowingDatas;
		$data['all_major'] = $allMajor;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_inout", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailBorrow($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'student')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Student';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowDataDetail = $this->Headprog_m->getDetailBorrow($id)->row_array();
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
		$this->load->view("headdiv/v_borrow_detail", $data);
		$this->load->view("component/v_bottom");
	}


	public function submission()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$allMajor = $this->Core_m->getAll('school_major')->result_array();
		$submisionDatas = [];
		for ($i = 0; $i < count($allMajor); $i++) {
			$submissionDataDetail = $this->Core_m->getDataSubmission($allMajor[$i]['id'])->result_array();
			array_push($submisionDatas, $submissionDataDetail);
		}
		$data['user'] = $userData;
		$data['submission_datas'] = $submisionDatas;
		$data['all_major'] = $allMajor;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_submission_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailSubmission($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$submissionData = $this->Toolman_m->getDataSubmissioById($id)->row_array();
		$submissionHistoryData = $this->Toolman_m->getSubmissionHistoryBySubmissionId($submissionData['id'])->result_array();

		$data['user'] = $userData;
		$data['submission_data'] = $submissionData;
		$data['submission_history'] = $submissionHistoryData;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_detail_submission", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailHistorySubmission($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$submissionHistoryData = $this->Core_m->getById($id, 'submission_history')->row_array();
		$submissionData = $this->Toolman_m->getDataSubmissioById($submissionHistoryData['submission_id'])->row_array();

		$data['user'] = $userData;
		$data['submission_data'] = $submissionData;
		$data['submission_history_data'] = $submissionHistoryData;
		$data['submission_item_data'] = json_decode($submissionHistoryData['submission_data'], true);

		$jsFile['page'] = 'toolman';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_detail_history_submission", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function acceptSubmission($history_id_submission_id)
	{
		$ids = explode("_", $history_id_submission_id);
		$history_id = $ids[0];
		$submission_id = $ids[1];

		$data = array("status" => 4);
		$this->Core_m->updateData($history_id, $data, 'submission_history');

		$data = array(
			"status" => 2,
			"last_update" => date('Y-m-d H:i:s'),
		);
		$this->Core_m->updateData($submission_id, $data, 'submission');
		redirect("headdiv/detailSubmission/" . $submission_id);
	}

	public function rejectSubmission($history_id_submission_id)
	{
		$ids = explode("_", $history_id_submission_id);
		$history_id = $ids[0];
		$submission_id = $ids[1];

		$data = array("status" => 3);
		$this->Core_m->updateData($history_id, $data, 'submission_history');

		$data = array(
			"status" => 4,
			"last_update" => date('Y-m-d H:i:s'),
		);
		$this->Core_m->updateData($submission_id, $data, 'submission');
		redirect("headdiv/detailSubmission/" . $submission_id);
	}


	public function getUserTypeName($type)
	{
		if ($type == 1) return 'Toolman';
		if ($type == 2) return 'Kepala Jurusan';
		if ($type == 3) return 'Kepala Bidang Inventaris';
		if ($type == 4) return 'Kepala Sekolah';
	}
}
