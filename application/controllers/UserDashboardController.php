<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDashboardController extends CI_Controller {

    public function index() {
        if (!$this->session->userdata('user_id')) {
            redirect('userlogin'); // Redirect if not logged in
        }

        $this->load->view('userdashboard');
    }
}
?>
