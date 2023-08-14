<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Toolman_m Toolman_m
 * @property Student_m Student_m
 * @property Core_m Core_m
 * @property db db
 */

class Headprog extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Core_m", "Toolman_m", "Student_m"]);
		if ($this->session->userdata('utype') != 2) {
			redirect('auth');
		}
	}

	public function index()
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
		$this->load->view("headprog/v_item_page", $data);
		$this->load->view("component/v_bottom");
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

		// print("<pre>".print_r($toolHistory, true)."</pre>");die;

		$data['user'] = $userData;
		$data['toolDetail'] = $toolDataDetail;
		$data['studentData'] = $studentDataDetail;
		$data['borrowingData'] = $borrowingDataDetail;
		$data['toolHistory'] = $toolHistory;

		$jsFile['page'] = 'headdiv';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headprog/v_item_detail_page", $data);
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
		redirect('headprog');
	}


	public function broken()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$userData['user_type_name'] = $this->getUserTypeName($userData['type']);

		$itemMaster = $this->Core_m->getAll('tool_unique')->result_array();
		$toolData = $this->Core_m->getToolByMajor($this->session->userdata('major'))->result_array();
		$brokenTool = [];
		for ($i = 0; $i < count($toolData); $i++) {
			if ($toolData[$i]['broken'] > 0) {
				array_push($brokenTool, $toolData[$i]);
			}
		}

		$data['user'] = $userData;
		$data['item_master'] = $itemMaster;
		$data['tool_data'] = $brokenTool;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headprog/v_item_broken_page", $data);
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
		$this->load->view("headprog/v_inout", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailBorrow($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'student')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Student';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowDataDetail = $this->Student_m->getDetailBorrow($id)->row_array();
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
		$this->load->view("headprog/v_borrow_detail", $data);
		$this->load->view("component/v_bottom");
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
		$this->load->view("headprog/v_submission_page", $data);
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
		$this->load->view("headprog/v_detail_submission", $data);
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
		$this->load->view("headprog/v_detail_history_submission", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function acceptSubmission($history_id_submission_id)
	{
		$ids = explode("_", $history_id_submission_id);
		$history_id = $ids[0];
		$submission_id = $ids[1];

		$data = array("status" => 2);
		$this->Core_m->updateData($history_id, $data, 'submission_history');

		$data = array(
			"status" => 1,
			"last_update" => date('Y-m-d H:i:s'),
		);
		$this->Core_m->updateData($submission_id, $data, 'submission');
		redirect("headprog/detailSubmission/" . $submission_id);
	}

	public function rejectSubmission($history_id_submission_id)
	{
		$ids = explode("_", $history_id_submission_id);
		$history_id = $ids[0];
		$submission_id = $ids[1];

		$data = array("status" => 1);
		$this->Core_m->updateData($history_id, $data, 'submission_history');

		$data = array(
			"status" => 4,
			"last_update" => date('Y-m-d H:i:s'),
		);
		$this->Core_m->updateData($submission_id, $data, 'submission');
		redirect("headprog/detailSubmission/" . $submission_id);
	}


	public function getUserTypeName($type)
	{
		if ($type == 1) return 'Toolman';
		if ($type == 2) return 'Kepala Jurusan';
		if ($type == 3) return 'Kepala Bidang Inventaris';
		if ($type == 4) return 'Kepala Sekolah';
	}
}
