<h2 class="text-center">Vos posts</h2>
<div class="w-50 mx-auto">
    <?php if (empty($posts)) : ?>
        <p>Vous n'avez encore publié aucun post.</p>
    <?php else : ?>
        <?php foreach ($posts as $index => $post) : ?>
            <div class="post rounded">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <?php if (!empty($post['image'])) : ?>
                    <div class="container-img w-25" 
                        x-data="{ loaded: false }"
                        x-init="setTimeout(() => loaded = true, <?= ($index * 100) + 200 ?>)"
                        x-show="loaded"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">
                        <img src="/assets/img/uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['idUser']): ?>
                    <button class="delete-post btn btn-sm btn-danger mt-2" 
                        data-post-id="<?= $post['id'] ?>"
                        x-data
                        x-on:mouseenter="$el.style.transform = 'scale(1.1)'"
                        x-on:mouseleave="$el.style.transform = 'scale(1)'"
                        style="transition: transform 0.2s;">Supprimer</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>