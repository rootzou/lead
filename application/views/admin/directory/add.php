<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Ajouter une entreprise</h1>
            <a href="<?php echo base_url('admin/directory'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo base_url('admin/directory/add'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cover_image">Image de couverture</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB</small>
                    </div>

                    <div class="form-group">
                        <label for="pays">Pays</label>
                        <select name="pays" class="form-control" id="pays">
                            <option value="">-- Choisir un pays --</option>
                            <?php $countries = $this->db->get('countrys')->result(); ?>
                            <?php foreach($countries as $value): ?>
                                <option value="<?=$value->id?>"><?=$value->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB</small>
                    </div>

                    <div class="form-group">
                        <label for="website_url">Site web</label>
                        <input type="url" class="form-control" id="website_url" name="website_url">
                    </div>

                    

                    <div class="form-group">
                        <label for="location">Localisation</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>

                    <div class="form-group">
                        <label for="services">Services</label>
                        <select class="form-control select2" id="services" name="services[]" multiple>
                            <?php foreach($services as $service): ?>
                                <option value="<?php echo $service->id; ?>">
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
                        <input type="email" class="form-control" id="contact_email" name="contact_email">
                    </div>

                    <div class="form-group">
                        <label for="contact_phone">Téléphone</label>
                        <input type="tel" class="form-control" id="contact_phone" name="contact_phone">
                    </div>

                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select class="form-control" id="status" name="status">
                            <option value="active">Actif</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
