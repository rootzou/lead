<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AboutUs_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_content($block_id) {
        $this->db->where('block_id', $block_id);
        $query = $this->db->get('about_us_content');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        // Retourner une structure vide si aucun contenu n'existe
        return array(
            'title' => '',
            'subtitle' => '',
            'image_url' => '',
            'video_url' => ''
        );
    }
    
    public function update_content($block_id, $data) {
        $data['block_id'] = $block_id;
        
        // Vérifier si des données existent déjà
        $this->db->where('block_id', $block_id);
        $exists = $this->db->get('about_us_content')->num_rows() > 0;
        
        if ($exists) {
            // Mettre à jour les données existantes
            $this->db->where('block_id', $block_id);
            return $this->db->update('about_us_content', $data);
        } else {
            // Insérer de nouvelles données
            return $this->db->insert('about_us_content', $data);
        }
    }
    
    public function add_block($data) {
        // Insérer d'abord le bloc dans la table about_us
        $block_data = array(
            'type' => 'about_us',
            'position' => $this->get_next_position()
        );
        
        $this->db->insert('blocks', $block_data);
        $block_id = $this->db->insert_id();
        
        if ($block_id) {
            // Ajouter le contenu dans about_us_content
            $data['block_id'] = $block_id;
            if ($this->db->insert('about_us_content', $data)) {
                return $block_id;
            }
        }
        
        return false;
    }
    
    private function get_next_position() {
        $this->db->select_max('position');
        $this->db->where('type', 'about_us');
        $query = $this->db->get('blocks');
        $result = $query->row_array();
        return ($result['position'] ?? 0) + 1;
    }
}
