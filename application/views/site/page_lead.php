<?php $this->load->view("site/includes/header"); ?>

<main class="main" style="margin-top: 150px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><?php echo $page->titre_h1; ?></h1>
            </div>
        </div>

        <?php if($page->photo): ?>
        <div class="row mb-4">
            <div class="col-lg-12">
                <img src="<?php echo base_url($page->photo); ?>" alt="<?php echo $page->titre_h1; ?>" class="img-fluid">
            </div>
        </div>
        <?php endif; ?>

        <?php for($i = 1; $i <= 5; $i++): ?>
            <?php if(!empty($page->{'bloc'.$i.'_titre'}) && !empty($page->{'bloc'.$i.'_contenu'})): ?>
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <h2><?php echo $page->{'bloc'.$i.'_titre'}; ?></h2>
                        <div class="content">
                            <?php echo $page->{'bloc'.$i.'_contenu'}; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if($page->form == 'contact'): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Formulaire de contact</h3>
                            <?php echo form_open('contact/submit'); ?>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($page->form == 'devis'): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Demande de devis</h3>
                            <?php echo form_open('devis/submit'); ?>
                                <div class="mb-3">
                                    <label for="company" class="form-label">Société</label>
                                    <input type="text" class="form-control" id="company" name="company" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="project" class="form-label">Description du projet</label>
                                    <textarea class="form-control" id="project" name="project" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Demander un devis</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.content {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
}

.content h2 {
    color: #2c3e50;
    margin-bottom: 20px;
}

.content p {
    margin-bottom: 15px;
}

.content ul, .content ol {
    margin-bottom: 15px;
    padding-left: 20px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-control {
    border-radius: 5px;
}

.btn-primary {
    padding: 10px 25px;
    border-radius: 5px;
}
</style>

<?php $this->load->view("site/includes/footer"); ?>