<template>
  <div class="min-h-screen flex flex-col">
    <header class="main-bg-color text-white p-4">
      <h1>Moja aplikacja</h1>
    </header>

    <div class="flex flex-1">
      <aside class="w-60 secondary-bg-color p-4">
        <nav>
          <ul class="space-y-2">
            <li><Link href="/">Dashboard</Link></li>
            <li><Link href="/todo">ToDo</Link></li>
            <li><Link href="/user">Użytkownicy</Link></li>
          </ul>
        </nav>
      </aside>

      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>

    <footer class="main-bg-color text-white p-4 text-center">
      © 2025 Moja aplikacja
    </footer>
  </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
    /* :root {
        --main-bg-color: @apply bg-emerald-700;

    } */
</style>
