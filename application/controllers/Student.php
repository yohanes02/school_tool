<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Student_m Student_m
 * @property Core_m Core_m
 */

class Student extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Core_m", "Student_m"]);
		if ($this->session->userdata('utype') != 6) {
			redirect('auth');
		}
	}

	public function index()
	{
		$userData = $this->Core_m->getByNisn($this->session->userdata('nisn'), 'student')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Student';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$toolData = $this->Student_m->getToolDataStudent($userData['major'])->result_array();

		$data['user'] = $userData;
		$data['tool_data'] = $toolData;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("student/v_item_page", $data);
		$this->load->view("component/v_bottom");
	}

	public function inOutPage()
	{
		$userData = $this->Core_m->getByNisn($this->session->userdata('nisn'), 'student')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Student';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$borrowingDataDetail = $this->Student_m->getHistoryBorrow2($userData['major'], $userData['nisn'])->result_array();

		$data['user'] = $userData;
		$data['borrowingData'] = $borrowingDataDetail;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("student/v_inout", $data);
		$this->load->view("component/v_bottom");
	}

	public function detailItem($id)
	{
		$userData = $this->Core_m->getByNisn($this->session->userdata('nisn'), 'student')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Student';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$toolDataDetail = $this->Core_m->getById($id, 'tool')->row_array();

		$data['user'] = $userData;
		$data['toolDetail'] = $toolDataDetail;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("student/v_item_detail_page", $data);
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
		
		// echo "<pre>".print_r($borrowDataDetail, true)."</pre>";die;

		$data['user'] = $userData;
		$data['borrowData'] = $borrowDataDetail;
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("student/v_borrow_detail", $data);
		$this->load->view("component/v_bottom");
	}

	public function newBorrow()
	{
		$userData = $this->Core_m->getById($this->session->userdata('id'), 'student')->row_array();
		$majorData = $this->Core_m->getById($userData['major'], 'school_major')->row_array();
		$userData['user_type_name'] = 'Student';
		$userData['abbv_major'] = $majorData['abbv_major'];
		$userData['full_major'] = $majorData['full_major'];

		$toolData = $this->Student_m->getToolDataStudent($this->session->userdata('major'))->result_array();
		$teacherData = $this->Student_m->getTeacherData($this->session->userdata('major'))->result_array();
		$assignmentData = $this->Student_m->getAssignmentData($this->session->userdata('major'))->result_array();

		$data['user'] = $userData;
		$data['teacher_data'] = $teacherData;
		$data['assignment_data'] = $assignmentData;
		$data['tool_data'] = $toolData;

		$jsFile['page'] = 'student';
		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("student/v_new_borrow", $data);
		$this->load->view("component/v_bottom", $jsFile);
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

		$estTimeReturnString = $post['esttimereturn'];
		$timestamp = strtotime($estTimeReturnString);
		if ($timestamp === FALSE) {
			$timestamp = strtotime(str_replace('/', '-', $estTimeReturnString));
		}
		$estTimeReturnDate = date('Y-m-d H:i:s', $timestamp);

		$ins = array(
			'tool_id' => implode(',', $toolIds),
			'code_borrow' => $this->generateRandomString(),
			'borrower_type' => $post['typeborrower'],
			'student_nisn' => $this->session->userdata("nisn"),
			'major' => $this->session->userdata('major'),
			'quantity' => implode(',', $quantityItems),
			'est_time_return' => $estTimeReturnDate,
			// 'image_borrow' => $post['available'],
			'information_student' => $post['infoborrow'],
			'borrow_accepted' => 1,
			'teacher_id' => explode('_',$post['assignmentname'])[1],
			'assignment_id' => explode('_',$post['assignmentname'])[0],
		);

		$this->Core_m->insertData($ins, 'tool_history_transaction');
		redirect('student/inOutPage');
	}

	public function getToolData()
	{
		$toolData = $this->Student_m->getToolDataStudent($this->session->userdata('major'))->result_array();
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
