<div x-data>
    <h2 class="text-center mb-3"
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)"
        x-show="show"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0">Liste des utilisateurs</h2>

    <div class="d-grid w-75 mx-auto gap-2" style="grid-template-columns: repeat(5, 1fr);">
        <?php foreach ($users as $index => $user): ?>
            <div class="card d-flex align-items-center p-2"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, <?= ($index * 50) + 200 ?>)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-on:mouseenter="$el.style.transform = 'scale(1.05)'"
                 x-on:mouseleave="$el.style.transform = 'scale(1)'"
                 style="transition: transform 0.2s;">
                <p><strong><?= htmlspecialchars($user['username']) ?></strong></p>
                <p><?= htmlspecialchars($user['bio']) ?> </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
