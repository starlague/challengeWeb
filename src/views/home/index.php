<h2>Créer un post</h2>

<?php if (isset($_SESSION['user'])): ?>
    <p>Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></p>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre" required><br><br>
        <textarea name="content" placeholder="Contenu" required></textarea><br><br>
        <input type="file" name="image" accept="image/*"><br><br>
        <button type="submit">Publier</button>
    </form>
<?php else: ?>
    <p>Vous devez être connecté pour publier un post.</p>
<?php endif; ?>

<h2>Posts</h2>

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
            <h3><?= htmlspecialchars($post['title']) ?></h3>

            <?php if (!empty($post['image'])): ?>
                <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" style="max-width:300px; display:block; margin-bottom:10px;">
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <small>Par <strong><?= htmlspecialchars($post['username']) ?></strong></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun post pour le moment.</p>
<?php endif; ?>
