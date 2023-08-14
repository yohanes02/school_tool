<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Headprog_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDetailBorrow($borrow_id) {
		$query = "SELECT tht.*, u.first_name as t_first_name, u.last_name as t_last_name, t.tool_code, t.tool_name, t.available, s.nisn, s.first_name, s.last_name, s.grade, asg.title from tool_history_transaction tht left join student s on s.nisn = tht.student_nisn left join tool t on t.id = tht.tool_id left join users u on u.id = tht.teacher_id left join assignment asg on asg.id = tht.assignment_id where tht.id = $borrow_id";
		return $this->db->query($query);
	}
}
