<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ErrorController extends CI_Controller {
    public function error404() {
        // Définir un code de réponse HTTP 404
        $this->output->set_status_header('404');
        // Charger la vue 404
        $this->load->view('error_404');
    }
}
