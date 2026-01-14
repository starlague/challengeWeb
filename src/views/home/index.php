<h2>Créer un post</h2>

<form method="post">
    <input type="text" name="title" placeholder="Titre" required><br><br>
    <textarea name="content" placeholder="Contenu" required></textarea><br><br>
    <button type="submit">Publier</button>
</form>

<h2>Posts</h2>

<?php foreach ($posts as $post): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?= htmlspecialchars($post['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <small>Par <?= htmlspecialchars($post['username']) ?></small>
    </div>
<?php endforeach; ?>
