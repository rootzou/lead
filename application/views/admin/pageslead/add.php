<?php $this->load->view('admin/includes/header'); ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Ajouter page lead</h1>
            <a href="<?php echo base_url('admin/pageslead'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
        
                <div class="card">
                    <div class="card-body">
                        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                        <?php echo form_open_multipart('admin/pageslead/add'); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titre SEO</label>
                                        <input type="text" class="form-control" name="titre_seo" value="<?php echo set_value('titre_seo'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" name="desc_seo" rows="2" maxlength="164" required><?php echo set_value('desc_seo'); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titre de page (H1)</label>
                                        <input type="text" class="form-control" name="titre_h1" value="<?php echo set_value('titre_h1'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input type="text" class="form-control" name="slug" value="<?php echo set_value('slug'); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="favicon" class="form-label">Include form</label>
                                <select name="form" id="form" class="form-control">
                                    <option value="1">Form1</option>
                                    <option value="2">Form2</option>
                                    <option value="3">Form3</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" class="form-control" name="photo" accept="image/*">
                            </div>

                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Titre Bloc <?php echo $i; ?></label>
                                        <input type="text" class="form-control" name="bloc<?php echo $i; ?>_titre" value="<?php echo set_value('bloc'.$i.'_titre'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contenu Bloc <?php echo $i; ?></label>
                                        <textarea class="form-control summernote" name="bloc<?php echo $i; ?>_contenu" rows="4" required><?php echo set_value('bloc'.$i.'_contenu'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>

                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="<?php echo base_url('admin/pageslead'); ?>" class="btn btn-danger">Annuler</a>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            
    </div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
