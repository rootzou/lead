<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function verify_user($username, $password) {
        //username: admin / password: 07652991
        $this->db->where('username', $username);
        $this->db->where('password', sha1($password));
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            return $user;
            // if (password_verify($password, $user->password)) {
            //     return $user;
            // }
        }
        return false;
    }
    
    public function get_user($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }
}
