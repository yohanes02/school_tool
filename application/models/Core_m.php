<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getAll($table, $order = null)
	{
		if ($order != null) {
			$this->db->order_by($order, 'asc');
		}
		return $this->db->get($table);
	}

	public function getById($id, $table)
	{
		$this->db->where(['id' => $id]);
		return $this->db->get($table);
	}

	public function getByNisn($nisn, $table)
	{
		$this->db->where(['nisn' => $nisn]);
		return $this->db->get($table);
	}

	public function insertData($ins, $table)
	{
		// echo "<pre>";
		// print_r($ins);
		// echo "</pre>";die;
		$this->db->insert($table, $ins);
		return $this->db->affected_rows();
	}

	public function updateData($id, $ins, $table)
	{
		$this->db->where(["id" => $id])->update($table, $ins);
		return $this->db->affected_rows();
	}

	public function deleteData($id, $table)
	{
		$this->db->where(["id" => $id])->delete($table);
		return $this->db->affected_rows();
	}

	public function getToolByMajor($major)
	{
		$this->db->where(['major' => $major]);
		return $this->db->get('tool');
	}

	public function getDataSubmission($major_id)
	{
		$this->db->where(['major_id' => $major_id]);
		$this->db->order_by('id', 'desc');
		return $this->db->get('submission');
	}
}
