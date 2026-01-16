<div x-data="{ showError: <?= !empty($_SESSION['error']) ? 'true' : 'false' ?> }">
    <?php if (!empty($_SESSION['error'])): ?>
        <div style="color: red; padding: 10px; background: #ffe0e0; border-radius: 5px; margin-bottom: 20px;"
             x-show="showError"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            ❌ <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="d-flex justify-content-center"
         x-data="{ loaded: false }"
         x-init="setTimeout(() => loaded = true, 100)"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <form action="/profil/update" method="post" class="w-50 d-flex flex-column gap-3" enctype="multipart/form-data">
            <div x-data="{ focused: false }">
                <label for="username">Pseudo : </label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       class="form-control" 
                       placeholder="<?= htmlspecialchars($user['username']) ?>"
                       x-on:focus="focused = true"
                       x-on:blur="focused = false"
                       x-bind:class="focused ? 'border-primary' : ''"
                       style="transition: border-color 0.3s;">
            </div>

            <div x-data="{ focused: false }">
                <label for="bio">Bio : </label>
                <textarea name="bio" 
                          id="bio" 
                          class="form-control"
                          x-on:focus="focused = true"
                          x-on:blur="focused = false"
                          x-bind:class="focused ? 'border-primary' : ''"
                          style="transition: border-color 0.3s;"><?= htmlspecialchars($user['bio']) ?></textarea>
            </div>

            <div x-data="{ focused: false }">
                <label for="email">Email : </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-control" 
                       placeholder="<?= htmlspecialchars($user['email']) ?>"
                       x-on:focus="focused = true"
                       x-on:blur="focused = false"
                       x-bind:class="focused ? 'border-primary' : ''"
                       style="transition: border-color 0.3s;">
            </div>
        
            <div x-data="{ focused: false }">
                <label for="password">Mot de passe : </label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="form-control"
                       x-on:focus="focused = true"
                       x-on:blur="focused = false"
                       x-bind:class="focused ? 'border-primary' : ''"
                       style="transition: border-color 0.3s;">
            </div>

            <div>
                <button type="submit" 
                        class="submit"
                        x-data
                        x-on:mouseenter="$el.style.transform = 'scale(1.05)'"
                        x-on:mouseleave="$el.style.transform = 'scale(1)'"
                        style="transition: transform 0.2s;">Valider</button>
            </div>
        </form>
    </div>
</div>