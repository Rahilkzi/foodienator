<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Cat_model extends CI_Model {
    
    public function create_cat($formArray) {
        $this->db->insert('categories', $formArray);
    }

    public function getCategories() {
        $result = $this->db->get('categories')->result_array();
        return $result;
    }

    public function getCategory($id) {
        $this->db->where('c_id', $id);
        $category = $this->db->get('categories')->row_array();
        return $category;
    }

    public function update($id, $formArray) {
        $this->db->where('c_id', $id);
        $this->db->update('categories', $formArray);
    } 

    public function delete($id) {
        $this->db->where('c_id',$id);
        $this->db->delete('categories');
    }

    public function countCategory() {
        $query = $this->db->get('categories');
        return $query->num_rows();
    }

    public function getResInfo() {
        $this->db->select('*');
        $this->db->from('categories');
        // $this->db->join('res_category','categories.c_id = res_category.c_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

}
