<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teacher_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getHistoryBorrow($teacher_id) {
		$query = "select tht.*, s.first_name, s.last_name from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn where tht.teacher_id = $teacher_id order by tht.id desc";

		return $this->db->query($query);
	}

	public function getToolDataTeacher($major) {
		$where = "is_universal=1 AND is_borrowable=1 AND allowed_major LIKE '%".$major."%'";
		// $this->db->where(['is_universal' => 1, 'is_borrowable' => 1]);
		$this->db->where($where);

		return $this->db->get('tool');
	}

	public function getDetailBorrow($borrow_id) {
		$query = "SELECT tht.*, u.first_name as t_first_name, u.last_name as t_last_name, t.tool_code, t.tool_name, t.available, s.nisn, s.first_name, s.last_name, s.grade from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id left join users u on u.id = tht.teacher_id where tht.id = $borrow_id";
		return $this->db->query($query);
	}
}
