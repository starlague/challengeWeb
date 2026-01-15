<div class="w-75 mx-auto post-form rounded mb-5">

    <form method="POST" enctype="multipart/form-data" class="p-4 d-flex flex-column gap-2">
        <h2>Créer un post</h2>
        <div>
            <input type="text" name="title" placeholder="Titre" class="form-control" required>
        </div>
        <div>
            <textarea name="content" placeholder="Contenu" class="form-control" required></textarea>
        </div>
        <div>
            <input type="file" name="image" accept="image/*" class="form-control">
        </div>
        <div class="mt-1">
            <button type="submit" class="publish">Publier</button>
        </div>
    </form>
</div>

<div class="w-75 mx-auto rounded">
    <h2>Posts</h2>

    <div class="d-grid p-2 mx-auto gap-2" style="grid-template-columns: repeat(4, 1fr);">
        
        <?php foreach ($posts as $post): ?>
            <div class="post rounded">
                <h3><?= htmlspecialchars($post['title']) ?></h3>

                <?php if (!empty($post['image'])): ?>
                    <div class="container-img">               
                        <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded">
                    </div>
                <?php endif; ?>

                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>