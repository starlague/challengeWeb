<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalkSpace - <?= $title ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/logofinal.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/style.css">
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<!-- Header section -->
<header class="p-2 mb-5 m-2 sticky-top d-grid" 
        style="grid-template-columns: repeat(3, 1fr);" 
        x-data="{ loaded: false }" 
        x-init="loaded = true" 
        x-show="loaded" 
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="opacity-0 -translate-y-2" 
        x-transition:enter-end="opacity-100 translate-y-0">
    
    <!-- Logo and title -->
    <div class="d-flex gap-2 align-items-center">
        <img src="/assets/img/logo-simple.png" alt="" class="logo img-fluid">
        <h1>TalkSpace</h1>
    </div>

    <!-- Navigation menu -->
    <nav class="d-flex gap-3 align-items-center justify-content-center">
        <a href="/" class="link" x-data x-on:mouseenter="$el.style.transform = 'scale(1.05)'" x-on:mouseleave="$el.style.transform = 'scale(1)'" style="transition: transform 0.2s;">Accueil <i class="bi bi-house"></i></a>
        <a href="/profil" class="link" x-data x-on:mouseenter="$el.style.transform = 'scale(1.05)'" x-on:mouseleave="$el.style.transform = 'scale(1)'" style="transition: transform 0.2s;">Votre profil<i class="bi bi-person"></i></a>
        <a href="/post" class="link" x-data x-on:mouseenter="$el.style.transform = 'scale(1.05)'" x-on:mouseleave="$el.style.transform = 'scale(1)'" style="transition: transform 0.2s;">Vos post <i class="bi bi-card-text"></i></a>
    </nav>

    <!-- User authentication links -->
    <div class="d-flex gap-2 ms-auto align-items-center">
        <?php if (!isset($_SESSION['user'])): ?>
            <!-- Show register/login if user is not logged in -->
            <a href="/register" class="signin" x-data x-on:mouseenter="$el.style.transform = 'scale(1.05)'" x-on:mouseleave="$el.style.transform = 'scale(1)'" style="transition: transform 0.2s;">S'inscrire <i class="bi bi-person-plus"></i></a>
            <a href="/login" class="login" x-data x-on:mouseenter="$el.style.transform = 'scale(1.05)'" x-on:mouseleave="$el.style.transform = 'scale(1)'" style="transition: transform 0.2s;">Se connecter <i class="bi bi-box-arrow-in-right"></i></a>
        <?php else : ?>
            <!-- Show logout if user is logged in -->
            <a href="/logout" class="logout" x-data x-on:mouseenter="$el.style.transform = 'scale(1.05)'" x-on:mouseleave="$el.style.transform = 'scale(1)'" style="transition: transform 0.2s;">Se déconnecter <i class="bi bi-box-arrow-left"></i></a>
        <?php endif; ?>
    </div>
</header>

<body>
    <!-- Main content injected from controllers -->
    <main>
        <?= $content ?>
    </main>
</body>
</html>
