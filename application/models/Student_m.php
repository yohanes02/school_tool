<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getHistoryBorrow($major_id, $user_nisn) {
		$query = "SELECT tht.*, t.tool_code, t.tool_name, s.first_name, s.last_name from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id where tht.major = $major_id and tht.student_nisn = $user_nisn order by tht.id desc";

		return $this->db->query($query);
	}

	public function getHistoryBorrow2($major_id, $user_nisn) {
		$query = "select tht.*, s.first_name, s.last_name from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn where tht.student_nisn = $user_nisn order by tht.id desc";

		return $this->db->query($query);
	}

	public function getDetailBorrow($borrow_id) {
		$query = "SELECT tht.*, u.first_name as t_first_name, u.last_name as t_last_name, t.tool_code, t.tool_name, t.available, s.nisn, s.first_name, s.last_name, s.grade from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id left join users u on u.id = tht.teacher_id where tht.id = $borrow_id";
		return $this->db->query($query);
	}

	public function getToolDataStudent($major) {
		$this->db->where(['major' => $major, 'is_universal' => 0, 'is_borrowable' => 1]);
		return $this->db->get('tool');
	}

	public function getTeacherData($major) {
		$this->db->where(['major' => $major, 'type' => 5]);
		return $this->db->get('users');
	}
}
