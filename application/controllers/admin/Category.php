<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $admin = $this->session->userdata('admin');
        if(empty($admin)) {
            $this->session->set_flashdata('msg', 'Your session has been expired');
            redirect(base_url().'admin/login/index');
        }
    }

    public function index() {
        $this->load->model('Cat_model');
        $cats = $this->Cat_model->getCategories();
        $cats_data['cats'] = $cats;
        $this->load->view('admin/partials/header');
        $this->load->view('admin/category/list', $cats_data);
        $this->load->view('admin/partials/footer');
    }

    public function create_category(){
        $this->load->model('Cat_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category','Category', 'trim|required');

        $this->load->helper('common_helper');

        $config['upload_path']          = './public/uploads/category/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);

        if($this->form_validation->run() == true) {
            $cat['c_name'] = $this->input->post('category');
            
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                if ($this->upload->do_upload('image')) {
                    $data  = $this->upload->data();

                    // $cat['img'] = $uploadData['file_name']; // save filename in DB
                    resizeImage(
                        $config['upload_path'].$data['file_name'],
                        $config['upload_path'].'thumb/'.$data['file_name'],
                        300,
                        270
                    );
                    $cat['img'] = $data['file_name']; // save filename in DB
                } else {
                    // Upload failed
                    $this->session->set_flashdata('cat_error', $this->upload->display_errors());
                    redirect(base_url().'admin/category/add_cat');
                    return;
                }
            }

            $this->Cat_model->create_cat($cat);
            
            $this->session->set_flashdata('cat_success', 'category added successfully');
            redirect(base_url().'admin/category/index');
        } else {
            $this->load->view('admin/partials/header');
            $this->load->view('admin/category/add_cat');
            $this->load->view('admin/partials/footer');
        }
    }

    // public function edit($id) {
        
    //     $this->load->model('Cat_model');
    //     $category = $this->Cat_model->getCategory($id);

    //     if(empty($category)) {
    //         $this->session->set_flashdata('error', 'Category not found');
    //         redirect(base_url().'admin/category/index');
    //     }

    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('category','Category', 'trim|required');

    //     if($this->form_validation->run() == true) {

    //         $category['c_name'] = $this->input->post('category');
    //         $this->Cat_model->update($id, $category);
            
    //         $this->session->set_flashdata('cat_success', 'category added successfully');
    //         redirect(base_url().'admin/category/index');

    //     } else {
    //         $data['category'] = $category;
    //         $this->load->view('admin/partials/header');
    //         $this->load->view('admin/category/edit', $data);
    //         $this->load->view('admin/partials/footer');
    //     }

    // }

    public function edit($id) {
        $this->load->model('Cat_model');
        $category = $this->Cat_model->getCategory($id);

        if (empty($category)) {
            $this->session->set_flashdata('error', 'Category not found');
            redirect(base_url().'admin/category/index');
        }

        $this->load->helper('common_helper');

        $config['upload_path']   = './public/uploads/category/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //$config['encrypt_name'] = true;

        $this->load->library('upload', $config);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category','Category', 'trim|required');

        if ($this->form_validation->run() == true) {
            $updateData['c_name'] = $this->input->post('category');

            // If a new image is uploaded
            if (!empty($_FILES['image']['name'])) {
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();

                    // Resize new image
                    resizeImage(
                        $config['upload_path'].$data['file_name'],
                        $config['upload_path'].'thumb/'.$data['file_name'],
                        300,
                        270
                    );

                    $updateData['img'] = $data['file_name'];

                    // Delete old image + thumbnail if exists
                    if (!empty($category['img'])) {
                        $oldImage = $config['upload_path'].$category['img'];
                        $oldThumb = $config['upload_path'].'thumb/'.$category['img'];

                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                        if (file_exists($oldThumb)) {
                            unlink($oldThumb);
                        }
                    }
                } else {
                    $this->session->set_flashdata('cat_error', $this->upload->display_errors());
                    redirect(base_url().'admin/category/edit/'.$id);
                    return;
                }
            } else {
                // no new image -> keep old one
                $updateData['img'] = $category['img'];
            }

            // Save updates
            $this->Cat_model->update($id, $updateData);

            $this->session->set_flashdata('cat_success', 'Category updated successfully');
            redirect(base_url().'admin/category/index');
        } else {
            $data['category'] = $category;
            $this->load->view('admin/partials/header');
            $this->load->view('admin/category/edit', $data);
            $this->load->view('admin/partials/footer');
        }
    }


    public function delete($id) {
        $this->load->model('Cat_model');
        $cat = $this->Cat_model->getCategory($id);

        if(empty($cat)) {
            $this->session->set_flashdata('error', 'Category not found');
            redirect(base_url().'admin/category/index');
        }

        $cat = $this->Cat_model->delete($id);

        $this->session->set_flashdata('cat_success', 'Category deleted successfully');
        redirect(base_url().'admin/category/index');
    }
}