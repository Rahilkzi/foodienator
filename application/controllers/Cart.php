<?php
class Cart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $user = $this->session->userdata('user');
        if (!$user) {
            redirect('login');
        }
        // Load custom cart
        $this->load->library('my_cart', [], 'cart');
        $this->cart->load_cart_from_db();  // restore on login
    }

    public function index()
    {
        $data['cartItems'] = $this->cart->contents();
        $data['cartTotal'] = $this->cart->total();
        $this->load->view('front/partials/header');
        $this->load->view('front/cart', $data);
        $this->load->view('front/partials/footer');

    }

    public function updateCartItemQty()
    {
        $rowid = $this->input->get('rowid');
        $qty   = $this->input->get('qty');

        if ($rowid && $qty !== null) {
            $ok = $this->cart->update(['rowid' => $rowid, 'qty' => $qty]);
            echo $ok ? 'ok' : 'err';
            return;
        }
        echo 'err';
    }

    public function removeItem($rowid)
    {
        $this->cart->remove($rowid);
        redirect('cart');
    }
}
