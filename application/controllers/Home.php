<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data = array(
			'title' => 'SortLead', 
			'description' => '',
			'leads' => $this->db->get('pages_lead')->result()
		);
		$this->load->view('site/home',$data);
	}
	public function view($slug){
		$page = $this->db->where(array('slug' => $slug))->get('pages_lead')->row();
		if ($page) {
			$data = array(
				'page' => $page,
				'title' => $page->titre_seo, 
				'description' => $page->desc_seo
			);
			$this->load->view('site/page_lead',$data);
		}else{
			//show_404();
			redirect('ErrorController/error404');
		}
	}
}
