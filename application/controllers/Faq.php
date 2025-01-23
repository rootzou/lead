<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('faq_model');
    }

    public function get_content() {
        $faq_content = $this->faq_model->get_all();
        echo json_encode(['success' => true, 'data' => $faq_content]);
    }

    public function update_content() {
        $faq_data = $this->input->post('faq');
        
        if ($this->faq_model->update_all($faq_data)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update FAQ']);
        }
    }

    public function toggle_visibility() {
        $visible = $this->input->post('visible');
        
        if ($this->faq_model->toggle_visibility($visible)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to toggle visibility']);
        }
    }
}
