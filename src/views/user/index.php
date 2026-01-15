<div>
    <h2 class="text-center mb-3">Liste des utilisateurs</h2>

    <div class="d-grid w-75 mx-auto gap-2" style="grid-template-columns: repeat(5, 1fr);">
        <?php foreach ($users as $user): ?>
            <div class="card d-flex align-items-center p-2">
                <p><strong><?= htmlspecialchars($user['username']) ?></strong></p>
                <p><?= htmlspecialchars($user['bio']) ?> </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
