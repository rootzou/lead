<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Statistics_model');
    }

    public function index() {
        $data['statistics'] = $this->Statistics_model->get_content();
        $this->load->view('statistics_view', $data);
    }

    public function get_content() {
        $content = $this->Statistics_model->get_content();
        echo json_encode($content);
    }

    public function update_content() {
        $data = array(
            'happy_clients_count' => $this->input->post('happy_clients_count'),
            'happy_clients_text' => $this->input->post('happy_clients_text'),
            'projects_count' => $this->input->post('projects_count'),
            'projects_text' => $this->input->post('projects_text'),
            'support_hours_count' => $this->input->post('support_hours_count'),
            'support_hours_text' => $this->input->post('support_hours_text'),
            'workers_count' => $this->input->post('workers_count'),
            'workers_text' => $this->input->post('workers_text')
        );

        $result = $this->Statistics_model->update_content($data);
        echo json_encode(['success' => $result]);
    }

    public function toggle_visibility() {
        $visible = $this->input->post('visible');
        $result = $this->Statistics_model->toggle_visibility($visible);
        echo json_encode(['success' => $result]);
    }
}
