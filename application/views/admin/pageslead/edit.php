<?php $this->load->view('admin/includes/header'); ?>

<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?php echo $title; ?></h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Modifier la page Lead</div>
                    </div>
                    <div class="card-body">
                        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                        <?php echo form_open_multipart('admin/pageslead/edit/'.$page->id); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titre SEO</label>
                                        <input type="text" class="form-control" name="titre_seo" value="<?php echo set_value('titre_seo', $page->titre_seo); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" name="desc_seo" rows="2" maxlength="164" required><?php echo set_value('desc_seo', $page->desc_seo); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Titre de page (H1)</label>
                                        <input type="text" class="form-control" name="titre_h1" value="<?php echo set_value('titre_h1', $page->titre_h1); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input type="text" class="form-control" name="slug" value="<?php echo set_value('slug', $page->slug); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Photo</label>
                                <?php if(!empty($page->photo)): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo base_url($page->photo); ?>" alt="Current photo" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="photo" accept="image/*">
                                <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                            </div>

                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Titre Bloc <?php echo $i; ?></label>
                                        <input type="text" class="form-control" name="bloc<?php echo $i; ?>_titre" 
                                               value="<?php echo set_value('bloc'.$i.'_titre', $page->{'bloc'.$i.'_titre'}); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contenu Bloc <?php echo $i; ?></label>
                                        <textarea class="form-control summernote" name="bloc<?php echo $i; ?>_contenu" rows="4" required><?php 
                                            echo set_value('bloc'.$i.'_contenu', $page->{'bloc'.$i.'_contenu'}); 
                                        ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>

                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Mettre à jour</button>
                                <a href="<?php echo base_url('admin/pageslead'); ?>" class="btn btn-danger">Annuler</a>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Auto-generate slug from titre_h1 only if slug is empty
    $('input[name="titre_h1"]').on('keyup', function() {
        var slugInput = $('input[name="slug"]');
        if(slugInput.val() === '') {
            var slug = $(this).val()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.val(slug);
        }
    });
});
</script>

<?php $this->load->view('admin/includes/footer'); ?>
