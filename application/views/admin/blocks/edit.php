<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Modifier le Bloc</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Modifier le Bloc #<?php echo $block->id; ?></div>
                    </div>
                    <div class="card-body">
                        <?php echo form_open('admin/blocks/edit/'.$block->id, ['class' => 'form-horizontal']); ?>
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="title">Titre</label>
                                        <input type="text" class="form-control" id="title" name="title" 
                                            value="<?php echo set_value('title', $block->title); ?>" required>
                                        <?php echo form_error('title', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="orderB">Ordre</label>
                                        <input type="number" class="form-control" id="orderB" name="orderB" 
                                            value="<?php echo set_value('orderB', $block->orderB); ?>" required>
                                        <?php echo form_error('orderB', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content">Contenu</label>
                                        <textarea class="form-control summernote" id="content" name="content" rows="10" required>
                                            <?php echo set_value('content', $block->content); ?>
                                        </textarea>
                                        <?php echo form_error('content', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-action">
                                <button type="submit" class="btn btn-success">Mettre à jour</button>
                                <a href="<?php echo base_url('admin/blocks'); ?>" class="btn btn-danger">Annuler</a>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
    </script>
</div>
