<h2>Créer un post</h2>

<?php if (isset($_SESSION['user'])): ?>
    <p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></p>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre" required><br><br>
        <textarea name="content" placeholder="Contenu" required></textarea><br><br>
        <input type="file" name="image" accept="image/*"><br><br>
        <button type="submit">Publier</button>
    </form>
<?php else: ?>
    <p>Connectez-vous pour publier un post.</p>
<?php endif; ?>

<h2>Posts</h2>

<?php
use App\Controllers\CommentController;
$commentController = new CommentController();
?>

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="post" id="post-<?= $post['id'] ?>">
            <h3><?= htmlspecialchars($post['title']) ?></h3>

            <?php if (!empty($post['image'])): ?>
                <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" alt="" class="post-image">
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <small>Par <strong><?= htmlspecialchars($post['username']) ?></strong></small>

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
