<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<header class="p-2 mb-5 sticky-top d-grid "style="grid-template-columns: repeat(3, 1fr);">
    <h1>Blog</h1>
    <nav class="d-flex gap-3 align-items-center justify-content-center">
        <a href="/">Accueil</a>
        <a href="/users">Utilisateurs</a>
        <a href="/profil">Voir votre profil</a>
    </nav>
    <div class="d-flex gap-2 ms-auto align-items-center">
        <a href="/register">Inscription</a>
        <a href="/login">Connexion</a>
    </div>
</header>
<body>
    
    <main>
        <?= $content ?>
    </main>
</body>
</html>