<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Gestion des services</h1>
            <a href="<?php echo base_url('admin/services/add'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un service
            </a>
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

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Catégorie</th>
                                <th>Date de création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($services as $service): ?>
                                <tr>
                                    <td>
                                        <?php if($service->icon): ?>
                                            <img src="<?php echo base_url('uploads/services/icons/'.$service->icon); ?>" 
                                                 alt="<?php echo $service->name; ?>" 
                                                 class="img-thumbnail" style="max-width: 50px;">
                                        <?php else: ?>
                                            <i class="fas fa-cube fa-2x"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $service->name; ?></td>
                                    <td><?php echo $service->description; ?></td>
                                    <td><?php echo $service->catservice; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($service->created_at)); ?></td>
                                    <td>
                                        <a href="<?php echo base_url('admin/services/edit/'.$service->id); ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/services/delete/'.$service->id); ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
