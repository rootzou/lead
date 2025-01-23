<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Modifier un service</h1>
            <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo base_url('admin/services/edit/'.$service->id); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                           value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="form-group">
                        <label for="name">Nom du service</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?php echo $service->name; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="3"><?php echo $service->description; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="catservice">Catégorie service</label>
                        <select name="catservice" class="form-control" id="catservice" required>
                            <option value="">--choisir--</option>
                            <option value="Services financiers" <?php echo ($service->catservice == 'Services financiers') ? 'selected' : ''; ?>>Services financiers</option>
                            <option value="Services juridiques" <?php echo ($service->catservice == 'Services juridiques') ? 'selected' : ''; ?>>Services juridiques</option>
                            <option value="Services marketing et communication" <?php echo ($service->catservice == 'Services marketing et communication') ? 'selected' : ''; ?>>Services marketing et communication</option>
                            <option value="Services informatiques et technologiques" <?php echo ($service->catservice == 'Services informatiques et technologiques') ? 'selected' : ''; ?>>Services informatiques et technologiques</option>
                            <option value="Services RH" <?php echo ($service->catservice == 'Services RH') ? 'selected' : ''; ?>>Services RH</option>
                            <option value="Services logistiques et opérationnels" <?php echo ($service->catservice == 'Services logistiques et opérationnels') ? 'selected' : ''; ?>>Services logistiques et opérationnels</option>
                            <option value="Services de conseil et stratégie" <?php echo ($service->catservice == 'Services de conseil et stratégie') ? 'selected' : ''; ?>>Services de conseil et stratégie</option>
                            <option value="Services de formation" <?php echo ($service->catservice == 'Services de formation') ? 'selected' : ''; ?>>Services de formation</option>
                            <option value="Services en ressources matérielles" <?php echo ($service->catservice == 'Services en ressources matérielles') ? 'selected' : ''; ?>>Services en ressources matérielles</option>
                            <option value="Services en développement durable" <?php echo ($service->catservice == 'Services en développement durable') ? 'selected' : ''; ?>>Services en développement durable</option>
                            <option value="Services liés à l'international" <?php echo ($service->catservice == 'Services liés à l\'international') ? 'selected' : ''; ?>>Services liés à l'international</option>
                            <option value="Services de gestion de la relation client" <?php echo ($service->catservice == 'Services de gestion de la relation client') ? 'selected' : ''; ?>>Services de gestion de la relation client</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="icon">Icône</label>
                        <?php if($service->icon): ?>
                            <div class="mb-2">
                                <img src="<?php echo base_url('uploads/services/icons/'.$service->icon); ?>" 
                                     alt="<?php echo $service->name; ?>" 
                                     class="img-thumbnail" style="max-width: 100px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control-file" id="icon" name="icon" 
                               accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">
                            Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB<br>
                            Laissez vide pour conserver l'icône actuelle
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
