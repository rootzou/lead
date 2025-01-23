<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directory_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_directories_datatable($limit, $start, $order_column = null, $order_dir = 'ASC', $search = '') {
        $columns = array(
            0 => 'logo',
            1 => 'name',
            2 => 'website_url',
            3 => 'location',
            4 => 'contact_email',
            5 => 'status'
        );
        
        try {
            $this->db->start_cache();
            
            // Sélection des colonnes
            $this->db->select('id, logo, cover_image, name, website_url, location, contact_email, status');
            $this->db->from('directories');
            
            // Recherche
            if(!empty($search)) {
                $this->db->group_start();
                $this->db->like('name', $search);
                $this->db->or_like('website_url', $search);
                $this->db->or_like('location', $search);
                $this->db->or_like('contact_email', $search);
                $this->db->group_end();
            }
            
            // Compter le nombre total de résultats filtrés
            $filtered_count = $this->db->count_all_results('', false);
            
            // Tri
            if($order_column !== null && isset($columns[$order_column])) {
                $this->db->order_by($columns[$order_column], $order_dir);
            } else {
                $this->db->order_by('name', 'ASC');
            }
            
            // Pagination
            if($limit != -1) {
                $this->db->limit($limit, $start);
            }
            
            // Exécution de la requête
            $query = $this->db->get();
            
            // Log de la requête SQL
            log_message('debug', 'SQL Query: ' . $this->db->last_query());
            
            $this->db->stop_cache();
            $this->db->flush_cache();
            
            // Compter le nombre total d'enregistrements (sans filtre)
            $total_count = $this->db->count_all('directories');
            
            return array(
                'data' => $query->result(),
                'recordsTotal' => $total_count,
                'recordsFiltered' => $filtered_count
            );
            
        } catch (Exception $e) {
            log_message('error', 'Erreur dans get_directories_datatable : ' . $e->getMessage());
            return array(
                'data' => array(),
                'recordsTotal' => 0,
                'recordsFiltered' => 0
            );
        }
    }
    
    public function count_directories($search = null) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('directories');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('website_url', $search);
            $this->db->or_like('location', $search);
            $this->db->or_like('contact_email', $search);
            $this->db->group_end();
        }
        
        $query = $this->db->get();
        $result = $query->row();
        return $result->count;
    }
    
    public function get_directories($limit = null, $offset = null, $search = null) {
        $this->db->select('*');
        $this->db->from('directories');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('website_url', $search);
            $this->db->or_like('location', $search);
            $this->db->or_like('contact_email', $search);
            $this->db->group_end();
        }
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Récupère un répertoire avec ses services
     */
    public function get_directory($id) {
        // Récupérer le répertoire
        $directory = $this->db->get_where('directories', ['id' => $id])->row();
        
        if ($directory) {
            // Récupérer les services associés
            $this->db->select('s.id, s.name');
            $this->db->from('services s');
            $this->db->join('directory_services ds', 'ds.service_id = s.id');
            $this->db->where('ds.directory_id', $id);
            $query = $this->db->get();
            
            $directory->services = $query->result();
        }
        
        return $directory;
    }

    /**
     * Met à jour un répertoire
     */
    public function update_directory($id, $data) {
        $this->db->trans_start();
        
        try {
            // Mettre à jour le répertoire
            $this->db->where('id', $id);
            $this->db->update('directories', $data);
            
            if ($this->db->affected_rows() < 0) {
                throw new Exception('Erreur lors de la mise à jour');
            }
            
            $this->db->trans_complete();
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Erreur mise à jour répertoire: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour les services d'un répertoire
     */
    public function update_directory_services($directory_id, $services) {
        $this->db->trans_start();
        
        try {
            // Supprimer les anciens services
            $this->db->where('directory_id', $directory_id);
            $this->db->delete('directory_services');
            
            // Ajouter les nouveaux services
            if (!empty($services)) {
                $service_data = [];
                foreach ($services as $service_id) {
                    $service_data[] = [
                        'directory_id' => $directory_id,
                        'service_id' => $service_id
                    ];
                }
                
                if (!empty($service_data)) {
                    $this->db->insert_batch('directory_services', $service_data);
                    
                    if ($this->db->affected_rows() < 1) {
                        throw new Exception('Erreur lors de l\'ajout des services');
                    }
                }
            }
            
            $this->db->trans_complete();
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Erreur mise à jour services: ' . $e->getMessage());
            return false;
        }
    }
    
    public function add_directory($data) {
        // Extraire les services du tableau de données
        $services = isset($data['services']) ? $data['services'] : [];
        unset($data['services']);
        
        // Insérer l'entreprise
        $this->db->insert('directories', $data);
        $directory_id = $this->db->insert_id();
        
        // Insérer les services si l'entreprise a été créée avec succès
        if ($directory_id && !empty($services)) {
            $service_data = array();
            foreach ($services as $service_id) {
                $service_data[] = array(
                    'directory_id' => $directory_id,
                    'service_id' => $service_id
                );
            }
            if (!empty($service_data)) {
                $this->db->insert_batch('directory_services', $service_data);
            }
        }
        
        return $directory_id;
    }
    
    public function delete_directory($id) {
        $this->db->where('id', $id);
        return $this->db->delete('directories');
    }
    
    // Ajouter ces nouvelles méthodes pour la gestion du portfolio
    
    public function get_portfolio($directory_id) {
        $this->db->where('directory_id', $directory_id);
        $query = $this->db->get('directory_portfolio');
        return $query->result();
    }

    public function add_portfolio_item($data) {
        return $this->db->insert('directory_portfolio', $data);
    }

    public function delete_portfolio_item($id) {
        $this->db->where('id', $id);
        return $this->db->delete('directory_portfolio');
    }

    public function get_portfolio_item($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('directory_portfolio');
        return $query->row();
    }
    
    public function get_directory_with_services($id) {
        // Get directory info
        $directory = $this->get_directory($id);
        
        if ($directory) {
            // Get services for this directory
            $this->db->select('services.*');
            $this->db->from('services');
            $this->db->join('directory_services', 'directory_services.service_id = services.id');
            $this->db->where('directory_services.directory_id', $id);
            $directory->services = $this->db->get()->result();
        }
        
        return $directory;
    }
    public function get_directories_by_service($slug) {
        $this->db->select('directories.*');
        $this->db->from('directories');
        $this->db->join('directory_services', 'directory_services.directory_id = directories.id');
        $this->db->join('services', 'services.id = directory_services.service_id');
        $this->db->where('services.slug', $slug);
        $query = $this->db->get();
        return $query->result();
    }
}
