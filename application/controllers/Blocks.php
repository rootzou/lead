<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocks extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('blocks_model');
        $this->output->set_content_type('application/json');
        
        // Activer les logs
        $this->load->library('session');
        
        // Test de connexion à la base de données
        if (!$this->db->conn_id) {
            log_message('error', 'Database connection failed');
            show_error('Database connection failed');
        }
        
        // Vérifier si la table blocks existe
        if (!$this->db->table_exists('blocks')) {
            log_message('error', 'Table blocks does not exist');
            show_error('Table blocks does not exist');
        }
        
        log_message('debug', 'Blocks Controller initialized');
    }

    public function get_all() {
        log_message('debug', 'Getting all blocks');
        $blocks = $this->blocks_model->get_all();
        log_message('debug', 'Retrieved blocks: ' . print_r($blocks, true));
        
        $this->output->set_output(json_encode([
            'success' => true,
            'data' => $blocks
        ]));
    }

    public function add() {
        $type = $this->input->post('type');
        log_message('debug', 'Adding block of type: ' . $type);
        
        if (empty($type)) {
            log_message('error', 'Block type not specified');
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Type de bloc non spécifié'
            ]));
            return;
        }

        $result = $this->blocks_model->add($type);
        log_message('debug', 'Add block result: ' . ($result ? 'success' : 'failure'));
        
        $this->output->set_output(json_encode([
            'success' => $result !== false,
            'message' => $result ? 'Bloc ajouté avec succès' : 'Erreur lors de l\'ajout du bloc'
        ]));
    }

    public function update_order() {
        $order = $this->input->post('order');
        log_message('debug', 'Updating order: ' . print_r($order, true));
        
        if (empty($order)) {
            log_message('error', 'Order data not specified');
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Ordre non spécifié'
            ]));
            return;
        }

        $result = $this->blocks_model->update_order($order);
        log_message('debug', 'Update order result: ' . ($result ? 'success' : 'failure'));
        
        $this->output->set_output(json_encode([
            'success' => $result,
            'message' => $result ? 'Ordre mis à jour' : 'Erreur lors de la mise à jour de l\'ordre'
        ]));
    }

    public function toggle_visibility() {
        $id = $this->input->post('id');
        $visible = $this->input->post('visible');
        log_message('debug', "Toggling visibility for block $id to $visible");
        
        if (!isset($id) || !isset($visible)) {
            log_message('error', 'ID or visibility not specified');
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'ID ou visibilité non spécifié'
            ]));
            return;
        }

        $result = $this->blocks_model->toggle_visibility($id, $visible);
        log_message('debug', 'Toggle visibility result: ' . ($result ? 'success' : 'failure'));
        
        $this->output->set_output(json_encode([
            'success' => $result,
            'message' => $result ? 'Visibilité mise à jour' : 'Erreur lors de la mise à jour de la visibilité'
        ]));
    }

    public function delete() {
        $id = $this->input->post('id');
        log_message('debug', "Deleting block $id");
        
        if (!isset($id)) {
            log_message('error', 'ID not specified');
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'ID non spécifié'
            ]));
            return;
        }

        $result = $this->blocks_model->delete($id);
        log_message('debug', 'Delete result: ' . ($result ? 'success' : 'failure'));
        
        $this->output->set_output(json_encode([
            'success' => $result,
            'message' => $result ? 'Bloc supprimé' : 'Erreur lors de la suppression'
        ]));
    }
}
