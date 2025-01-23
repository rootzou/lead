<?php $this->load->view('admin/includes/header'); ?>


    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="card my-5">
            <div class="card-body">
              <!-- Message d'erreur ou de succès -->
              <?php if ($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger">
                      <?= $this->session->flashdata('error'); ?>
                  </div>
              <?php elseif ($this->session->flashdata('success')): ?>
                  <div class="alert alert-success">
                      <?= $this->session->flashdata('success'); ?>
                  </div>
              <?php endif; ?>

              <!-- Affichage des erreurs de validation -->
              <?php if (validation_errors()): ?>
                  <div class="alert alert-danger">
                      <?= validation_errors(); ?>
                  </div>
              <?php endif; ?>

              <form action="<?= base_url('PageLeads/add') ?>" method="post" enctype="multipart/form-data">
                <h5>Paramètres SEO</h5>
                <hr>
                <div class="mb-3">
                  <label for="titre_seo" class="form-label">Title</label>
                  <input type="text" class="form-control" id="titre_seo" placeholder="Meta title" name="titre_seo">
                </div>
                <div class="mb-3">
                  <label for="desc_seo" class="form-label">Meta description</label>
                  <textarea class="form-control" id="desc_seo" placeholder="Meta description" name="desc_seo"></textarea>
                </div>

                <div class="mb-3">
                  
                  <div class="row">
                    <div class="col-md-5">
                      <label for="slug" class="form-label">Slug1</label>
                      <input type="text" class="form-control" id="slug" placeholder="Slug du page" name="slug">
                    </div> 
                    <div class="col-md-1">/</div>
                    <div class="col-md-6">
                      <label for="slug2" class="form-label">Slug2</label>
                      <input type="text" class="form-control" id="slug2" placeholder="Slug du page" name="slug2" value="">
                    </div>
                  </div>
                </div>
                <h5>Contenue du page</h5>
                <div class="mb-3">
                  <label for="titre_h1" class="form-label">Titre h1</label>
                  <input type="text" class="form-control" id="titre_h1" name="titre_h1">

                </div>
                <div class="mb-3">
                  <label for="favicon" class="form-label">Include form</label>
                  <select name="form" id="form" class="form-control">
                    <option value="1">Form1</option>
                    <option value="2">Form2</option>
                    <option value="3">Form3</option>
                  </select>
                </div>
                <h5>Contenue Bloc </h5>
                <div class="mb-3">
                  <label for="titre_h2" class="form-label">Titre bloc</label>
                  <input type="text" class="form-control" id="titre_h2" placeholder="Titre bloc 1" name="titre_h2">
                </div>
                <div class="mb-3">
                  <label for="bloc1" class="form-label">Bloc </label>
                  <textarea class="form-control" id="bloc1" rows="3" name="bloc1"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Valider</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card mt-5">
            <div class="card-body">
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script><script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Initialisation de CKEditor
        //CKEDITOR.replace('titre_h2');
    </script>
    <!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/4f83u8h1jxabv2cma3mgn2mwp0p7ecuvx373n3jmznmhcp3b/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea:not(#desc_seo)', // Cela applique l'éditeur à toutes les textarea sauf celle avec l'id "desc_seo"
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Jan 20, 2025:
      'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>





<?php $this->load->view('admin/includes/footer'); ?>