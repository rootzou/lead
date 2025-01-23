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