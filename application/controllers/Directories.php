<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directories extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('directory_model');
        $this->load->model('service_model');
        $this->load->helper('auth');
        is_logged_in();
    }
    
    public function index() {
        $data['title'] = 'Liste des entreprises';
        $this->load->view('admin/directory/list', $data);
    }
    
    public function get_directories() {
        // Vérifier si c'est une requête AJAX
        if (!$this->input->is_ajax_request()) {
            $this->output->set_status_header(400);
            exit('Accès direct au script non autorisé');
        }

        try {
            // Récupérer les paramètres de DataTables
            $draw = intval($this->input->post('draw'));
            $start = intval($this->input->post('start'));
            $length = intval($this->input->post('length'));
            $search = $this->input->post('search');
            $order = $this->input->post('order');

            // Log des paramètres reçus
            log_message('debug', 'Paramètres DataTables reçus : ' . json_encode([
                'draw' => $draw,
                'start' => $start,
                'length' => $length,
                'search' => $search,
                'order' => $order
            ]));

            // Paramètres de tri
            $order_column = isset($order[0]['column']) ? intval($order[0]['column']) : 1;
            $order_dir = isset($order[0]['dir']) ? $order[0]['dir'] : 'ASC';
            
            // Paramètre de recherche
            $search_value = isset($search['value']) ? $search['value'] : '';

            // Obtenir les résultats depuis le modèle
            $result = $this->directory_model->get_directories_datatable($length, $start, $order_column, $order_dir, $search_value);
            
            // Log du résultat de la requête
            log_message('debug', 'Résultat de la requête : ' . json_encode($result));

            $data = array();
            if (!empty($result['data'])) {
                foreach ($result['data'] as $directory) {
                    $row = array();
                    
                    // Logo
                    $logo_html = '';
                    if($directory->logo && file_exists(FCPATH . 'uploads/directories/' . $directory->logo)) {
                        $logo_html = '<img src="'.base_url('uploads/directories/'.$directory->logo).'" alt="'.$directory->name.'" class="img-fluid" style="max-width: 50px;">';
                    }
                    $row[] = $logo_html;
                    
                    // Autres colonnes
                    $row[] = htmlspecialchars($directory->name);
                    $row[] = $directory->website_url ? '<a href="'.htmlspecialchars($directory->website_url).'" target="_blank">'.htmlspecialchars($directory->website_url).'</a>' : '';
                    $row[] = htmlspecialchars($directory->location);
                    $row[] = htmlspecialchars($directory->contact_email);
                    
                    // Statut
                    $status_class = $directory->status == 'active' ? 'bg-success' : 'bg-danger';
                    $status_text = $directory->status == 'active' ? 'Actif' : 'Inactif';
                    $row[] = '<span class="badge '.$status_class.'">'.$status_text.'</span>';
                    
                    // Actions
                    $actions = '<div class="btn-group">';
                    $actions .= '<a href="'.base_url('admin/directory/edit/'.$directory->id).'" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a> ';
                    $actions .= '<a href="'.base_url('admin/directory/delete/'.$directory->id).'" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet annuaire ?\');"><i class="fas fa-trash"></i></a>';
                    $actions .= '</div>';
                    $row[] = $actions;
                    
                    $data[] = $row;
                }
            }
            
            // Préparer la sortie pour DataTables
            $output = array(
                "draw" => $draw,
                "recordsTotal" => $result['recordsTotal'],
                "recordsFiltered" => $result['recordsFiltered'],
                "data" => $data
            );
            
            // Log de la sortie finale
            log_message('debug', 'Sortie finale : ' . json_encode($output));

            // Envoyer la réponse en JSON
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));

        } catch (Exception $e) {
            log_message('error', 'Erreur dans get_directories : ' . $e->getMessage());
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'error' => true,
                    'message' => 'Une erreur est survenue lors du traitement de la requête'
                ]));
        }
    }
    
    public function get_directories_new() {
        // Vérifier si la table existe
        if (!$this->db->table_exists('directories')) {
            log_message('error', 'Table directories does not exist');
            $data = [
                'directories' => [],
                'total_pages' => 0,
                'current_page' => 1,
                'total_rows' => 0,
                'error' => 'Table not found'
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }

        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $search = $this->input->get('search');
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Log des paramètres
        log_message('debug', 'GET params: ' . json_encode($_GET));
        
        $total_rows = $this->directory_model->count_directories($search);
        $directories = $this->directory_model->get_directories($limit, $offset, $search);

        // Log des résultats
        log_message('debug', 'Total rows: ' . $total_rows);
        log_message('debug', 'Directories count: ' . count($directories));
        log_message('debug', 'Last query: ' . $this->db->last_query());

        // Formater les données pour l'affichage
        $formatted_directories = array_map(function($directory) {
            return [
                'id' => $directory->id,
                'logo' => $directory->logo,
                'name' => $directory->name,
                'website_url' => $directory->website_url,
                'location' => $directory->location,
                'contact_email' => $directory->contact_email,
                'status' => $directory->status
            ];
        }, $directories);

        $data = [
            'directories' => $formatted_directories,
            'total_pages' => ceil($total_rows / $limit),
            'current_page' => (int)$page,
            'total_rows' => $total_rows
        ];

        // Log de la réponse
        log_message('debug', 'Response: ' . json_encode($data));

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    public function search() {
        $search = $this->input->get('q');
        $directories = $this->directory_model->get_all_directories(null, null, $search);
        echo json_encode($directories);
    }
    
    public function add()
    {
        $this->load->model('Service_model');
        $services = $this->Service_model->get_all_services();
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
    
    public function edit($id) {
        // Charger les modèles et données nécessaires
        $this->load->model('Service_model');
        $directory = $this->directory_model->get_directory($id);
        
        if (!$directory) {
            $this->session->set_flashdata('error', 'Entreprise non trouvée');
            redirect('admin/directory');
        }
        
        // Préparer les données pour la vue
        $data['directory'] = $directory;
        $data['services'] = $this->Service_model->get_all_services();
        
        if ($this->input->post()) {
            // Validation du formulaire
            $this->form_validation->set_rules('name', 'Nom', 'trim|required');
            $this->form_validation->set_rules('pays', 'Pays', 'trim|required');
            
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                $this->load->view('admin/directory/edit', $data);
                return;
            }
            
            // Préparer les données à mettre à jour
            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'website_url' => $this->input->post('website_url'),
                'location' => $this->input->post('location'),
                'pays' => $this->input->post('pays'),
                'contact_email' => $this->input->post('contact_email'),
                'contact_phone' => $this->input->post('contact_phone'),
                'status' => $this->input->post('status')
            );
            
            // Gestion des fichiers
            if (!empty($_FILES['logo']['name'])) {
                $config['upload_path'] = './uploads/directories/logos/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('logo')) {
                    if ($directory->logo && file_exists('./uploads/directories/logos/' . $directory->logo)) {
                        unlink('./uploads/directories/logos/' . $directory->logo);
                    }
                    $upload_data = $this->upload->data();
                    $update_data['logo'] = $upload_data['file_name'];
                }
            }
            
            if (!empty($_FILES['cover_image']['name'])) {
                $config['upload_path'] = './uploads/directories/covers/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('cover_image')) {
                    if ($directory->cover_image && file_exists('./uploads/directories/covers/' . $directory->cover_image)) {
                        unlink('./uploads/directories/covers/' . $directory->cover_image);
                    }
                    $upload_data = $this->upload->data();
                    $update_data['cover_image'] = $upload_data['file_name'];
                }
            }
            
            // Mise à jour du répertoire et des services
            $this->db->trans_start();
            
            $success = true;
            $error_message = '';
            
            // Mettre à jour le répertoire
            if (!$this->directory_model->update_directory($id, $update_data)) {
                $success = false;
                $error_message = 'Erreur lors de la mise à jour des informations';
            }
            
            // Mettre à jour les services si la première mise à jour a réussi
            if ($success) {
                $services = $this->input->post('services');
                if (!$this->directory_model->update_directory_services($id, $services ? $services : [])) {
                    $success = false;
                    $error_message = 'Erreur lors de la mise à jour des services';
                }
            }
            
            $this->db->trans_complete();
            
            if ($success && $this->db->trans_status() !== FALSE) {
                $this->session->set_flashdata('success', 'L\'entreprise a été mise à jour avec succès');
                redirect('admin/directory');
            } else {
                $this->session->set_flashdata('error', $error_message);
                $data['directory'] = $this->directory_model->get_directory($id); // Recharger les données
                $this->load->view('admin/directory/edit', $data);
            }
        } else {
            $this->load->view('admin/directory/edit', $data);
        }
    }
    
    public function portfolio($id) {
        $data['directory'] = $this->directory_model->get_directory($id);
        
        if (!$data['directory']) {
            show_404();
        }
        
        $data['portfolio'] = $this->directory_model->get_portfolio($id);
        $data['title'] = 'Portfolio - ' . $data['directory']->name;
        
        $this->load->view('admin/directory/portfolio', $data);
    }
    
    public function add_portfolio($directory_id) {
        // Configuration pour l'upload
        $config['upload_path'] = './uploads/portfolio/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        // Créer le dossier s'il n'existe pas
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('project_image')) {
            $this->session->set_flashdata('error', 'Erreur lors du téléchargement : ' . $this->upload->display_errors());
            redirect('admin/directory/portfolio/' . $directory_id);
            return;
        }

        $upload_data = $this->upload->data();
        
        $portfolio_data = [
            'directory_id' => $directory_id,
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'project_date' => $this->input->post('project_date'),
            'image' => $upload_data['file_name'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->directory_model->add_portfolio_item($portfolio_data)) {
            $this->session->set_flashdata('success', 'Projet ajouté avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de l\'ajout du projet');
        }
        redirect('admin/directory/portfolio/' . $directory_id);
    }
    
    public function delete_portfolio($id) {
        $item = $this->directory_model->get_portfolio_item($id);
        
        if ($item && $item->image) {
            $image_path = './uploads/portfolio/' . $item->image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        if ($this->directory_model->delete_portfolio_item($id)) {
            echo json_encode(['success' => true]);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Erreur lors de la suppression']);
        }
    }
    
    public function delete($id) {
        if ($this->directory_model->delete_directory($id)) {
            $this->session->set_flashdata('success', 'Annuaire supprimé avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur lors de la suppression');
        }
        redirect('admin/directory');
    }



    // public function get_directory_by_services() {
    //     $this->db->select('users.name, orders.order_date, order_items.product_name, order_items.quantity');
    //     $this->db->from('users');
    //     $this->db->join('orders', 'users.id = orders.user_id');
    //     $this->db->join('order_items', 'orders.id = order_items.order_id');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getbyservice($slug){
        $this->db->select('directories.*, services.name as service_name');
        $this->db->from('directories');
        $this->db->join('directory_services', 'directory_services.directory_id = directories.id');
        $this->db->join('services', 'services.id = directory_services.service_id');
        $this->db->where('services.slug', $slug);
        $this->db->order_by('directories.id','DESC');
        $query = $this->db->get()->result();
        $data = array(
            'service' => $this->db->get_where('services', ['slug' => $slug])->row(),
            'directories'=> $query
        );
        $this->load->view('site/directories/getbyservice', $data);
    }
}
