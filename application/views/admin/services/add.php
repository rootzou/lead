<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Ajouter un service</h1>
            <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <button type="button" class="btn btn-info" id="alert_demo_3_4" data-bs-toggle="modal" data-bs-target="#myModal">
                Info
            </button>
            <!-- The Modal -->
            <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tous les services possibles</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h5>1. Services financiers</h5>
                    <ul>
                        <li>Comptabilité : Gestion des finances, préparation des bilans, audits.</li>
                        <li>Conseil fiscal : Optimisation fiscale, déclaration d'impôts.</li>
                        <li>Financement : Prêts d'affaires, levées de fonds, gestion de la trésorerie.</li>
                        <li>Assurances : Assurance des biens, responsabilité civile professionnelle, assurances santé.</li>
                        <li>Gestion de trésorerie : Prévisions de cash flow, gestion des paiements et des créances.</li>
                    </ul>
                    <h5>2. Services juridiques</h5>
                    <ul>
                        <li>Création d'entreprise : Rédaction de statuts, immatriculation.</li>
                        <li>Conseil juridique : Accompagnement dans les contrats, droits des sociétés, conformité légale.</li>
                        <li>Propriété intellectuelle : Brevets, marques, droits d'auteur.</li>
                        <li>Contentieux : Résolution de conflits, représentation en justice.</li>
                        <li>Droit du travail : Rédaction de contrats de travail, gestion des licenciements, négociation collective.</li>
                    </ul>
                    <h5>3. Services marketing et communication</h5>
                    <ul>
                        <li>Stratégie marketing : Élaboration de stratégies de croissance, positionnement de la marque.</li>
                        <li>Publicité et promotion : Campagnes publicitaires, marketing digital (SEO, SEM).</li>
                        <li>Création de contenu : Rédaction, conception graphique, production vidéo.</li>
                        <li>Relations publiques : Gestion de l'image de l'entreprise, relations avec les médias.</li>
                        <li>Community management : Gestion des réseaux sociaux, animation de communautés en ligne.</li>
                    </ul>
                    <h5>4. Services informatiques et technologiques</h5>
                    <ul>
                        <li>Développement de logiciels : Applications sur mesure, gestion des bases de données.</li>
                        <li>Maintenance et support technique : Services de dépannage, gestion des systèmes informatiques.</li>
                        <li>Cybersécurité : Protection des données, prévention des attaques informatiques.</li>
                        <li>Cloud computing : Stockage et gestion des données dans le cloud.</li>
                        <li>Solutions ERP/CRM : Implémentation et gestion des systèmes de gestion d'entreprise.</li>
                    </ul>
                    <h5>5. Services RH (Ressources humaines)</h5>
                    <ul>
                        <li>Recrutement : Recherche et sélection de talents, gestion des entretiens.</li>
                        <li>Gestion des compétences : Formation professionnelle, gestion des carrières.</li>
                        <li>Gestion de la paie : Traitement des salaires, gestion des charges sociales.</li>
                        <li>Conseil en organisation du travail : Optimisation de la structure de l'entreprise, gestion des équipes.</li>
                        <li>Santé et bien-être au travail : Mise en place de politiques de sécurité, gestion du stress et du bien-être des employés.</li>
                    </ul>
                    <h5>6. Services logistiques et opérationnels</h5>
                    <ul>
                        <li>Gestion des stocks : Suivi des inventaires, gestion des entrepôts.</li>
                        <li>Transport et livraison : Services de transport, optimisation des chaînes d'approvisionnement.</li>
                        <li>Sous-traitance : Externalisation de certains processus (production, services clients, etc.).</li>
                        <li>Gestion de la chaîne d'approvisionnement : Sourcing, négociation avec les fournisseurs.</li>
                    </ul>
                    <h5>7. Services de conseil et stratégie</h5>
                    <ul>
                    <li>Consulting en management : Amélioration de la performance organisationnelle, gestion du changement.</li>
                        <li>Conseil en stratégie d'entreprise : Aide à la définition des objectifs à long terme et à la planification.</li>
                        <li>Gestion de projet : Suivi et coordination des projets, gestion des risques.</li>
                        <li>Analyse de marché : Études de marché, analyses concurrentielles.</li>
                    </ul>
                    <h5>8. Services de formation</h5>
                    <ul>
                        <li>Formations professionnelles : Compétences techniques, développement personnel, leadership.</li>
                        <li>Séminaires et ateliers : Sessions en présentiel ou à distance pour les équipes.</li>
                        <li>E-learning : Plateformes de formation en ligne pour le personnel.</li>
                        <li>Coaching : Accompagnement personnalisé pour les dirigeants et cadres.</li>
                    </ul>
                    <h5>9. Services en ressources matérielles</h5>
                    <ul>
                        <li>Location de matériel : Machines, équipements spécialisés.</li>
                        <li>Fournitures de bureau : Mobilier, fournitures diverses.</li>
                        <li>Entretien des locaux : Nettoyage, services de maintenance.</li>
                    </ul>
                    <h5>10. Services en développement durable</h5>
                    <ul>
                        <li>Consulting en RSE (Responsabilité sociétale des entreprises) : Aide à la mise en place de pratiques éthiques et responsables.</li>
                        <li>Audit environnemental : Evaluation de l'impact écologique de l'entreprise.</li>
                        <li>Optimisation énergétique : Réduction de la consommation d'énergie, solutions vertes.</li>
                    </ul>
                    <h5>11. Services liés à l'international</h5>
                    <ul>
                        <li>Exportation et importation : Accompagnement pour le commerce international, gestion des douanes.</li>
                        <li>Consulting en internationalisation : Stratégies de pénétration de nouveaux marchés à l'international.</li>
                        <li>Traduction et interprétariat : Services multilingues pour les entreprises.</li>
                    </ul>
                    <h5>12. Services de gestion de la relation client</h5>
                    <ul>
                        <li>Centres d'appels : Gestion des appels entrants et sortants, service client.</li>
                        <li>Gestion des retours : Traitement des retours et des réclamations.</li>
                        <li>Enquêtes de satisfaction : Analyse des retours clients et recommandations.</li>
                        <li>Ces services sont essentiels à l'organisation et à la gestion efficace d'une entreprise. Les entreprises peuvent choisir de les internaliser ou de faire appel à des prestataires externes spécialisés.</li>
                    </ul>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
            </div>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo base_url('admin/services/add'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                           value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="form-group">
                        <label for="name">Nom du service</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="icon">Catégorie service</label>
                        <select name="catservice" class="form-control" id="catservice" required>
                            <option value="">--choisir--</option>
                            <option value="Services financiers">Services financiers</option>
                            <option value="Services juridiques">Services juridiques</option>
                            <option value="Services marketing et communication">Services marketing et communication</option>
                            <option value="Services informatiques et technologiques">Services informatiques et technologiques</option>
                            <option value="Services RH">Services RH</option>
                            <option value="Services logistiques et opérationnels">Services logistiques et opérationnels</option>
                            <option value="Services de conseil et stratégie">Services de conseil et stratégie</option>
                            <option value="Services de formation">Services de formation</option>
                            <option value="Services en ressources matérielles">Services en ressources matérielles</option>
                            <option value="Services en développement durable">Services en développement durable</option>
                            <option value="Services liés à l'international">Services liés à l'international</option>
                            <option value="Services de gestion de la relation client">Services de gestion de la relation client</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="icon">Icône</label>
                        <input type="file" class="form-control-file" id="icon" name="icon" 
                               accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">
                            Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
