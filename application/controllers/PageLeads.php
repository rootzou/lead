<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageLeads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PageLead_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        $data['title'] = 'Gestion des pages leads';
        $this->load->view('admin/pageslead/list', $data);
    }

    public function get_pages_lead_new() {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $search = $this->input->get('search');
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $total_rows = $this->PageLead_model->count_all($search);
        $pages = $this->PageLead_model->get_all($limit, $offset, $search);

        $total_pages = ceil($total_rows / $limit);

        $response = [
            'directories' => $pages,
            'current_page' => (int)$page,
            'total_pages' => $total_pages,
            'total_rows' => $total_rows
        ];

        echo json_encode($response);
    }

    public function add() {
        $data['title'] = 'Ajouter une page lead';
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('titre_seo', 'Titre SEO', 'required');
            $this->form_validation->set_rules('desc_seo', 'Description SEO', 'required');
            $this->form_validation->set_rules('titre_h1', 'Titre H1', 'required');
            $this->form_validation->set_rules('slug', 'Slug', 'required|is_unique[pages_lead.slug]');
            
            for($i = 1; $i <= 5; $i++) {
                $this->form_validation->set_rules('bloc'.$i.'_titre', 'Titre Bloc '.$i, 'required');
                $this->form_validation->set_rules('bloc'.$i.'_contenu', 'Contenu Bloc '.$i, 'required');
            }

            if ($this->form_validation->run()) {
                $data = [
                    'titre_seo' => $this->input->post('titre_seo'),
                    'desc_seo' => $this->input->post('desc_seo'),
                    'titre_h1' => $this->input->post('titre_h1'),
                    'slug' => $this->input->post('slug')
                ];

                // Gestion de l'upload de photo
                if ($_FILES['photo']['name']) {
                    $config['upload_path'] = './uploads/pages/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = uniqid('page_');

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('photo')) {
                        $upload_data = $this->upload->data();
                        $data['photo'] = 'uploads/pages/' . $upload_data['file_name'];
                    }
                }

                // Ajout des blocs de contenu
                for($i = 1; $i <= 5; $i++) {
                    $data['bloc'.$i.'_titre'] = $this->input->post('bloc'.$i.'_titre');
                    $data['bloc'.$i.'_contenu'] = $this->input->post('bloc'.$i.'_contenu');
                }

                if ($this->PageLead_model->create($data)) {
                    $this->session->set_flashdata('success', 'Page lead créée avec succès');
                    redirect('admin/pageslead');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de la création de la page');
                }
            }
        }

        $this->load->view('admin/pageslead/add', $data);
    }

    public function edit($id) {
        $data['title'] = 'Modifier la page lead';
        $data['page'] = $this->PageLead_model->get_by_id($id);

        if (!$data['page']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('titre_seo', 'Titre SEO', 'required');
            $this->form_validation->set_rules('desc_seo', 'Description SEO', 'required');
            $this->form_validation->set_rules('titre_h1', 'Titre H1', 'required');
            $this->form_validation->set_rules('slug', 'Slug', 'required|callback_check_slug['.$id.']');
            
            for($i = 1; $i <= 5; $i++) {
                $this->form_validation->set_rules('bloc'.$i.'_titre', 'Titre Bloc '.$i, 'required');
                $this->form_validation->set_rules('bloc'.$i.'_contenu', 'Contenu Bloc '.$i, 'required');
            }

            if ($this->form_validation->run()) {
                $update_data = [
                    'titre_seo' => $this->input->post('titre_seo'),
                    'desc_seo' => $this->input->post('desc_seo'),
                    'titre_h1' => $this->input->post('titre_h1'),
                    'slug' => $this->input->post('slug')
                ];

                // Gestion de l'upload de photo
                if ($_FILES['photo']['name']) {
                    $config['upload_path'] = './uploads/pages/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = uniqid('page_');

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('photo')) {
                        // Supprimer l'ancienne photo si elle existe
                        if ($data['page']->photo && file_exists('./' . $data['page']->photo)) {
                            unlink('./' . $data['page']->photo);
                        }
                        
                        $upload_data = $this->upload->data();
                        $update_data['photo'] = 'uploads/pages/' . $upload_data['file_name'];
                    }
                }

                // Mise à jour des blocs de contenu
                for($i = 1; $i <= 5; $i++) {
                    $update_data['bloc'.$i.'_titre'] = $this->input->post('bloc'.$i.'_titre');
                    $update_data['bloc'.$i.'_contenu'] = $this->input->post('bloc'.$i.'_contenu');
                }

                if ($this->PageLead_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Page lead mise à jour avec succès');
                    redirect('admin/pageslead');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de la mise à jour de la page');
                }
            }
        }

        $this->load->view('admin/pageslead/edit', $data);
    }

    // public function delete($id) {
    //     $page = $this->PageLead_model->get_by_id($id);
        
    //     if (!$page) {
    //         $this->session->set_flashdata('error', 'Page introuvable');
    //         redirect('admin/pageslead');
    //     }

    //     // Supprimer la photo si elle existe
    //     if ($page->photo && file_exists('./' . $page->photo)) {
    //         unlink('./' . $page->photo);
    //     }

    //     if ($this->PageLead_model->delete($id)) {
    //         $this->session->set_flashdata('success', 'Page supprimée avec succès');
    //     } else {
    //         $this->session->set_flashdata('error', 'Erreur lors de la suppression de la page');
    //     }

    //     redirect('admin/pageslead');
    // }

    public function view($slug) {
        $data['page'] = $this->PageLead_model->get_by_slug($slug);
        
        if (!$data['page']) {
            show_404();
        }

        $this->load->view('public/page', $data);
    }

    // Fonction de validation personnalisée pour le slug
    public function check_slug($slug, $id) {
        $existing = $this->PageLead_model->get_by_slug($slug);
        
        if ($existing && $existing->id != $id) {
            $this->form_validation->set_message('check_slug', 'Ce slug est déjà utilisé');
            return FALSE;
        }
        
        return TRUE;
    }


    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('pages_lead');
        $this->session->set_flashdata('success','Page lead supprimée avec succès');
        redirect('admin/pageslead');
    }
}
