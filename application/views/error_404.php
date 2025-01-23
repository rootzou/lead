<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 404 - Oups ! Page non trouvée</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('assets/css/styles404.css')?>">
</head>

<body>
    <div class="container">
        <div class="error-message">
            <h1>404</h1>
            <h2>Oups ! Cette page n'existe pas.</h2>
            <p>Il semble que vous soyez perdu. Retournez à la page d'accueil ou explorez d'autres sections de notre site.</p>
            <a href="<?=base_url()?>" class="btn-home">Retour à l'accueil</a>
        </div>
<!--         <div class="illustration">
            <img src="https://via.placeholder.com/400x300?text=Illustration+404" alt="404 Illustration">
        </div> -->
    </div>
</body>

</html>
