<?php if (!empty($_SESSION['error'])): ?>
    <div style="color: red; padding: 10px; background: #ffe0e0; border-radius: 5px; margin-bottom: 20px;">
        ❌ <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<form action="/register" method="post" class="w-50 d-flex flex-column gap-3" enctype="multipart/form-data">
        <div>
            <label for="username">Pseudo : </label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div>
            <label for="email">Email : </label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div>
            <label for="password">Mot de passe : </label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div>
            <label for="bio">Bio : </label>
            <textarea name="bio" id="bio" required></textarea>
        </div>

        <div>
            <button type="submit" class="submit">S'inscrire</button>
        </div>
    </form>