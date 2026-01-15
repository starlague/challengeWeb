


<?php if (isset($_SESSION['user'])): ?>
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
<?php else: ?>
    <p>Connectez-vous pour publier un post.</p>
<?php endif; ?>

<div class="w-75 mx-auto rounded">
    <h2>Posts</h2>

<?php
use App\Controllers\CommentController;
$commentController = new CommentController();
?>

<?php if (!empty($posts)): ?>
  <div class="d-grid p-2 mx-auto gap-2" id="post-<?= $post['id'] ?> style="grid-template-columns: repeat(4, 1fr);">
        
        <?php foreach ($posts as $post): ?>
            <div class="post rounded">
                <h3><?= htmlspecialchars($post['title']) ?></h3>

                <?php if (!empty($post['image'])): ?>
                    <div class="container-img">               
                        <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded">
                    </div>
                <?php endif; ?>

                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <small>Par <strong><?= htmlspecialchars($post['username']) ?></strong></small>
            </div>
        <?php endforeach; ?>
    </div>

            <!-- COMMENTAIRES -->
            <div class="comments">
                <h4>Commentaires :</h4>

                <?php $comments = $commentController->getCommentsForPost($post['id']); ?>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <strong><?= htmlspecialchars($comment['username']) ?></strong> :
                            <?= nl2br(htmlspecialchars($comment['content'])) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun commentaire pour le moment.</p>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])): ?>
                    <form class="comment-form" data-post-id="<?= $post['id'] ?>">
                        <textarea name="comment_content" placeholder="Écrire un commentaire..." required></textarea><br>
                        <button type="submit">Commenter</button>
                    </form>
                <?php else: ?>
                    <p>Connectez-vous pour commenter.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun post pour le moment.</p>
<?php endif; ?>

<!-- SCRIPT AJAX -->
<script>
document.querySelectorAll('.comment-form').forEach(form => {
    form.addEventListener('submit', async e => {
        e.preventDefault();

        const postId = form.dataset.postId;
        const textarea = form.querySelector('textarea');
        const content = textarea.value;

        if (!content) return;

        const formData = new FormData();
        formData.append('comment_post_id', postId);
        formData.append('comment_content', content);

        const response = await fetch('/ajax/comment', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });

        if (response.ok) {
            const data = await response.json();
            const commentsDiv = form.closest('.comments');
            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.innerHTML = `<strong>${data.username}</strong> : ${data.content}`;
            commentsDiv.insertBefore(newComment, form);
            textarea.value = '';
        } else {
            alert('Erreur lors de l\'envoi du commentaire.');
        }
    });
});
</script>

