<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<header class="p-2 mb-5 m-2 sticky-top d-grid "style="grid-template-columns: repeat(3, 1fr);">
    <h1>Blog</h1>
    <nav class="d-flex gap-3 align-items-center justify-content-center">
        <a href="/" class="link">Accueil <i class="bi bi-house"></i></a>
        <a href="/users" class="link">Utilisateurs <i class="bi bi-people"></i></a>
        <a href="/profil" class="link">Votre profil<i class="bi bi-person"></i></a>
    </nav>
    <div class="d-flex gap-2 ms-auto align-items-center">
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="/register" class="signin">S'inscrire <i class="bi bi-person-plus"></i></a>
            <a href="/login" class="login">Se connecter <i class="bi bi-box-arrow-in-right"></i></a>
        <?php else : ?>
            <a href="/logout" class="logout">Se déconnecter <i class="bi bi-box-arrow-left"></i></a>
        <?php endif; ?>
    </div>
</header>
<body>
    
    <main>
        <?= $content ?>
    </main>
</body>
</html>