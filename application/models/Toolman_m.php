<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Toolman_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getUserById($id)
	{
		$this->db->where(['id' => $id]);
		return $this->db->get("users");
	}

	public function getItemMaster($tool_code)
	{
		$this->db->where(['tool_code' => $tool_code]);
		return $this->db->get("tool_unique");
	}

	// public function getToolGroup($tool_code) {
	// 	$query = "SELECT tool_group FROM tool_unique WHERE tool_code LIKE '%".$tool_code."%'";
	// 	$data = $this->db->query($query)->result_array();

	// 	return $data[0];
	// }

	public function getStudentByMajor($major_id)
	{
		$this->db->where(['major' => $major_id]);
		return $this->db->get('student');
	}

	public function getQtyItem($tool_code)
	{
		$query = "SELECT tool_code, quantity FROM tool WHERE tool_code LIKE '%" . $tool_code . "%'";
		$data = $this->db->query($query)->result_array();

		$quantity = 0;
		for ($i = 0; $i < count($data); $i++) {
			$quantity += $data[$i]['quantity'];
		}

		return $quantity;
	}

	public function getHistoryBorrow($major_id, $tool_id, $limit)
	{
		$query = "SELECT tht.*, t.tool_code, t.tool_name, s.first_name, s.last_name from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id where tht.major = $major_id order by tht.id desc";


		if ($tool_id != null) {
			$query = "SELECT tht.*, s.first_name, s.last_name from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn where tht.major = $major_id and tht.tool_id = $tool_id order by tht.id desc limit $limit";
			// print($query);die;
		}

		return $this->db->query($query);
	}

	public function getHistoryBorrow2($major_id) {
		$query = "select tht.*, s.first_name, s.last_name, s.grade, u.first_name as ufname, u.last_name as ulname from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join users u on u.id = tht.teacher_id left join tool t on t.id = tht.tool_id where t.major = $major_id order by tht.id desc";

		return $this->db->query($query);
	}

	public function getDetailBorrow($borrow_id)
	{
		$query = "SELECT tht.*, u.first_name as t_first_name, u.last_name as t_last_name, t.tool_code, t.tool_name, t.available, s.nisn, s.first_name, s.last_name, s.grade, asg.title from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id left join users u on u.id = tht.teacher_id left join assignment asg on asg.id = tht.assignment_id where tht.id = $borrow_id";
		return $this->db->query($query);
	}

	public function getDataSubmissionHistory($id)
	{
		$this->db->where(['submission_id' => $id]);
		return $this->db->get('submission_history');
	}

	public function getDataSubmissioById($id)
	{
		$this->db->where(['id' => $id]);
		return $this->db->get('submission');
	}

	public function getSubmissionHistoryBySubmissionId($id)
	{
		$this->db->where(['submission_id' => $id]);
		$this->db->order_by('id', 'desc');
		return $this->db->get('submission_history');
	}
}
