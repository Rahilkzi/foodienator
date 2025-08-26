<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Admin_model extends CI_Model {
    
    public function getByUsername($username) {

        $this->db->where('username', $username);
        $admin = $this->db->get('admin')->row_array();
        return $admin;
    }
    
    public function getAllOrders() {
        $this->db->order_by('o_id','DESC');
        $this->db->select('o_id, d_name, quantity, price, status, date, username, address');
        $this->db->from('user_orders');
        $this->db->join('users', 'users.u_id = user_orders.u_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getCatReport() {
        $this->db->group_by('u.c_id');
        $this->db->select('u.c_id, c_name, price, success-date');
        $this->db->select_sum('price');
        $this->db->from('user_orders as u');
        $this->db->join('categories as c', 'c.c_id = u.c_id');
        $result = $this->db->get()->result();
        return $result;
    }

    public function dishReport() {
        $query = $this->db->query('SELECT d_id, d_name, 
        SUM(quantity) AS qty
        FROM user_orders
        GROUP BY d_id
        ORDER BY SUM(quantity) DESC');
        return $query->result();
    }

    public function mostOrderdDishes() {
        $sql = 'SELECT u.c_id, c.name, u.price, u.d_name, 
        MAX(u.quantity) AS quantity, 
        SUM(price) AS total
        FROM user_orders AS u
        INNER JOIN categories as c
        ON u.c_id = c.c_id
        GROUP BY u.c_id';

        $query = $this->db->query($sql);
        return $query->result();
    }
}
