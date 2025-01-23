<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('auth');
        is_logged_in();
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($user_id);
        $data['title'] = 'Mon Profil';
        
        $this->load->view('admin/profile/index', $data);
    }
    
    public function update() {
        $user_id = $this->session->userdata('user_id');
        
        // Validation rules
        $this->form_validation->set_rules('name', 'Nom', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Mot de passe', 'trim|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmation du mot de passe', 'trim|matches[password]');
        }
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/profile');
            return;
        }
        
        // Load upload library
        $this->load->library('upload');
        
        $update_data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email')
        ];
        
        // Handle password update if provided
        if ($this->input->post('password')) {
            $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        
        // Handle avatar upload if provided
        if (!empty($_FILES['avatar']['name'])) {
            $config['upload_path'] = './uploads/avatars/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            // Create directory if it doesn't exist
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('avatar')) {
                $upload_data = $this->upload->data();
                $update_data['avatar'] = $upload_data['file_name'];
                
                // Delete old avatar if exists
                $old_avatar = $this->user_model->get_user($user_id)->avatar;
                if ($old_avatar && file_exists($config['upload_path'] . $old_avatar)) {
                    unlink($config['upload_path'] . $old_avatar);
                }
            } else {
                $this->session->set_flashdata('error', 'Erreur lors du téléchargement de l\'avatar : ' . $this->upload->display_errors());
                redirect('admin/profile');
                return;
            }
        }
        
        if ($this->user_model->update_user($user_id, $update_data)) {
            $this->session->set_flashdata('success', 'Profil mis à jour avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la mise à jour du profil');
        }
        
        redirect('admin/profile');
    }
}
