<!DOCTYPE html>
<html>
<head>
    <title>Gestion des blocs</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- jQuery et jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .block-container {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
        }
        .block-controls {
            margin-top: 10px;
        }
        .block-content {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .edit-form {
            padding: 15px;
            background: #f5f5f5;
            border-radius: 4px;
            margin-top: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Gestion des blocs</h1>
        
        <!-- Zone d'ajout de bloc -->
        <div class="mb-4">
            <select class="form-control d-inline-block w-auto mr-2 add-block-select">
                <option value="about_us">About Us</option>
                <option value="statistics">Statistics</option>
                <option value="faq">FAQ</option>
            </select>
            <button class="btn btn-primary add-block-button">Ajouter un bloc</button>
        </div>

        <!-- Conteneur des blocs -->
        <div id="blocks-container"></div>
    </div>

    <script>
    $(document).ready(function() {
        // Charger les blocs existants
        loadBlocks();

        // Ajouter un nouveau bloc
        $('.add-block-button').click(function() {
            var blockType = $('.add-block-select').val();
            
            $.ajax({
                url: '<?php echo site_url("blocks/add"); ?>',
                type: 'POST',
                data: { type: blockType },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Créer le bloc avec le formulaire d'édition ouvert
                        addBlockToPage(response.data, true);
                    } else {
                        alert('Erreur: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Erreur lors de l\'ajout du bloc');
                    console.error(xhr.responseText);
                }
            });
        });

        // Charger tous les blocs
        function loadBlocks() {
            $.ajax({
                url: '<?php echo site_url("blocks/get_all"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#blocks-container').empty();
                        response.data.forEach(function(block) {
                            addBlockToPage(block, false);
                        });
                    }
                }
            });
        }

        // Ajouter un bloc à la page
        function addBlockToPage(block, showEditForm) {
            var blockHtml = `
                <div class="block-container" data-id="${block.id}" data-type="${block.type}">
                    <div class="block-content"></div>
                    <div class="edit-form" style="display: ${showEditForm ? 'block' : 'none'}">
                        <form class="edit-block-form">
                            <div class="form-group">
                                <label>Titre</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Sous-titre</label>
                                <textarea name="subtitle" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>URL de l'image</label>
                                <input type="url" name="image_url" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>URL de la vidéo</label>
                                <input type="url" name="video_url" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <button type="button" class="btn btn-secondary cancel-edit">Annuler</button>
                        </form>
                    </div>
                    <div class="block-controls">
                        <button class="btn btn-primary edit-block">Éditer</button>
                        <button class="btn btn-warning toggle-visibility">${block.is_visible ? 'Masquer' : 'Afficher'}</button>
                    </div>
                </div>
            `;
            
            var $block = $(blockHtml);
            $('#blocks-container').append($block);
            
            if (!showEditForm) {
                loadBlockContent(block.type, $block.find('.block-content'));
            }
        }

        // Charger le contenu d'un bloc
        function loadBlockContent(type, container) {
            $.ajax({
                url: '<?php echo site_url(); ?>' + type + '/get_content',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayBlockContent(type, container, response.data);
                    }
                }
            });
        }

        // Afficher le contenu d'un bloc
        function displayBlockContent(type, container, data) {
            var content = '';
            switch(type) {
                case 'about_us':
                    content = `
                        <h3>${data.title || ''}</h3>
                        <p>${data.subtitle || ''}</p>
                        ${data.image_url ? `<img src="${data.image_url}" class="img-fluid mb-3" alt="Image">` : ''}
                        ${data.video_url ? `<div class="video-container mb-3">${data.video_url}</div>` : ''}
                    `;
                    break;
                // Autres types de blocs...
            }
            container.html(content);
        }

        // Gérer le clic sur Éditer
        $(document).on('click', '.edit-block', function() {
            var $block = $(this).closest('.block-container');
            var type = $block.data('type');
            var $form = $block.find('.edit-form');
            
            // Charger les données actuelles
            $.ajax({
                url: '<?php echo site_url(); ?>' + type + '/get_content',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Remplir le formulaire
                        var data = response.data;
                        $form.find('[name="title"]').val(data.title || '');
                        $form.find('[name="subtitle"]').val(data.subtitle || '');
                        $form.find('[name="image_url"]').val(data.image_url || '');
                        $form.find('[name="video_url"]').val(data.video_url || '');
                        $form.slideDown();
                    }
                }
            });
        });

        // Gérer la soumission du formulaire
        $(document).on('submit', '.edit-block-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $block = $form.closest('.block-container');
            var type = $block.data('type');
            
            var formData = {
                title: $form.find('[name="title"]').val(),
                subtitle: $form.find('[name="subtitle"]').val(),
                image_url: $form.find('[name="image_url"]').val(),
                video_url: $form.find('[name="video_url"]').val()
            };
            
            $.ajax({
                url: '<?php echo site_url(); ?>' + type + '/update_content',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $form.closest('.edit-form').slideUp();
                        loadBlockContent(type, $block.find('.block-content'));
                    } else {
                        alert('Erreur lors de la mise à jour');
                    }
                }
            });
        });

        // Gérer le clic sur Annuler
        $(document).on('click', '.cancel-edit', function() {
            $(this).closest('.edit-form').slideUp();
        });

        // Gérer le clic sur Masquer/Afficher
        $(document).on('click', '.toggle-visibility', function() {
            var $block = $(this).closest('.block-container');
            var id = $block.data('id');
            var $button = $(this);
            var newVisibility = $button.text() === 'Afficher' ? 1 : 0;
            
            $.ajax({
                url: '<?php echo site_url("blocks/toggle_visibility"); ?>',
                type: 'POST',
                data: { 
                    id: id,
                    visible: newVisibility
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $button.text(newVisibility ? 'Masquer' : 'Afficher');
                    }
                }
            });
        });
    });
    </script>
</body>
</html>
