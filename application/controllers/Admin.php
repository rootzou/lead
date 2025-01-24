<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Vérifier si l'admin est connecté
        // if($this->session->userdata('admin_login') != 1) {
        //     redirect('login');
        // }
    }

    public function index(){
        is_logged_in();
        $data['title'] = 'Dashboard';
        $this->load->view('admin/index',$data);
    }

    public function save_block() {
        $block_id = $this->input->post('block_id');
        $content = $this->input->post('content');
        
        // Charger le modèle
        $this->load->model('blocks_model');
        
        $result = $this->blocks_model->update_block_content($block_id, $content);
        
        if($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
