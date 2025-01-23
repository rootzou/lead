<?php $this->load->view('admin/header'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Annuaires</h5>
                    <p class="card-text">Gérer les annuaires du site</p>
                    <a href="<?php echo base_url('admin/directory'); ?>" class="btn btn-primary">
                        Accéder aux annuaires
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
