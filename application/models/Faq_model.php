<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $query = $this->db->order_by('order_num', 'ASC')->get('faq');
        return $query->result_array();
    }

    public function update_all($faq_data) {
        // Supprimer toutes les anciennes entrées
        $this->db->empty_table('faq');
        
        // Insérer les nouvelles entrées
        foreach ($faq_data as $item) {
            $data = array(
                'question' => $item['question'],
                'answer' => $item['answer'],
                'order_num' => $item['order_num']
            );
            if (!$this->db->insert('faq', $data)) {
                return false;
            }
        }
        return true;
    }

    public function toggle_visibility($visible) {
        return $this->db->update('faq', ['is_visible' => $visible]);
    }
}
