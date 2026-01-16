<?php if (isset($_SESSION['user'])): ?>
<!-- Display post creation form if user is logged in -->
<div class="mx-auto post-form rounded mb-5" 
     x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0">
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
        <div>
            <button type="submit" class="publish mt-1" 
                    x-data 
                    x-on:mouseenter="$el.style.transform = 'scale(1.05)'" 
                    x-on:mouseleave="$el.style.transform = 'scale(1)'"
                    style="transition: transform 0.2s;">Publier</button>
        </div>
    </form>
</div>
<?php else: ?>
<!-- Message if user is not logged in -->
<div class="ms-5" x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100">
    <p>Connectez-vous pour publier un post.</p>
</div>
<?php endif; ?>

<!-- Display list of posts -->
<div class="mx-auto rounded posts-container" x-data>
    <h2>Posts</h2>
    <?php if (!empty($posts)): ?>
    <div class="d-grid p-2 mx-auto gap-2" style="grid-template-columns: repeat(4, 1fr);">
        <?php foreach ($posts as $index => $post): ?>
        <!-- Individual post -->
        <div class="post rounded" 
             id="post-<?= $post['id'] ?>"
             x-data="{ show: false, deleting: false }"
             x-init="setTimeout(() => show = true, <?= $index * 100 ?>)"
             x-show="show && !deleting"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <h3><?= htmlspecialchars($post['title']) ?></h3>

            <!-- Display post image if exists -->
            <?php if (!empty($post['image'])): ?>
            <div class="container-img" 
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
            <small>Par <strong><?= htmlspecialchars($post['username']) ?></strong></small>

            <!-- Like button -->
            <div class="mt-2">
                <?php if(isset($_SESSION['user'])): ?>
                    <!-- Interactive like button for logged-in users -->
                    <button class="like-btn btn btn-sm <?= $post['likedByUser'] ? 'btn-primary' : 'btn-outline-primary' ?>"
                            data-post-id="<?= $post['id'] ?>">
                        ❤️ <span class="like-count"><?= $post['likes'] ?></span>
                    </button>
                <?php else: ?>
                    <!-- Display like count only for guests -->
                    <span>❤️ <?= $post['likes'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Delete post button for post author -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['idUser']): ?>
            <button class="delete-post btn btn-sm btn-danger mt-2" 
                    data-post-id="<?= $post['id'] ?>"
                    x-data
                    x-on:mouseenter="$el.style.transform = 'scale(1.1)'"
                    x-on:mouseleave="$el.style.transform = 'scale(1)'"
                    style="transition: transform 0.2s;">Supprimer</button>
            <?php endif; ?>

            <!-- Comments section -->
            <div class="comments mt-3">
                <h4>Commentaires :</h4>
                <div class="comments-list" x-data="{ comments: <?= htmlspecialchars(json_encode($post['comments']), ENT_QUOTES, 'UTF-8') ?> }">
                    <?php if (!empty($post['comments'])): ?>
                        <?php foreach ($post['comments'] as $commentIndex => $comment): ?>
                        <!-- Individual comment -->
                        <div class="comment" id="comment-<?= $comment['id'] ?>"
                             x-data="{ show: false }"
                             x-init="setTimeout(() => show = true, <?= $commentIndex * 50 ?>)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0">
                            <strong><?= htmlspecialchars($comment['username']) ?></strong> :
                            <?= nl2br(htmlspecialchars($comment['content'])) ?>
                            <!-- Delete comment button for comment author -->
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $comment['idUser']): ?>
                            <button class="delete-comment btn btn-sm btn-danger ms-2"
                                    data-comment-id="<?= $comment['id'] ?>"
                                    x-data
                                    x-on:mouseenter="$el.style.transform='scale(1.05)'"
                                    x-on:mouseleave="$el.style.transform='scale(1)'"
                                    style="transition: transform 0.2s;">Supprimer</button>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <!-- Message if no comments -->
                    <p x-show="comments.length===0" 
                       x-transition:enter="transition ease-out duration-300"
                       x-transition:enter-start="opacity-0"
                       x-transition:enter-end="opacity-100">Aucun commentaire pour le moment.</p>
                    <?php endif; ?>
                </div>

                <!-- Comment form for logged-in users -->
                <?php if (isset($_SESSION['user'])): ?>
                <form class="comment-form" data-post-id="<?= $post['id'] ?>" x-data="{ submitting: false }" x-on:submit="submitting=true">
                    <textarea name="comment_content" placeholder="Écrire un commentaire..." required></textarea>
                    <button type="submit" x-bind:disabled="submitting"
                            x-on:mouseenter="if(!submitting) $el.style.transform='scale(1.05)'"
                            x-on:mouseleave="$el.style.transform='scale(1)'"
                            style="transition: transform 0.2s;">
                        <span x-show="!submitting">Commenter</span>
                        <span x-show="submitting">Envoi...</span>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Message if no posts -->
    <p x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)" x-show="show"
       x-transition:enter="transition ease-out duration-500"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100">Aucun post pour le moment.</p>
    <?php endif; ?>
</div>

<script>
// --- Comment submission ---
document.querySelectorAll('.comment-form').forEach(form => {
    form.addEventListener('submit', async e => {
        e.preventDefault();
        const postId = form.dataset.postId;
        const textarea = form.querySelector('textarea');
        const content = textarea.value.trim();
        if(!content) return;

        const formData = new FormData();
        formData.append('comment_post_id', postId);
        formData.append('comment_content', content);

        try {
            // Send AJAX request to create comment
            const response = await fetch('/ajax/comment', { method: 'POST', body: formData, credentials:'same-origin' });
            const data = await response.json();

            const commentsList = form.closest('.comments').querySelector('.comments-list');
            const noCommentMsg = commentsList.querySelector('p');
            if(noCommentMsg && noCommentMsg.textContent.includes('Aucun commentaire')) noCommentMsg.remove();

            // Add new comment to the DOM
            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.id = 'comment-' + data.id;
            newComment.innerHTML = `<strong>${data.username}</strong> : ${data.content.replace(/\n/g,'<br>')} <button class="delete-comment btn btn-sm btn-danger ms-2" data-comment-id="${data.id}">Supprimer</button>`;
            commentsList.appendChild(newComment);
            Alpine.initTree(newComment);

            textarea.value='';
            Alpine.$data(form).submitting=false;
        } catch(error){
            alert('Server error. Check console.');
            console.error(error);
            Alpine.$data(form).submitting=false;
        }
    });
});

// --- Delete comment ---
document.addEventListener('click', async e => {
    if(e.target.classList.contains('delete-comment')){
        if(!confirm('Do you want to delete this comment?')) return;

        const commentId = e.target.dataset.commentId;
        const commentDiv = document.getElementById('comment-' + commentId);

        const formData = new FormData();
        formData.append('comment_id', commentId);

        try {
            // Send AJAX request to delete comment
            const res = await fetch('/ajax/comment/delete', { method:'POST', body: formData, credentials:'same-origin' });
            const data = await res.json();
            if(data.success && commentDiv) commentDiv.remove();
        } catch(err){
            console.error(err);
            alert('Server error.');
        }
    }
});

// --- Likes functionality ---
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const postId = btn.dataset.postId;
        const liked = btn.classList.contains('btn-primary');
        const formData = new FormData();
        formData.append('post_id', postId);

        try {
            const url = liked ? '/ajax/unlike' : '/ajax/like';
            const res = await fetch(url, { method: 'POST', body: formData, credentials:'same-origin' });
            const data = await res.json();
            if(data.success) {
                // Toggle button styles and update like count
                btn.classList.toggle('btn-primary');
                btn.classList.toggle('btn-outline-primary');
                btn.querySelector('.like-count').textContent = data.likes;
            } else {
                alert(data.error || 'Like error');
            }
        } catch(e) {
            console.error('Like error:', e);
        }
    });
});
</script>
