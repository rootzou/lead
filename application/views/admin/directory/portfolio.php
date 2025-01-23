<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Portfolio de <?php echo $directory->name; ?></h1>
                <p class="text-muted">Gérez les projets du portfolio</p>
            </div>
            <a href="<?php echo base_url('admin/directory'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux annuaires
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

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ajouter un projet</h4>
                    </div>
                    <div class="card-body">
                        <form id="portfolioForm" action="<?php echo base_url('directories/add_portfolio/'.$directory->id); ?>" 
                              method="post" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Titre du projet</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_date">Date du projet</label>
                                        <input type="date" class="form-control" id="project_date" name="project_date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="project_image">Image du projet</label>
                                <input type="file" class="form-control" id="project_image" name="project_image" 
                                       accept="image/jpeg,image/png,image/gif,image/webp" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-plus"></i> Ajouter au portfolio
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if(!empty($portfolio)): ?>
                <?php foreach($portfolio as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if($item->image): ?>
                                <img src="<?php echo base_url('uploads/portfolio/'.$item->image); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo $item->title; ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item->title; ?></h5>
                                <?php if($item->project_date): ?>
                                    <p class="text-muted">
                                        <i class="fas fa-calendar"></i> 
                                        <?php echo date('d/m/Y', strtotime($item->project_date)); ?>
                                    </p>
                                <?php endif; ?>
                                <p class="card-text"><?php echo $item->description; ?></p>
                                <button type="button" 
                                        class="btn btn-danger delete-portfolio" 
                                        data-id="<?php echo $item->id; ?>">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        Aucun projet dans le portfolio pour le moment.
                    </div>
                </div>
            <?php endif; ?>
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

    // Validation du formulaire
    $('#portfolioForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Une erreur est survenue lors de l\'ajout du projet');
            }
        });
    });
});
</script>

<?php $this->load->view('admin/includes/footer'); ?>
