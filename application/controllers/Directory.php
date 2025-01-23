<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Directory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('directory_model');
        $this->load->helper('auth');
        $this->load->library('upload');
        is_logged_in();
    }

    public function index()
    {
        $data['directories'] = $this->directory_model->get_all_directories();
        $this->load->view('admin/directory/list', $data);
    }

 


    public function add()
    {
        $this->load->model('services_model');
        $services = $this->services_model->get_all_services();
        $data['services'] = $services;

        // Créer les dossiers s'ils n'existent pas
        if (!is_dir('./uploads/directories/logos/')) {
            mkdir('./uploads/directories/logos/', 0777, true);
        }
        if (!is_dir('./uploads/directories/covers/')) {
            mkdir('./uploads/directories/covers/', 0777, true);
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nom', 'trim|required');
            $this->form_validation->set_rules('pays', 'Pays', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Veuillez remplir correctement le formulaire');
                $this->load->view('admin/directory/add', $data);
            } else {
                $data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'website_url' => $this->input->post('website_url'),
                    'location' => $this->input->post('location'),
                    'contact_email' => $this->input->post('contact_email'),
                    'contact_phone' => $this->input->post('contact_phone'),
                    'status' => 'active',
                    'pays' => $this->input->post('pays'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                // Gestion du logo
                if ($_FILES['logo']['name']) {
                    $config['upload_path'] = './uploads/directories/logos/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('logo')) {
                        $upload_data = $this->upload->data();
                        $data['logo'] = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        $this->load->view('admin/directory/add', $data);
                        return;
                    }
                }

                // Gestion de l'image de couverture
                if ($_FILES['cover_image']['name']) {
                    $config['upload_path'] = './uploads/directories/covers/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = TRUE;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('cover_image')) {
                        $upload_data = $this->upload->data();
                        $data['cover_image'] = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        $this->load->view('admin/directory/add', $data);
                        return;
                    }
                }

                // Gestion des services
                $services = $this->input->post('services');
                $data['services'] = $services;

                if ($this->directory_model->add_directory($data)) {
                    $this->session->set_flashdata('success', 'L\'entreprise a été ajoutée avec succès');
                    redirect('admin/directory');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de l\'ajout de l\'entreprise');
                    $this->load->view('admin/directory/add', $data);
                }
            }
        } else {
            $this->load->view('admin/directory/add', $data);
        }
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'website_url' => $this->input->post('website_url'),
                'location' => $this->input->post('location'),
                'pays' => $this->input->post('pays'),
                'contact_email' => $this->input->post('contact_email'),
                'contact_phone' => $this->input->post('contact_phone'),
                'status' => $this->input->post('status')
            );

            if ($_FILES['logo']['name']) {
                $config['upload_path'] = './uploads/directories/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 2048;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('logo')) {
                    $upload_data = $this->upload->data();
                    $data['logo'] = $upload_data['file_name'];
                }
            }

            if ($this->directory_model->update_directory($id, $data)) {
                $this->session->set_flashdata('success', 'Annuaire mis à jour avec succès');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la mise à jour');
            }
            redirect('admin/directory');
        }

        $data['directory'] = $this->directory_model->get_directory($id);
        $this->load->view('admin/directory/edit', $data);
    }

    public function delete($id)
    {
        if ($this->directory_model->delete_directory($id)) {
            $this->session->set_flashdata('success', 'Annuaire supprimé avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la suppression');
        }
        redirect('admin/directory');
    }
}
