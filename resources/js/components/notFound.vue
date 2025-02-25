<template>
    <div class="flex flex-col items-center justify-center h-screen bg-gray-100">
        <h1 class="text-4xl font-bold text-red-600 mb-4">🚨 Página não encontrada!</h1>
        <p class="text-gray-600 text-lg mb-6">Oops! Parece que essa página não existe.</p>

        <router-link to="/" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">
            ⬅️ Voltar para Home
        </router-link>
    </div>
</template>
