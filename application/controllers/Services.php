<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('service_model');
        $this->load->helper('auth');
        is_logged_in();
    }
    
    public function index() {
        $data['title'] = 'Gestion des services';
        $data['services'] = $this->service_model->get_all_services();
        $this->load->view('admin/services/list', $data);
    }
    
    public function add() {
        $data['title'] = 'Ajouter un service';
        
        if ($this->input->post()) {
            $config['upload_path'] = './uploads/services/icons/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->load->library('upload', $config);
            
            $icon = null;
            if (!empty($_FILES['icon']['name'])) {
                if ($this->upload->do_upload('icon')) {
                    $upload_data = $this->upload->data();
                    $icon = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/services/add');
                    return;
                }
            }
            
            $service_data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'icon' => $icon,
                'catservice' => $this->input->post('catservice'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->service_model->add_service($service_data)) {
                $this->session->set_flashdata('success', 'Service ajouté avec succès');
                redirect('admin/services');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de l\'ajout du service');
                redirect('admin/services/add');
            }
            return;
        }
        
        $this->load->view('admin/services/add', $data);
    }
    
    public function edit($id) {
        $data['title'] = 'Modifier un service';
        $data['service'] = $this->service_model->get_service($id);
        
        if (!$data['service']) {
            show_404();
        }
        
        if ($this->input->post()) {
            $service_data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'catservice' => $this->input->post('catservice')
            ];
            
            // Handle icon upload if provided
            if (!empty($_FILES['icon']['name'])) {
                $config['upload_path'] = './uploads/services/icons/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, true);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('icon')) {
                    $upload_data = $this->upload->data();
                    $service_data['icon'] = $upload_data['file_name'];
                    
                    // Delete old icon
                    $old_icon = $data['service']->icon;
                    if ($old_icon && file_exists($config['upload_path'] . $old_icon)) {
                        unlink($config['upload_path'] . $old_icon);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/services/edit/' . $id);
                    return;
                }
            }
            
            if ($this->service_model->update_service($id, $service_data)) {
                $this->session->set_flashdata('success', 'Service mis à jour avec succès');
                redirect('admin/services');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la mise à jour du service');
                redirect('admin/services/edit/' . $id);
            }
            return;
        }
        
        $this->load->view('admin/services/edit', $data);
    }
    
    public function delete($id) {
        $service = $this->service_model->get_service($id);
        
        if (!$service) {
            show_404();
        }
        
        // Delete icon file if exists
        if ($service->icon) {
            $icon_path = './uploads/services/icons/' . $service->icon;
            if (file_exists($icon_path)) {
                unlink($icon_path);
            }
        }
        
        if ($this->service_model->delete_service($id)) {
            $this->session->set_flashdata('success', 'Service supprimé avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la suppression du service');
        }
        
        redirect('admin/services');
    }
}
