<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Mon Profil</h4>
        </div>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Modifier mon profil</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('admin/profile/update'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">
                            
                            <div class="form-group">
                                <label for="name">Nom complet</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo $user->name; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo $user->email; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="avatar">Photo de profil</label>
                                <?php if($user->avatar): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo base_url('uploads/avatars/'.$user->avatar); ?>" 
                                             alt="<?php echo $user->name; ?>" 
                                             class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control-file" id="avatar" name="avatar" 
                                       accept="image/jpeg,image/png,image/gif,image/webp">
                                <small class="form-text text-muted">
                                    Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 2MB
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       minlength="6">
                                <small class="form-text text-muted">
                                    Laissez vide si vous ne souhaitez pas changer de mot de passe
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control" id="confirm_password" 
                                       name="confirm_password">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                Mettre à jour mon profil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('<?php echo base_url('assets/img/blogpost.jpg'); ?>')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <?php if($user->avatar): ?>
                                    <img src="<?php echo base_url('uploads/avatars/'.$user->avatar); ?>" 
                                         alt="<?php echo $user->name; ?>" 
                                         class="avatar-img rounded-circle">
                                <?php else: ?>
                                    <img src="<?php echo base_url('assets/img/default-avatar.png'); ?>" 
                                         alt="Default Avatar" 
                                         class="avatar-img rounded-circle">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name"><?php echo $user->name; ?></div>
                            <div class="email"><?php echo $user->email; ?></div>
                            <div class="view-profile mt-4">
                                <small>Membre depuis : <?php echo date('d/m/Y', strtotime($user->created_at)); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
