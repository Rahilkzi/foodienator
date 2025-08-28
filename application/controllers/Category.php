<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	


	public function index()
	{
		$this->load->model('Cat_model');
		$categories= $this->Cat_model->getCatInfo();
		$data['categories'] = $categories;
		$this->load->view('front/partials/header');
		$this->load->view('front/categories',$data);
		$this->load->view('front/partials/footer');
	}

}
