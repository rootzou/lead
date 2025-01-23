<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        $CI =& get_instance();
        if (!$CI->session->userdata('logged_in')) {
            redirect('admin/auth');
        }
    }
}

if (!function_exists('is_admin')) {
    function is_admin() {
        $CI =& get_instance();
        if (!$CI->session->userdata('logged_in')) {
            redirect('admin/auth');
        }
        // Vous pouvez ajouter ici d'autres vérifications de rôle si nécessaire
    }
}
