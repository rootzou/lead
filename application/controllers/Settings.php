<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Controller Settings.php
class Settings extends CI_Controller {

    public function index() {
        $data = array(
            'title' => 'Paramètres du site',
            'settings' => $this->db->where('id', 1)->get('settings')->row()
        );
        $this->load->view('admin/settings/index', $data);
    }

    public function update() {
        $this->form_validation->set_rules('sitename', 'Nom du site', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Téléphone', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('description', 'Description', 'required|max_length[500]');
        $this->form_validation->set_rules('copyright', 'Copyright', 'required');
        $this->form_validation->set_rules('facebook', 'Facebook', 'valid_url');
        // $this->form_validation->set_rules('instagram', 'Instagram', 'valid_url');
        // $this->form_validation->set_rules('linkedin', 'LinkedIn', 'valid_url');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = $this->input->post();

            // Upload du logo
            if (!empty($_FILES['logo']['name'])) {
                $config['upload_path'] = FCPATH . 'uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = 'logo_' . time();

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('logo')) {
                    $uploadData = $this->upload->data();
                    $data['logo'] = $uploadData['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/settings');
                }
            }

            // Upload du favicon
            if (!empty($_FILES['favicon']['name'])) {
                $config['upload_path'] = FCPATH . 'uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|ico';
                $config['file_name'] = 'favicon_' . time();

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('favicon')) {
                    $uploadData = $this->upload->data();
                    $data['favicon'] = $uploadData['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/settings');
                }
            }

            $this->db->where('id', 1);
            $this->db->update('settings', $data);
            $this->session->set_flashdata('success', 'Paramètres mis à jour avec succès');
            redirect('admin/settings');
        }
    }
}
