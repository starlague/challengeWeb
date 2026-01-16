<h2 class="text-center">Vos posts</h2>

<!-- Container for user posts -->
<div class="w-50 mx-auto">
    <?php if (empty($posts)) : ?>
        <!-- Display message if the user has no posts -->
        <div class="text-center">
            <p>Vous n'avez encore publié aucun post.</p>
        </div>        
    <?php else : ?>
        <!-- Loop through each post and display it -->
        <?php foreach ($posts as $index => $post) : ?>
            <div class="post rounded">
                <!-- Display post title -->
                <h3><?= htmlspecialchars($post['title']) ?></h3>

                <!-- Display post image if it exists -->
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

                <!-- Display post content with line breaks -->
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
