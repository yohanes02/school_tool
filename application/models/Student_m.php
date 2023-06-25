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

	public function getDetailBorrow($borrow_id) {
		$query = "SELECT tht.*, t.tool_code, t.tool_name, t.available, s.nisn, s.first_name, s.last_name, s.grade from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id where tht.id = $borrow_id";
		return $this->db->query($query);
	}
}
