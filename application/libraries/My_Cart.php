<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(BASEPATH.'libraries/Cart.php');

class My_Cart extends CI_Cart {
    // public My_Cart $cart; // not Cart

    protected $cart_table = 'user_cart';

    public function __construct($params = array())
    {
        parent::__construct($params);
        $this->CI->load->database();
        $this->CI->load->library('session');
    }

    /**
     * Save cart into DB by user_id
     */
    protected function _save_cart()
    {
        $ok = parent::_save_cart();

        // Only logged in users get persistence
        $user = $this->CI->session->userdata('user');
        if (!$user) return $ok;

        $user_id = $user['user_id'];

        if ($ok === FALSE) {
            $this->CI->db->delete($this->cart_table, ['user_id' => $user_id]);
            return FALSE;
        }

        $cart_data = json_encode($this->_cart_contents);

        $exists = $this->CI->db->get_where($this->cart_table, ['user_id' => $user_id]);
        if ($exists->num_rows() > 0) {
            $this->CI->db->where('user_id', $user_id)
                         ->update($this->cart_table, ['cart_data' => $cart_data]);
        } else {
            $this->CI->db->insert($this->cart_table, [
                'user_id'   => $user_id,
                'cart_data' => $cart_data
            ]);
        }

        return TRUE;
    }

    /**
     * Load saved cart from DB when user logs in
     */
    public function load_cart_from_db()
    {
        $user = $this->CI->session->userdata('user');
        if (!$user) return;

        $user_id = $user['user_id'];
        
        $q = $this->CI->db->get_where($this->cart_table, ['user_id' => $user_id]);

        if ($q->num_rows() > 0) {
            $data = json_decode($q->row()->cart_data, TRUE);
            if (is_array($data)) {
                $this->_cart_contents = $data;
                $this->CI->session->set_userdata('cart_contents', $this->_cart_contents);
            }
        }
    }

    /**
     * Destroy cart from both session & DB
     */
    public function destroy()
    {
        parent::destroy();
        $user = $this->CI->session->userdata('user');
        if ($user) {
            $this->CI->db->delete($this->cart_table, ['user_id' => $user['user_id']]);
        }
    }
}
