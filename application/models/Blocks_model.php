<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocks_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->order_by('order_num', 'ASC');
        $query = $this->db->get('blocks');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function add($type) {
        // Vérifier si le type est valide
        if (!in_array($type, ['about_us', 'statistics', 'faq'])) {
            return false;
        }

        // Obtenir le dernier ordre
        $this->db->select_max('order_num');
        $query = $this->db->get('blocks');
        $result = $query->row();
        $order_num = ($result->order_num ?? 0) + 1;

        $data = array(
            'type' => $type,
            'order_num' => $order_num,
            'is_visible' => 1
        );

        return $this->db->insert('blocks', $data);
    }

    public function update_order($order) {
        if (!is_array($order)) {
            return false;
        }

        $this->db->trans_start();
        
        foreach ($order as $item) {
            if (!isset($item['id']) || !isset($item['order_num'])) {
                $this->db->trans_rollback();
                return false;
            }
            
            $this->db->where('id', $item['id']);
            $this->db->update('blocks', ['order_num' => $item['order_num']]);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function toggle_visibility($id, $visible) {
        if (!is_numeric($id) || !is_numeric($visible)) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->update('blocks', ['is_visible' => $visible]);
    }

    public function delete($id) {
        if (!is_numeric($id)) {
            return false;
        }

        // Supprimer le bloc
        $result = $this->db->delete('blocks', ['id' => $id]);
        
        if ($result) {
            // Réorganiser les ordres restants
            $this->db->order_by('order_num', 'ASC');
            $blocks = $this->db->get('blocks')->result_array();
            
            $order = 1;
            foreach ($blocks as $block) {
                $this->db->where('id', $block['id']);
                $this->db->update('blocks', ['order_num' => $order]);
                $order++;
            }
        }
        
        return $result;
    }
}
