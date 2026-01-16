<?php if (isset($_SESSION['user'])): ?>
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
<div class="ms-5" x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100">
    <p>Connectez-vous pour publier un post.</p>
</div>
<?php endif; ?>

<div class="mx-auto rounded posts-container" x-data>
    <h2>Post</h2>
    <?php if (!empty($posts)): ?>
    <div class="d-grid p-2 mx-auto gap-2" style="grid-template-columns: repeat(4, 1fr);">
        <?php foreach ($posts as $index => $post): ?>
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

            <?php if (!empty($post['image'])): ?>
            <div class="container-img" 
                 x-data="{ loaded: false }"
                 x-init="setTimeout(() => loaded = true, <?= ($index * 100) + 200 ?>)"
                 x-show="loaded"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <img src="/assets/uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <small>Par <strong><?= htmlspecialchars($post['username']) ?></strong></small>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['idUser']): ?>
            <button class="delete-post btn btn-sm btn-danger mt-2" 
                    data-post-id="<?= $post['id'] ?>"
                    x-data
                    x-on:mouseenter="$el.style.transform = 'scale(1.1)'"
                    x-on:mouseleave="$el.style.transform = 'scale(1)'"
                    style="transition: transform 0.2s;">Supprimer</button>
            <?php endif; ?>

            <div class="comments mt-3">
                <h4>Commentaires :</h4>
                <div class="comments-list" x-data="{ comments: <?= htmlspecialchars(json_encode($post['comments']), ENT_QUOTES, 'UTF-8') ?> }">
                    <?php if (!empty($post['comments'])): ?>
                        <?php foreach ($post['comments'] as $commentIndex => $comment): ?>
                        <div class="comment" id="comment-<?= $comment['id'] ?>"
                             x-data="{ show: false }"
                             x-init="setTimeout(() => show = true, <?= $commentIndex * 50 ?>)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-4"
                             x-transition:enter-end="opacity-100 translate-x-0">
                            <strong><?= htmlspecialchars($comment['username']) ?></strong> :
                            <?= nl2br(htmlspecialchars($comment['content'])) ?>
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
                    <p x-show="comments.length===0" 
                       x-transition:enter="transition ease-out duration-300"
                       x-transition:enter-start="opacity-0"
                       x-transition:enter-end="opacity-100">Aucun commentaire pour le moment.</p>
                    <?php endif; ?>
                </div>

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
    <p x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)" x-show="show"
       x-transition:enter="transition ease-out duration-500"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100">Aucun post pour le moment.</p>
    <?php endif; ?>
</div>

<script>
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
            const response = await fetch('/ajax/comment', { method: 'POST', body: formData, credentials:'same-origin' });
            const data = await response.json();

            const commentsList = form.closest('.comments').querySelector('.comments-list');
            const noCommentMsg = commentsList.querySelector('p');
            if(noCommentMsg && noCommentMsg.textContent.includes('Aucun commentaire')) noCommentMsg.remove();

            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.id = 'comment-' + data.id;
            newComment.setAttribute('x-data','{show:false}');
            newComment.setAttribute('x-init','setTimeout(() => show=true,0)');
            newComment.setAttribute('x-show','show');
            newComment.setAttribute('x-transition:enter','transition ease-out duration-300');
            newComment.setAttribute('x-transition:enter-start','opacity-0 translate-x-4');
            newComment.setAttribute('x-transition:enter-end','opacity-100 translate-x-0');

            const username = document.createElement('strong');
            username.textContent = data.username;
            newComment.appendChild(username);
            newComment.appendChild(document.createTextNode(' : '));

            const contentSpan = document.createElement('span');
            contentSpan.innerHTML = data.content.replace(/\n/g,'<br>');
            newComment.appendChild(contentSpan);

            if(data.isAuthor){
                const deleteBtn = document.createElement('button');
                deleteBtn.classList.add('delete-comment','btn','btn-sm','btn-danger','ms-2');
                deleteBtn.textContent = 'Supprimer';
                deleteBtn.dataset.commentId = data.id;
                deleteBtn.style.transition='transform 0.2s';
                deleteBtn.addEventListener('mouseenter',()=>deleteBtn.style.transform='scale(1.05)');
                deleteBtn.addEventListener('mouseleave',()=>deleteBtn.style.transform='scale(1)');
                deleteBtn.addEventListener('click', async ()=> {
                    if(!confirm("Voulez-vous vraiment supprimer ce commentaire ?")) return;
                    newComment.remove();
                    const fdata = new FormData();
                    fdata.append('comment_id', data.id);
                    await fetch('/ajax/comment/delete', { method:'POST', body:fdata, credentials:'same-origin' });
                });
                newComment.appendChild(deleteBtn);
            }

            commentsList.appendChild(newComment);
            Alpine.initTree(newComment);
            textarea.value='';
            Alpine.$data(form).submitting=false;
        } catch(error){
            alert('Erreur serveur. Voir console.');
            console.error(error);
            Alpine.$data(form).submitting=false;
        }
    });
});

// Suppression des posts
document.querySelectorAll('.delete-post').forEach(button=>{
    button.addEventListener('click', async ()=>{
        if(!confirm("Voulez-vous vraiment supprimer ce post ?")) return;
        const postId = button.dataset.postId;
        const postDiv = document.getElementById('post-'+postId);
        const alpineData = Alpine.$data(postDiv);
        if(alpineData) alpineData.deleting=true;
        await new Promise(r=>setTimeout(r,300));
        const fdata = new FormData();
        fdata.append('post_id', postId);
        try{
            const response = await fetch('/post/delete',{method:'POST',body:fdata,credentials:'same-origin'});
            const data = await response.json();
            if(data.success){
                if(postDiv){
                    if(alpineData) alpineData.show=false;
                    await new Promise(r=>setTimeout(r,300));
                    postDiv.remove();
                }
            } else{
                alert(data.error||'Erreur lors de la suppression.');
                if(alpineData) alpineData.deleting=false;
            }
        }catch(error){
            alert('Erreur serveur. Voir console.');
            console.error(error);
            if(alpineData) alpineData.deleting=false;
        }
    });
});

// Suppression des commentaires existants
document.querySelectorAll('.delete-comment').forEach(button=>{
    button.addEventListener('click', async ()=>{
        if(!confirm("Voulez-vous vraiment supprimer ce commentaire ?")) return;
        const commentId = button.dataset.commentId;
        const commentDiv = document.getElementById('comment-'+commentId);
        commentDiv.remove();
        const fdata = new FormData();
        fdata.append('comment_id', commentId);
        await fetch('/ajax/comment/delete',{method:'POST',body:fdata,credentials:'same-origin'});
    });
});
</script>
