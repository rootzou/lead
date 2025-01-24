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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Titre SEO</label>
                            <input type="text" class="form-control" name="titre_seo"
                                value="<?php echo set_value('titre_seo'); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea class="form-control" name="desc_seo" rows="2" maxlength="164"
                                required><?php echo set_value('desc_seo'); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Titre de page (H1)</label>
                            <input type="text" class="form-control" name="titre_h1"
                                value="<?php echo set_value('titre_h1'); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" value="<?php echo set_value('slug'); ?>"
                                required>
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

                <?php
                $blocs = $this->db->get('blocks')->result();
                ?>

                <table class="table">
                    <tbody id="blocs">

                    </tbody>
                </table>

                <tfoot>
                    <tr>
                        <td class="text-end fw-bold">
                            <div>
                                <button type="button" class="btn btn-success" id="createAddBloc"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </td>
                    </tr>
                </tfoot>


                <hr>


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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Summernote
        $('#bloc_content').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });


        $('#bloc_id').on('change', function () {
            var selectedContent = $(this).val();
            if (selectedContent != '') {
                // Set content to Summernote
                $('#bloc_content').summernote('code', selectedContent);
                $('#bloc_content_div').show();
            } else {
                // Clear the editor
                $('#bloc_content').summernote('code', '');
                $('#bloc_content_div').hide();
            }
        });

        // Trigger change event on page load if a value is selected
        if ($('#bloc_id').val() != '') {
            $('#bloc_id').trigger('change');
        }
    });
</script>

<script>
    $(document).ready(function () {
        let index = 1;
        function addBloc() {
            let newBloc = ` <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="bloc_id" class="form-label">Bloc</label>
                                        <select name="blocks[]" id="bloc${index}"  data-id="${index}" class="form-control selectBloc">
                                            <option value="">-- Choisir un bloc --</option>
                                            <?php foreach ($blocs as $bloc) { ?>
                                                    <option value="<?= htmlspecialchars($bloc->content); ?>"><?= $bloc->title; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div  class="form-group bloc_content_div" id="bloc_content_div${index}" >
                                       
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteBlocRow" data-id="${index}">X</button>
                                </td>
                            </tr>`;
            $('#blocs').append(newBloc);
            index++;
        }

        $('#createAddBloc').on('click', function () {
            addBloc();
        });

        $(document).on('change', '.selectBloc', function () {
            let id = $(this).data('id');
            let selectedContent = $(`#bloc${id}`).val().trim(); // Suppression des espaces inutiles
            let contentDiv = $(`#bloc_content_div${id}`); // Déclaration ici pour éviter une erreur dans le else

            if (selectedContent !== '') {
                // Insérer la zone de texte si elle n'existe pas encore
                if (!contentDiv.find(`#bloc_content${id}`).length) {
                    contentDiv.html(`
                <div class="form-group">
                    <label for="bloc_content${id}" class="form-label">Contenu</label>
                    <textarea class="form-control summernote" id="bloc_content${id}" name="bloc_content[]" rows="10" required></textarea>
                </div>
            `);
                }

                let textarea = $(`#bloc_content${id}`);

                // Détruire Summernote si déjà initialisé
                if (textarea.hasClass('note-editor')) {
                    textarea.summernote('destroy');
                }

                // Initialiser Summernote avant d'insérer du contenu
                textarea.summernote({
                    height: 300, // Hauteur de l'éditeur
                    tabsize: 2
                }).summernote('code', selectedContent);

            } else {
                contentDiv.empty(); // Nettoyer correctement le contenu si la sélection est vide
            }
        });

        $(document).on('click', '.deleteBlocRow', function () {
            let id = $(this).data('id');
            $(`#bloc_content_div${id}`).remove();
            $(this).closest('tr').remove();
        });

    });
</script>