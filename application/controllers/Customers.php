<?php

class Customers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('customers_model');
		$this->load->helper('form');
		$this->load->helper('email');
		$this->load->library('form_validation');
	}

	/**
	 *
	 */
	public function index() {
		$data['customers'] = $this->customers_model->all();
		$data['title'] = 'Customer List';

		$this->load->view('templates/header', $data);
		$this->load->view('customers/index', $data);
		$this->load->view('templates/footer');
	}

	/**
	 *
	 */
	public function create()
	{
		$data['title'] = 'Create a new customer';

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() === FALSE)
		{
			$errors = validation_errors();
			echo json_encode($errors);
		}
		else
		{
			$data = array(
				'name' 	=> $this->input->post('name'),
				'email' => $this->input->post('email')
			);
			$this->customers_model->add($data);
			echo json_encode(array("status" => TRUE));
		}
	}

	/**
	 * @param $id
	 */
	public function show($id)
	{
		$data = $this->customers_model->get_by_id($id);
		echo json_encode($data);
	}

	/**
	 *
	 */
	public function update()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() === FALSE)
		{
			$errors = validation_errors();
			echo json_encode($errors);
		}
		else {
			$data = array(
				'id' => $this->input->post('id'),
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
			);
			$this->customers_model->update(array('id' => $this->input->post('id')), $data);
			echo json_encode(array("status" => TRUE));
		}
	}

	/**
	 * @param $id
	 */
	public function delete($id)
	{
		$this->customers_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}
