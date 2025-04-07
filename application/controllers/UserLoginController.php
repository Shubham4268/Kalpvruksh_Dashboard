<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserLoginController extends CI_Controller {

    public function index() {
        $this->load->library('session');  
        $this->load->view('userlogin'); 
    }

    public function authenticate() {
        $this->load->model('TransactionModel');

        $phone = $this->input->post('phone'); 
        $user = $this->TransactionModel->getUserByPhone($phone);

        if ($user) {
            // Set session details similar to admin
            $_SESSION['user_id'] = $user->cust_phone;
            $_SESSION['user_phone'] = $user->cust_phone;
            $_SESSION['user_name'] = $user->cust_name;
            $_SESSION['user_role'] = "User"; // Assign role for restriction

            redirect('transactions'); // Redirect to admin dashboard
        } else {
            $this->session->set_flashdata('error', 'Phone number not found');
            redirect('userlogin');
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect('userlogin');
    }
}
?>
