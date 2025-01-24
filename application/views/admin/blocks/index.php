<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Gestion des Blocs</h1>
                <p class="text-muted">Gérez la gestion des blocs</p>
            </div>
            <a href="<?php echo base_url('admin/blocks/add'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un bloc
            </a>
        </div>

                <div class="card">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titre</th>
                                        <th>Ordre</th>
                                        <th style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blocks as $block): ?>
                                        <tr>
                                            <td><?php echo $block->id; ?></td>
                                            <td><?php echo $block->title; ?></td>
                                            <td><?php echo $block->orderB; ?></td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="<?php echo base_url('admin/blocks/edit/'.$block->id); ?>" 
                                                    data-toggle="tooltip" title="Modifier"
                                                    class="btn btn-link btn-primary btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo base_url('admin/blocks/delete/'.$block->id); ?>" 
                                                    data-toggle="tooltip" title="Supprimer"
                                                    class="btn btn-link btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce bloc ?');">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            }
        });
    });
    </script>
</div>
