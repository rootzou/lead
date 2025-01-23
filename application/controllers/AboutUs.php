<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('aboutus_model');
    }

    // public function index() {
    //     // Ne pas définir le type de contenu comme JSON pour la vue principale
    //     $this->output->set_content_type('text/html');
    //     $this->load->view('about_us_view');
    // }

    // Afficher la vue de la page About Us
    public function index() {
        $this->load->view('page_lead');
    }

    public function get_content() {
        // Définir le type JSON uniquement pour les requêtes AJAX
        $this->output->set_content_type('application/json');
        
        $block_id = $this->input->get('block_id');
        if (!$block_id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'ID du bloc non spécifié'
            ]));
            return;
        }

        $content = $this->aboutus_model->get_content($block_id);
        $this->output->set_output(json_encode([
            'success' => true,
            'data' => $content
        ]));
    }

    public function update_content() {
        // Définir le type JSON uniquement pour les requêtes AJAX
        $this->output->set_content_type('application/json');
        
        $block_id = $this->input->post('block_id');
        if (!$block_id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'ID du bloc non spécifié'
            ]));
            return;
        }

        $data = [
            'title' => $this->input->post('title'),
            'subtitle' => $this->input->post('subtitle'),
            'image_url' => $this->input->post('image_url'),
            'video_url' => $this->input->post('video_url')
        ];

        if ($this->aboutus_model->update_content($block_id, $data)) {
            $this->output->set_output(json_encode([
                'success' => true,
                'message' => 'Contenu mis à jour avec succès'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du contenu'
            ]));
        }
    }

    public function add_block() {
        $this->output->set_content_type('application/json');
        
        $data = [
            'title' => $this->input->post('title'),
            'subtitle' => $this->input->post('subtitle'),
            'image_url' => $this->input->post('image_url'),
            'video_url' => $this->input->post('video_url')
        ];

        $block_id = $this->aboutus_model->add_block($data);
        if ($block_id) {
            $this->output->set_output(json_encode([
                'success' => true,
                'message' => 'Bloc ajouté avec succès',
                'block_id' => $block_id
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du bloc'
            ]));
        }
    }
}
