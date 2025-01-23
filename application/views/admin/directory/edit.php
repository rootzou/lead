<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Modifier l'annuaire</h1>
            <a href="<?php echo base_url('admin/directory'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo base_url('admin/directory/edit/'.$directory->id); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $directory->name; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $directory->description; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <?php if($directory->logo): ?>
                            <div class="mb-2">
                                <img src="<?php echo base_url('uploads/directories/logos/'.$directory->logo); ?>" 
                                    alt="<?php echo $directory->name; ?>" 
                                    style="max-width: 100px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB</small>
                    </div>

                    <div class="form-group">
                        <label for="pays">Pays</label>
                        <select name="pays" class="form-control" id="pays">
                            <option value="">-- Choisir un pays --</option>
                            <?php $countries = $this->db->get('countrys')->result(); ?>
                            <?php foreach($countries as $value): ?>
                                <option value="<?=$value->id?>" <?php echo ($directory->pays == $value->id) ? 'selected' : ''; ?>><?=$value->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="cover_image">Image de couverture</label>
                        <?php if($directory->cover_image): ?>
                            <div class="mb-2">
                                <img src="<?php echo base_url('uploads/directories/covers/'.$directory->cover_image); ?>" 
                                    alt="<?php echo $directory->name; ?>" 
                                    style="max-width: 100px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB</small>
                    </div>

                    
                    
                    <div class="form-group">
                        <label for="website_url">Site web</label>
                        <input type="url" class="form-control" id="website_url" name="website_url" value="<?php echo $directory->website_url; ?>">
                    </div>

                    <div class="form-group">
                        <label for="location">Localisation</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $directory->location; ?>">
                    </div>

                    <div class="form-group">
                        <label for="services">Services</label>
                        <select class="form-control select2" id="services" name="services[]" multiple>
                            <?php 
                            $selected_services = [];
                            if (isset($directory->services) && is_array($directory->services)) {
                                $selected_services = array_map(function($service) {
                                    return $service->id;
                                }, $directory->services);
                            }
                            foreach($services as $service): ?>
                                <option value="<?php echo $service->id; ?>"
                                    <?php echo in_array($service->id, $selected_services) ? 'selected' : ''; ?>>
                                    <?php echo $service->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">
                            Sélectionnez un ou plusieurs services proposés par l'entreprise
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="contact_email">Email de contact</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo $directory->contact_email; ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact_phone">Téléphone</label>
                        <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo $directory->contact_phone; ?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select class="form-control" id="status" name="status">
                            <option value="active" <?php echo $directory->status == 'active' ? 'selected' : ''; ?>>Actif</option>
                            <option value="inactive" <?php echo $directory->status == 'inactive' ? 'selected' : ''; ?>>Inactif</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Portfolio</h4>
            </div>
            <div class="card-body">
                <!-- Liste des projets -->
                <div class="portfolio-items mb-4">
                    <?php if(isset($portfolio) && !empty($portfolio)): ?>
                        <div class="row">
                            <?php foreach($portfolio as $item): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <?php if($item->image): ?>
                                            <img src="<?php echo base_url('uploads/portfolio/'.$item->image); ?>" 
                                                 class="card-img-top" 
                                                 alt="<?php echo $item->title; ?>"
                                                 style="height: 200px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $item->title; ?></h5>
                                            <p class="card-text"><?php echo $item->description; ?></p>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm delete-portfolio" 
                                                    data-id="<?php echo $item->id; ?>">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucun projet dans le portfolio</p>
                    <?php endif; ?>
                </div>

                <!-- Formulaire d'ajout -->
                <form action="<?php echo base_url('directories/add_portfolio/'.$directory->id); ?>" 
                      method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    
                    <div class="form-group">
                        <label for="title">Titre du projet</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="project_date">Date du projet</label>
                        <input type="date" class="form-control" id="project_date" name="project_date">
                    </div>
                    
                    <div class="form-group">
                        <label for="project_image">Image du projet</label>
                        <input type="file" class="form-control-file" id="project_image" name="project_image" required>
                        <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Ajouter le projet</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Gestion de la suppression
    $('.delete-portfolio').on('click', function() {
        if(confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) {
            const id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url("admin/directory/delete_portfolio/"); ?>' + id,
                type: 'POST',
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Une erreur est survenue lors de la suppression');
                }
            });
        }
    });
});
</script>

<?php $this->load->view('admin/includes/footer'); ?>
