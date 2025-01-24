<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageLead_model extends CI_Model {

    private $table = 'pages_lead';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = null, $search = null) {
        if ($search) {
            $this->db->group_start();
            $this->db->like('titre_h1', $search);
            $this->db->or_like('slug', $search);
            $this->db->group_end();
        }

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function count_all($search = null) {
        if ($search) {
            $this->db->group_start();
            $this->db->like('titre_h1', $search);
            $this->db->or_like('slug', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_by_slug($slug) {
        return $this->db->get_where($this->table, ['slug' => $slug])->row();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        // First delete associated blocks
        $this->db->where('page_lead_id', $id);
        $this->db->delete('bloc_pages_lead');

        // Then delete the page lead
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->delete($this->table);
    }

    public function insert_block($data) {
        return $this->db->insert('bloc_pages_lead', $data);
    }

    public function update_block($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('bloc_pages_lead', $data);
    }

    public function delete_block($id) {
        $this->db->where('id', $id);
        return $this->db->delete('bloc_pages_lead');
    }
    public function get_blocks($id) {
        return $this->db->get_where('bloc_pages_lead', ['id' => $id])->row();
    }
}
