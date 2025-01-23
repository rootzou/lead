<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_content() {
        $query = $this->db->get('statistics');
        return $query->row_array();
    }

    public function update_content($data) {
        $this->db->where('id', 1);
        $query = $this->db->get('statistics');
        
        if ($query->num_rows() > 0) {
            $this->db->where('id', 1);
            return $this->db->update('statistics', $data);
        } else {
            $data['id'] = 1;
            return $this->db->insert('statistics', $data);
        }
    }

    public function toggle_visibility($visible) {
        $this->db->where('id', 1);
        return $this->db->update('statistics', ['is_visible' => $visible]);
    }
}
