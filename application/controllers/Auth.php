<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if($this->session->userdata('logged_in')) {
            redirect('admin');
        }
        $this->load->view('auth/login');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $user = $this->auth_model->verify_user($username, $password);
        
        if($user) {
            $user_data = array(
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'logged_in' => TRUE
            );
            
            $this->session->set_userdata($user_data);
            redirect('admin');
        } else {
            $this->session->set_flashdata('error', 'Nom d\'utilisateur ou mot de passe incorrect');
            redirect('admin/auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('admin/auth');
    }
}
