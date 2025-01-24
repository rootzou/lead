<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageLeads extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PageLead_model');
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = 'Gestion des pages leads';
        $this->load->view('admin/pageslead/list', $data);
    }

    public function get_pages_lead_new()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $search = $this->input->get('search');
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $total_rows = $this->PageLead_model->count_all($search);
        $pages = $this->PageLead_model->get_all($limit, $offset, $search);

        $total_pages = ceil($total_rows / $limit);

        $response = [
            'directories' => $pages,
            'current_page' => (int) $page,
            'total_pages' => $total_pages,
            'total_rows' => $total_rows
        ];

        echo json_encode($response);
    }

    public function add()
    {
        $data['title'] = 'Ajouter une page lead';

        if ($this->input->post()) {
            $this->form_validation->set_rules('titre_seo', 'Titre SEO', 'required');
            $this->form_validation->set_rules('desc_seo', 'Description SEO', 'required');
            $this->form_validation->set_rules('titre_h1', 'Titre H1', 'required');
            $this->form_validation->set_rules('slug', 'Slug', 'required|is_unique[pages_lead.slug]');

            if ($this->form_validation->run()) {
                $this->db->trans_start();

                try {
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
                        } else {
                            throw new Exception("Error uploading photo", 1);
                        }
                    }

                    // Insert page lead
                    $pageLeadId = $this->PageLead_model->create($data);

                    if ($pageLeadId) {
                        // Insert blocks into bloc_pages_lead
                        $blocks = $this->input->post('blocks');
                        $i = 0; // Assuming blocks are sent as an array
                        foreach ($blocks as $blockContent) {
                            $i++;
                            $blockData = [
                                'page_lead_id' => $pageLeadId,
                                'content' => $blockContent,
                                'ordere' => $i
                            ];
                            if (!$this->PageLead_model->insert_block($blockData)) {
                                throw new Exception("Error inserting block", 1);
                            }
                        }
                    } else {
                        throw new Exception("Error inserting page lead", 1);
                    }

                    $this->db->trans_complete();

                    if ($this->db->trans_status() === TRUE) {
                        $this->session->set_flashdata("success", "Page lead créée avec succès");
                    } else {
                        $this->session->set_flashdata("error", "Transaction failed");
                    }

                } catch (Exception $e) {
                    $this->session->set_flashdata("error", $e->getMessage());
                    $this->db->trans_rollback();
                }

            }
           
           
            //  $blocks = $this->input->post('blocs');
            //  echo gettype($blocks);
            // echo "<pre>";
            //     print_r($_POST);
            // echo "</pre>";
        }

        $this->load->view('admin/pageslead/add', $data);
    }

    // public function edit($id)
    // {
    //     $data['title'] = 'Modifier la page lead';
    //     $data['page'] = $this->PageLead_model->get_by_id($id);

    //     if (!$data['page']) {
    //         show_404();
    //     }

    //     if ($this->input->post()) {
    //         $this->form_validation->set_rules('titre_seo', 'Titre SEO', 'required');
    //         $this->form_validation->set_rules('desc_seo', 'Description SEO', 'required');
    //         $this->form_validation->set_rules('titre_h1', 'Titre H1', 'required');
    //         $this->form_validation->set_rules('slug', 'Slug', 'required|callback_check_slug[' . $id . ']');

    //         if ($this->form_validation->run()) {
    //             $update_data = [
    //                 'titre_seo' => $this->input->post('titre_seo'),
    //                 'desc_seo' => $this->input->post('desc_seo'),
    //                 'titre_h1' => $this->input->post('titre_h1'),
    //                 'slug' => $this->input->post('slug')
    //             ];

    //             // Gestion de l'upload de photo
    //             if ($_FILES['photo']['name']) {
    //                 $config['upload_path'] = './uploads/pages/';
    //                 $config['allowed_types'] = 'gif|jpg|jpeg|png';
    //                 $config['max_size'] = 2048;
    //                 $config['file_name'] = uniqid('page_');

    //                 $this->upload->initialize($config);

    //                 if ($this->upload->do_upload('photo')) {
    //                     // Supprimer l'ancienne photo si elle existe
    //                     if ($data['page']->photo && file_exists('./' . $data['page']->photo)) {
    //                         unlink('./' . $data['page']->photo);
    //                     }

    //                     $upload_data = $this->upload->data();
    //                     $update_data['photo'] = 'uploads/pages/' . $upload_data['file_name'];
    //                 }
    //             }

    //             if ($this->PageLead_model->update($id, $update_data)) {
    //                 $this->session->set_flashdata('success', 'Page lead mise à jour avec succès');
    //                 redirect('admin/pageslead');
    //             } else {
    //                 $this->session->set_flashdata('error', 'Erreur lors de la mise à jour de la page');
    //             }
    //         }
    //     }

    //     $this->load->view('admin/pageslead/edit', $data);
    // }


    public function edit($id)
    {
        $data['title'] = 'Modifier la page lead';
        $data['page'] = $this->PageLead_model->get_by_id($id);

        if (!$data['page']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('titre_seo', 'Titre SEO', 'required');
            $this->form_validation->set_rules('desc_seo', 'Description SEO', 'required');
            $this->form_validation->set_rules('titre_h1', 'Titre H1', 'required');
            $this->form_validation->set_rules('slug', 'Slug', 'required|callback_check_slug[' . $id . ']');

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

                // Gestion des blocs
                $blocks = $this->input->post('blocs');
                foreach ($blocks as $i => $block) {
                    if (empty($block['content'])) {
                        $blockId = (int) $block['id'];
                        if ($blockId > 0 && !$this->PageLead_model->delete_block($blockId)) {
                            throw new Exception("Error deleting block", 1);
                        }
                    } else {
                        $blockData = [
                            'page_lead_id' => $id,
                            'content' => $block['content'],
                            'ordere' => $i + 1
                        ];

                        if (!empty($block['id'])) {
                            $blockData['id'] = $block['id'];
                            if (!$this->PageLead_model->update_block($blockData)) {
                                throw new Exception("Error updating block", 1);
                            }
                        } else {
                            if (!$this->PageLead_model->insert_block($blockData)) {
                                throw new Exception("Error inserting block", 1);
                            }
                        }
                    }
                }

                if ($this->PageLead_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Page lead mise à jour avec succès');
                    redirect('admin/pageslead');
                } else {
                    $this->session->set_flashdata('error', 'Erreur lors de la mise à jour de la page');
                }
            }
        }

        $data['blocks'] = $this->PageLead_model->get_blocks($id);

        $this->load->view('admin/pageslead/edit', $data);
    }


    public function view($slug)
    {
        $data['page'] = $this->PageLead_model->get_by_slug($slug);

        if (!$data['page']) {
            show_404();
        }

        $this->load->view('public/page', $data);
    }

    // Fonction de validation personnalisée pour le slug
    public function check_slug($slug, $id)
    {
        $existing = $this->PageLead_model->get_by_slug($slug);

        if ($existing && $existing->id != $id) {
            $this->form_validation->set_message('check_slug', 'Ce slug est déjà utilisé');
            return FALSE;
        }

        return TRUE;
    }


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pages_lead');
        $this->session->set_flashdata('success', 'Page lead supprimée avec succès');
        redirect('admin/pageslead');
    }
}
