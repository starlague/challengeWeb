<h2 class="text-center"
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 100)"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0">Votre Profil</h2>

<div class="card w-25 p-3 d-flex gap-3 mx-auto"
     x-data="{ show: false }"
     x-init="setTimeout(() => show = true, 200)"
     x-show="show"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
     x-transition:enter-end="opacity-100 scale-100 translate-y-0">
    <div class="d-flex flex-column text-center">
        <div x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 300)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <strong>Pseudo : </strong><?= htmlspecialchars($user['username']) ?>
        </div>
        <div x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 400)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <strong>Bio : </strong><?= htmlspecialchars($user['bio']) ?>
        </div>
        <div x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 500)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <strong>Email :</strong><?= htmlspecialchars($user['email']) ?>
        </div>
    </div>
    <div>
        <a href="/profil/update" 
           class="edit"
           x-data
           x-on:mouseenter="$el.style.transform = 'scale(1.1)'"
           x-on:mouseleave="$el.style.transform = 'scale(1)'"
           style="transition: transform 0.2s;">Modifier </a>
    </div>
</div>





