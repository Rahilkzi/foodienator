<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Login extends CI_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index() {
        $this->load->view('front/login');
    }

    public function authenticate() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone','Phone', 'trim|required');
        $this->form_validation->set_rules('password','Password', 'trim|required');

         if($this->form_validation->run() == true) {
             $phone = $this->input->post('phone');
             $user = $this->User_model->getByPhone($phone); 
             if(!empty($user)) {
                $password = $this->input->post('password');
                $userArray = array();
                if( password_verify($password, $user['password']) == true) {

                    $userArray['user_id'] = $user['u_id'];
                    $userArray['phone'] = $user['phone'];
                    $userArray['username'] = $user['username'];
                    $this->session->set_userdata('user', $userArray);
                    redirect(base_url().'home/index');
                } else {
                    $this->session->set_flashdata('msg', 'Either phone or password is incorrect');
                    redirect(base_url().'login/index');
                }
             } else {
                $this->session->set_flashdata('msg', 'Either phone or password is incorrect');
                redirect(base_url().'login/index');
             }
             //success
         } else {
             //Error
            $this->load->view('front/login');
         }
    }

    public function logout() {
        $this->session->unset_userdata('user');
        redirect(base_url().'login/index');
    }
}
