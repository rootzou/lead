<!-- <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paramètres du site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body> -->
<?php $this->load->view('admin/includes/header'); ?>


    <div class="container">
      <div class="page-inner">
        <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Paramètres</h3>
                <h6 class="op-7 mb-2">Mise à jour les paramètres</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
              </div>
        </div>

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

                <form action="<?= base_url('settings/update') ?>" method="post" enctype="multipart/form-data">
                  <h5>Paramètres globaux</h5>
                  <hr>
                  <div class="mb-3">
                    <label for="name" class="form-label">Nom du site</label>
                    <input type="text" class="form-control" id="name" placeholder="Le nom du site" value="<?= set_value('sitename', $settings->sitename ?? '') ?>" name="sitename">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email du site" value="<?= set_value('email', $settings->email ?? '') ?>" name="email">
                  </div>
                  <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="mobile" placeholder="Mobile" value="<?= set_value('mobile', $settings->mobile ?? '') ?>" name="mobile">
                  </div>
                  <div class="mb-3">
                    <label for="logo" class="form-label">Logo du site</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                    <?php if (!empty($settings->logo)): ?>
                        <img src="<?= base_url('uploads/' . $settings->logo) ?>" alt="Logo actuel" class="img-thumbnail mt-2" width="100">
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="favicon" class="form-label">Favicon</label>
                    <input type="file" class="form-control" id="favicon" name="favicon">
                    <?php if (!empty($settings->favicon)): ?>
                        <img src="<?= base_url('uploads/' . $settings->favicon) ?>" alt="Favicon actuel" class="img-thumbnail mt-2" width="32">
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Description du site</label>
                    <textarea class="form-control" id="description" rows="3" name="description"><?= set_value('description', $settings->description ?? '') ?></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="copyright" class="form-label">Copyright</label>
                    <input type="text" class="form-control" id="copyright" placeholder="Copyright du site" value="<?= set_value('copyright', $settings->copyright ?? '') ?>" name="copyright">
                  </div>
                  <h5>Les réseaux sociaux</h5>
                  <hr>
                  <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input type="url" class="form-control" id="facebook" placeholder="URL de la page Facebook" value="<?= set_value('facebook', $settings->facebook ?? '') ?>" name="facebook">
                  </div>
                  <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="url" class="form-control" id="instagram" placeholder="URL de la page Instagram" value="<?= set_value('instagram', $settings->instagram ?? '') ?>" name="instagram">
                  </div>
                  <div class="mb-3">
                    <label for="linkedin" class="form-label">LinkedIn</label>
                    <input type="url" class="form-control" id="linkedin" placeholder="URL de la page LinkedIn" value="<?= set_value('linkedin', $settings->linkedin ?? '') ?>" name="linkedin">
                  </div>
                  <button type="submit" class="btn btn-primary">Valider</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card mt-5">
              <div class="card-body">
                <!-- Sidebar ou contenu additionnel -->
                <h5>Paramètres du site</h5>
                <hr>
                <ul>
                  <li>Nom du site: <?= set_value('sitename', $settings->sitename ?? '') ?></li>
                  <li>Email: <?= set_value('email', $settings->email ?? '') ?></li> 
                  <li>Mobile: <?= set_value('mobile', $settings->mobile ?? '') ?></li>
                  <li>Description du site: <?= set_value('mobile', $settings->mobile ?? '') ?></li>
                  <li>Copyright: <?= set_value('copyright', $settings->copyright ?? '') ?></li>
                  <li>Facebook: <?= set_value('facebook', $settings->facebook ?? '') ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('admin/includes/footer'); ?>

<!-- 
  </body>
</html> -->
