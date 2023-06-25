<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getUser($username, $pass)
	{
		$this->db->where(['username' => $username, 'password' => $pass]);
		return $this->db->get("users");
	}

	public function getUserStudent($nisn, $pass)
	{
		$this->db->where(['nisn' => $nisn, 'password' => $pass]);
		return $this->db->get("student");
	}
}
