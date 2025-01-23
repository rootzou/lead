<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_user($user_id) {
        $query = $this->db->get_where('users', ['id' => $user_id]);
        return $query->row();
    }
    
    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    
    public function get_user_by_email($email) {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row();
    }
}
