<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?= $title ?></title>
</head>
<body>
    <nav>
        <a href="/">Accueil</a>
        <a href="/users">Utilisateurs</a>
        <a href="/register">Inscription</a>
    </nav>
    <main>
        <?= $content ?>
    </main>
</body>
</html>