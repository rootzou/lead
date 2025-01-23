<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Controller Settings.php
class Blocs extends CI_Controller {

    public function index() {
        $data = array(
            'title' => 'Liste des bloc',
        );
        $this->load->view('admin/blocs/index', $data);
    }

    public function create(){
        $data = array(
            'title' => 'Création du bloc HTML',
        );
        $this->load->view('admin/blocs/create', $data);
    }

    public function add() {
        $this->form_validation->set_rules('titre', 'Titre', 'required|min_length[3]');
        $this->form_validation->set_rules('contenu', 'contenue', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = $this->input->post();         
            $this->db->insert('blocs_html', $data);
            $this->session->set_flashdata('success', 'Bloc HTML ajouté avec succès');
            redirect('blocs');
        }
    }
}
