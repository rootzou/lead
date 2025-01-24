<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $data['blocks'] = $this->db->get('blocks')->result();
        $this->load->view('admin/includes/header');
        $this->load->view('admin/blocks/index', $data);
        $this->load->view('admin/includes/footer');
    }

    public function add() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Titre', 'required');
            $this->form_validation->set_rules('content', 'Contenu', 'required');
            $this->form_validation->set_rules('orderB', 'Ordre', 'required|numeric');

            if ($this->form_validation->run()) {
                $data = [
                    'title' => $this->input->post('title'),
                    'content' => $this->input->post('content'),
                    'orderB' => $this->input->post('orderB')
                ];

                if ($this->db->insert('blocks', $data)) {
                    $this->session->set_flashdata('success', 'Bloc créé avec succès');
                    redirect('admin/blocks');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de la création du bloc');
                }
            }
        }

        $this->load->view('admin/includes/header');
        $this->load->view('admin/blocks/add');
        $this->load->view('admin/includes/footer');
    }

    public function edit($id) {
        $data['block'] = $this->db->get_where('blocks', ['id' => $id])->row();
        
        if (!$data['block']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Titre', 'required');
            $this->form_validation->set_rules('content', 'Contenu', 'required');
            $this->form_validation->set_rules('orderB', 'Ordre', 'required|numeric');

            if ($this->form_validation->run()) {
                $update_data = [
                    'title' => $this->input->post('title'),
                    'content' => $this->input->post('content'),
                    'orderB' => $this->input->post('orderB')
                ];

                $this->db->where('id', $id);
                if ($this->db->update('blocks', $update_data)) {
                    $this->session->set_flashdata('success', 'Bloc mis à jour avec succès');
                    redirect('admin/blocks');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de la mise à jour du bloc');
                }
            }
        }

        $this->load->view('admin/includes/header');
        $this->load->view('admin/blocks/edit', $data);
        $this->load->view('admin/includes/footer');
    }

    public function delete($id) {
        $block = $this->db->get_where('blocks', ['id' => $id])->row();
        
        if (!$block) {
            $this->session->set_flashdata('error', 'Bloc introuvable');
            redirect('admin/blocks');
        }

        if ($this->db->delete('blocks', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Bloc supprimé avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la suppression du bloc');
        }

        redirect('admin/blocks');
    }
}
