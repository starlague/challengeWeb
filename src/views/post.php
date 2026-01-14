<h2>Créer un nouveau post</h2>
<form action="" method="post">
    <input type="text" name="title" placeholder="Titre" required><br><br>
    <textarea name="content" placeholder="Écris ton post..." required></textarea><br><br>
    <button type="submit">Publier</button>
</form>

<h2>Posts récents</h2>
<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <small>Par <?= htmlspecialchars($post['username']) ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun post pour le moment.</p>
<?php endif; ?>
