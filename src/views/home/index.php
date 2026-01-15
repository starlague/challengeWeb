<?php if (isset($_SESSION['user'])): ?>
  <div class="mx-auto post-form rounded mb-5">
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
              <button type="submit" class="publish mt-1">Publier</button>
          </div>
      </form>
  </div>
<?php else: ?>
    <div class="ms-5">
        <p>Connectez-vous pour publier un post.</p>
    </div>
<?php endif; ?>

<div class="mx-auto rounded posts-container">
    <?php if (!empty($posts)): ?>
        <div class="d-grid p-2 mx-auto gap-2" style="grid-template-columns: repeat(4, 1fr);">
        <?php foreach ($posts as $post): ?>
            <div class="post rounded" id="post-<?= $post['id'] ?>">
                <h3><?= htmlspecialchars($post['title']) ?></h3>

                <?php if (!empty($post['image'])): ?>
                    <div class="container-img">
                        <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                    </div>
                <?php endif; ?>

                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <small>Par <strong><?= htmlspecialchars($post['username']) ?></strong></small>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['idUser']): ?>
                    <button class="delete-post btn btn-sm btn-danger mt-2" data-post-id="<?= $post['id'] ?>">Supprimer</button>
                <?php endif; ?>

                <div class="comments mt-3">
                    <h4>Commentaires :</h4>
                    <div class="comments-list">
                        <?php if (!empty($post['comments'])): ?>
                            <?php foreach ($post['comments'] as $comment): ?>
                                <div class="comment">
                                    <strong><?= htmlspecialchars($comment['username']) ?></strong> :
                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun commentaire pour le moment.</p>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['user'])): ?>
                        <form class="comment-form" data-post-id="<?= $post['id'] ?>">
                            <textarea name="comment_content" placeholder="Écrire un commentaire..." required></textarea>
                            <button type="submit">Commenter</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun post pour le moment.</p>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.comment-form').forEach(form => {
    form.addEventListener('submit', async e => {
        e.preventDefault();
        const postId = form.dataset.postId;
        const textarea = form.querySelector('textarea');
        const content = textarea.value.trim();
        if (!content) return;

        const formData = new FormData();
        formData.append('comment_post_id', postId);
        formData.append('comment_content', content);

        try {
            const response = await fetch('/ajax/comment', { method: 'POST', body: formData, credentials: 'same-origin' });
            const text = await response.text();
            console.log(text);
            const data = JSON.parse(text);

            const commentsList = form.closest('.comments').querySelector('.comments-list');
            const noCommentMsg = commentsList.querySelector('p');
            if (noCommentMsg) noCommentMsg.remove();

            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.innerHTML = `<strong>${data.username}</strong> : ${data.content}`;
            commentsList.appendChild(newComment);

            textarea.value = '';
        } catch (error) {
            alert('Erreur serveur. Voir console.');
            console.error(error);
        }
    });
});

document.querySelectorAll('.delete-post').forEach(button => {
    button.addEventListener('click', async () => {
        if (!confirm("Voulez-vous vraiment supprimer ce post ?")) return;

        const postId = button.dataset.postId;
        const formData = new FormData();
        formData.append('post_id', postId);

        try {
            const response = await fetch('/post/delete', { method: 'POST', body: formData, credentials: 'same-origin' });
            const text = await response.text();
            console.log(text);
            const data = JSON.parse(text);

            if (data.success) {
                const postDiv = document.getElementById('post-' + postId);
                if (postDiv) postDiv.remove();
            } else {
                alert(data.error || 'Erreur lors de la suppression.');
            }
        } catch (error) {
            alert('Erreur serveur. Voir console.');
            console.error(error);
        }
    });
});
</script>

