<template>
    <div class="flex flex-col items-center justify-center h-screen bg-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">🏠 Home</h1>

        <div class="flex gap-4">
            <router-link to="/empresas"
                class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">
                Listar Empresas
            </router-link>
            <router-link to="/clientes"
                class="bg-green-500 text-white px-6 py-3 rounded-lg shadow hover:bg-green-600 transition">
                Listar Clientes
            </router-link>
        </div>
    </div>
</template>
