<h2 class="text-center">Votre Profil</h2>

<div class="card w-25 p-3 d-flex gap-3 mx-auto">
    <div class="d-flex flex-column text-center">
        <div><strong>Pseudo : </strong><?= $user['username']?></div>
        <div><strong>Bio : </strong><?= $user['bio']?></div>
        <div><strong>Email :</strong><?= $user['email']?></div>
    </div>
    <div>
        <a href="/profil/update" class="edit">Modifier </a>
    </div>
</div>





