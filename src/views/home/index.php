<h2>Créer un post</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Titre" required><br><br>
    <textarea name="content" placeholder="Contenu" required></textarea><br><br>
    <input type="file" name="image" accept="image/*"><br><br>
    <button type="submit">Publier</button>
</form>

<h2>Posts</h2>

<?php foreach ($posts as $post): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
        <h3><?= htmlspecialchars($post['title']) ?></h3>

        <?php if (!empty($post['image'])): ?>
            <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" style="max-width:300px; display:block; margin-bottom:10px;">
        <?php endif; ?>

        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <small>Par <?= htmlspecialchars($post['username']) ?></small>
    </div>
<?php endforeach; ?>
