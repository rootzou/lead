<?php $this->load->view("site/includes/header"); ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Les meilleures agences<br> de <?=$service->name?></h1>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="<?=base_url()?>">Accueil</a></li>
            <li class="current">Les meilleures agences de <?=$service->name?></li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->



    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title aos-init aos-animate" data-aos="fade-up">
        <h2>Les agences de <?=$service->name?> les plus en vue</h2>
      </div><!-- End Section Title -->

      <div class="container">
        <div class="row gy-4">
          <?php if($directories): ?>
            <?php foreach($directories as $directory): ?>
            <a href="" class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item d-flex flex-column align-items-center justify-content-center position-relative">
                <div class="service-logo mx-auto">
                  <?php if($directory->logo && file_exists(FCPATH . 'uploads/directories/logos/' . $directory->logo)): ?>
                    <img src="<?=base_url('uploads/directories/logos/' . $directory->logo)?>" alt="<?=$directory->name?>" class="img-fluid rounded-circle" style="max-width: 70px;height: 70px;">
                  <?php else: ?>
                    <i class="bi bi-activity fs-1 text-primary"></i>
                  <?php endif; ?>
                </div>
                <div class="service-name text-center">
                  <h3 class="mt-3"><?=$directory->name?></h3>
                </div>
                <p class="text-center desc_comp"><?=character_limiter($directory->description, 90)?></p>
                <hr>
                <div class="params-comp mb-3">
                  <p><i class="bi bi-geo-alt-fill me-2"></i> Localisation: <?=$directory->location?></p>
                  <p><i class="bi bi-envelope-fill me-2"></i> Contact: <?=$directory->contact_email?></p>
                  <p><i class="bi bi-telephone-fill me-2"></i> Mobile: <?=$directory->contact_phone?></p>
                  <p><i class="bi bi-people-fill me-2"></i> Effectif: 10-20 personnes</p>
                </div>
                
                <button onclick="window.location.href='<?= $directory->website_url ?>'" class="btn btn-primary btn-sm stretched-link">
                    visiter le site web <i class="bi bi-arrow-right"></i>
                </button>
              </div>
            </a href=""><!-- End Service Item -->
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <p class="text-muted">Il n'y a pas de données pour cette service.</p>
            </div>
            <?php endif; ?>
        </div>
      </div>

    </section>
    <!-- Service Details Section -->
    <section id="service-details" class="service-details section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="services-list">
              <a href="#" class="active">Web Design</a>
              <a href="#">Software Development</a>
              <a href="#">Product Management</a>
              <a href="#">Graphic Design</a>
              <a href="#">Marketing</a>
            </div>

            <h4>Enim qui eos rerum in delectus</h4>
            <p>Nam voluptatem quasi numquam quas fugiat ex temporibus quo est. Quia aut quam quod facere ut non occaecati ut aut. Nesciunt mollitia illum tempore corrupti sed eum reiciendis. Maxime modi rerum.</p>
          </div>

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/services.jpg" alt="" class="img-fluid services-img">
            <h3>Temporibus et in vero dicta aut eius lidero plastis trand lined voluptas dolorem ut voluptas</h3>
            <p>
              Blanditiis voluptate odit ex error ea sed officiis deserunt. Cupiditate non consequatur et doloremque consequuntur. Accusantium labore reprehenderit error temporibus saepe perferendis fuga doloribus vero. Qui omnis quo sit. Dolorem architecto eum et quos deleniti officia qui.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Aut eum totam accusantium voluptatem.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Assumenda et porro nisi nihil nesciunt voluptatibus.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea</span></li>
            </ul>
            <p>
              Est reprehenderit voluptatem necessitatibus asperiores neque sed ea illo. Deleniti quam sequi optio iste veniam repellat odit. Aut pariatur itaque nesciunt fuga.
            </p>
            <p>
              Sunt rem odit accusantium omnis perspiciatis officia. Laboriosam aut consequuntur recusandae mollitia doloremque est architecto cupiditate ullam. Quia est ut occaecati fuga. Distinctio ex repellendus eveniet velit sint quia sapiente cumque. Et ipsa perferendis ut nihil. Laboriosam vel voluptates tenetur nostrum. Eaque iusto cupiditate et totam et quia dolorum in. Sunt molestiae ipsum at consequatur vero. Architecto ut pariatur autem ad non cumque nesciunt qui maxime. Sunt eum quia impedit dolore alias explicabo ea.
            </p>
          </div>

        </div>

      </div>
    </section><!-- /Service Details Section -->

  </main>

<?php $this->load->view("site/includes/footer"); ?>