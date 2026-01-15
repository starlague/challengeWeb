<?php if (!empty($_SESSION['error'])): ?>
    <div class="error ms-3 me-3">
        ❌ <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<div class="d-flex justify-content-center">
    <form action="/login" method="post" class="w-50 d-flex flex-column gap-3" enctype="multipart/form-data">
        <div>
            <label for="email">Email : </label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
    
        <div>
            <label for="password">Mot de passe : </label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div>
            <button type="submit" class="submit">Se connecter</button>
        </div>
    </form>
</div>