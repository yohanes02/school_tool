<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Toolman_m Toolman_m
 * @property Core_m Core_m
 * @property db db
 */

class Headdiv extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Core_m", "Toolman_m"]);
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

		$data['user'] = $userData;
		$data['toolDetail'] = $toolDataDetail;

		$this->load->view("component/v_top");
		$this->load->view("component/v_header", $data);
		$this->load->view("component/v_sidebar");
		$this->load->view("headdiv/v_item_detail_page", $data);
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
		redirect("headprog/detailSubmission/".$submission_id);
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
		redirect("headprog/detailSubmission/".$submission_id);
	}


	public function getUserTypeName($type)
	{
		if ($type == 1) return 'Toolman';
		if ($type == 2) return 'Kepala Jurusan';
		if ($type == 3) return 'Kepala Bidang Inventaris';
		if ($type == 4) return 'Kepala Sekolah';
	}
}
