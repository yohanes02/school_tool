<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property input input
 * @property session session
 * @property Auth_m Auth_m
 */

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["Auth_m"]);
	}

	public function index() {
		if($this->session->userdata('utype') == 1) {
			redirect('toolman');
		}
		if($this->session->userdata('utype') == 2) {
			redirect('headprog');
		}
		if($this->session->userdata('utype') == 3) {
			redirect('headdiv');
		}
		if($this->session->userdata('utype') == 4) {
			redirect('headschool');
		}
		if($this->session->userdata('utype') == 5) {
			redirect('student');
		}
		$this->load->view('v_login');
	}

	public function loginStudent() {
		$this->load->view('v_login_student');
	}

	public function loginUser() {
		$post = $this->input->post();

		$username = $post['username'];
		$password = md5($post['password']);

		$userData = $this->Auth_m->getUser($username, $password)->row_array();

		if(empty($userData)) {
			redirect('auth');
		}

		$dataSession = array(
			'id'		=> $userData['id'],
			'uname'	=> $userData['username'],
			'utype'	=> $userData['type'],
			'fname'	=> $userData['first_name'],
			'lname'	=> $userData['last_name'],
			'major'	=> $userData['major']
		);
		$this->session->set_userdata($dataSession);

		if($userData['type'] == 1) {
			redirect('toolman');
		}
		if($userData['type'] == 2) {
			redirect('headprog');
		}
		if($userData['type'] == 3) {
			redirect('headdiv');
		}
		if($userData['type'] == 4) {
			redirect('headschool');
		}
	}

	public function loginStudentMethod() {
		$post = $this->input->post();

		$nisn = $post['nisn'];
		$password = md5($post['password']);

		$userData = $this->Auth_m->getUserStudent($nisn, $password)->row_array();

		if(empty($userData)) {
			redirect('auth');
		}

		$dataSession = array(
			'id'		=> $userData['id'],
			'nisn'	=> $userData['nisn'],
			'major'	=> $userData['major'],
			'fname'	=> $userData['first_name'],
			'lname'	=> $userData['last_name'],
			'utype'	=> 5,
		);
		$this->session->set_userdata($dataSession);

		redirect('student');		
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}
