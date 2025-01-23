<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_services() {
        return $this->db->get('services')->result();
    }
    
    public function get_service($id) {
        return $this->db->get_where('services', ['id' => $id])->row();
    }
    
    public function add_service($data) {
        return $this->db->insert('services', $data);
    }
    
    public function update_service($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('services', $data);
    }
    
    public function delete_service($id) {
        return $this->db->delete('services', ['id' => $id]);
    }
    
    public function get_directory_services($directory_id) {
        $this->db->select('services.*');
        $this->db->from('services');
        $this->db->join('directory_services', 'directory_services.service_id = services.id');
        $this->db->where('directory_services.directory_id', $directory_id);
        return $this->db->get()->result();
    }
    
    public function add_directory_service($directory_id, $service_id) {
        return $this->db->insert('directory_services', [
            'directory_id' => $directory_id,
            'service_id' => $service_id
        ]);
    }
    
    public function remove_directory_service($directory_id, $service_id) {
        return $this->db->delete('directory_services', [
            'directory_id' => $directory_id,
            'service_id' => $service_id
        ]);
    }
    
    public function remove_all_directory_services($directory_id) {
        return $this->db->delete('directory_services', ['directory_id' => $directory_id]);
    }
}
