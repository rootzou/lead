<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getParams')) {
    function getParams() {
        // Obtenir l'instance de CI
        $CI =& get_instance();       
        // Charger la bibliothèque database si ce n'est pas déjà fait
        if (!isset($CI->db)) {
            $CI->load->database();
        }
        // Récupérer les paramètres avec l'ID 1
        $CI->db->where('id', 1);
        $query = $CI->db->get('settings');
        
        // Vérifier si des résultats existent
        if ($query->num_rows() > 0) {
            // Retourner le premier résultat sous forme d'objet
            return $query->row();
        }       
        // Retourner null si aucun paramètre n'est trouvé
        return null;
    }
}
