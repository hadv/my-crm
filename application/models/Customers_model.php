<?php

/**
 * Class Customer_Model
 */
class Customers_model extends CI_Model {

	var $table = 'customers';

	/**
	 * Customer_Model constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * @return mixed
	 */
	public function all() {
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function get_by_id($id) {
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * @return mixed
	 */
	public function add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * @param $where
	 * @param $data
	 * @return mixed
	 */
	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	/**
	 * @param $id
	 */
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
}
