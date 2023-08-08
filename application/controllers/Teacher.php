<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Teacher_m Teacher_m
 * @property Core_m Core_m
 * @property db db
 * @property config config
 * @property upload upload
 */

class Teacher extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Core_m", "Teacher_m"]);
		if ($this->session->userdata('utype') != 5) {
			redirect('auth');
		}
	}

	public function index()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Guru';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$toolData = $this->Teacher_m->getToolDataTeacher($userData['major'])->result_array();

		$data['user'] = $userData;
		$data['tool_data'] = $toolData;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("teacher/v_item_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailItem($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Guru';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$toolDataDetail = $this->Core_m->getById($id, 'tool')->row_array();

		$data['user'] = $userData;
		$data['toolDetail'] = $toolDataDetail;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("teacher/v_item_detail_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function confirmation() {
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Guru';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowingDataDetail = $this->Teacher_m->getHistoryBorrow($userData['id'])->result_array();
		$borrowingData = [];
		for ($i=0; $i < count($borrowingDataDetail); $i++) { 
			if(empty($borrowingDataDetail[$i]['student_nisn']) == false) {
				array_push($borrowingData, $borrowingDataDetail[$i]);
			}
		}

		$data['user'] = $userData;
		$data['borrowingData'] = $borrowingData;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("teacher/v_confirmation", $data);
		$this->load->view("component/v_bottom");
	}

	public function inOutPage()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Guru';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowingDataDetail = $this->Teacher_m->getHistoryBorrow($userData['id'])->result_array();
		$borrowingData = [];
		for ($i=0; $i < count($borrowingDataDetail); $i++) { 
			if(empty($borrowingDataDetail[$i]['student_nisn'])) {
				array_push($borrowingData, $borrowingDataDetail[$i]);
			}
		}

		$data['user'] = $userData;
		$data['borrowingData'] = $borrowingData;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("teacher/v_inout", $data);
		$this->load->view("component/v_bottom");
	}

	public function newBorrow()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Guru';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];
		
		$toolData = $this->Teacher_m->getToolDataTeacher($this->session->userdata('major'))->result_array();

		$data['user'] = $userData;
		$data['tool_data'] = $toolData;

		$jsFile['page'] = 'teacher';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("teacher/v_new_borrow", $data);
		$this->load->view("component/v_bottom", $jsFile);
	}

	public function detailBorrow($id)
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'users')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Guru';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowDataDetail = $this->Teacher_m->getDetailBorrow($id)->row_array();
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
		$this->load->view("teacher/v_borrow_detail", $data);
		$this->load->view("component/v_bottom");
	}

	public function acceptBorrow($id)
	{
		$ins = array(
			"borrow_accepted" => 1,
		);
		$this->Core_m->updateData($id, $ins, 'tool_history_transaction');
		redirect('teacher/detailBorrow/' . $id);
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

		$ins = array(
			'tool_id' => implode(',', $toolIds),
			'code_borrow' => $this->generateRandomString(),
			'borrower_type' => 4,
			'major' => $this->session->userdata('major'),
			'quantity' => implode(',', $quantityItems),
			// 'image_borrow' => $post['available'],
			'information_student' => $post['infoborrow'],
			'teacher_id' => $this->session->userdata('id'),
		);

		$this->Core_m->insertData($ins, 'tool_history_transaction');
		redirect('student/inOutPage');
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
		redirect('teacher/detailBorrow/' . $id);
	}

	public function getToolData()
	{
		$toolData = $this->Teacher_m->getToolDataTeacher($this->session->userdata('major'))->result_array();
		if ($toolData == null) {
			echo json_encode("NO DATA");
		} else {
			echo json_encode($toolData);
		}
	}

	function generateRandomString()
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$randomString = '';

		for ($i = 0; $i < 8; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}

		return $randomString;
	}


}
