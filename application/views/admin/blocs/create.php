
<?php $this->load->view('admin/includes/header'); ?>

  <div class="container">
    <div class="row">
        <div class="col-md-9">
          <div class="card my-5">
            <div class="card-body">
              <h2>Ajouter un bloc HTML</h2>
                <form method="post">
                  <label for="titre">Titre</label>
                  <input type="text" name="titre" required>
                  
                  <label for="contenu">Contenu HTML</label>
                  <textarea name="contenu" id="editor" rows="5"></textarea>
                  
                  <button type="submit">Ajouter</button>
                </form>
            </div>
          </div>
        </div>
      </div>
  </div>


<?php $this->load->view('admin/includes/footer'); ?>

<!-- Ajout de l'éditeur CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor');
</script>
