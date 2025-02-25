<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const empresas = ref([]);

onMounted(async () => {
    await getEmpresas();
});

const getEmpresas = async () => {
    try {
        const response = await axios.get('/api/empresas');
        empresas.value = response.data.empresas;
    } catch (error) {
        console.error("Erro ao buscar empresas:", error);
    }
};

const novaEmpresa = () => {
    router.push('/empresas/store');
};

const onEdit = (recnum) => {
    router.push(`/empresas/${recnum}/edit`);
};

const deleteEmpresa = async (recnum) => {
    try {
        await axios.delete(`/api/empresas/${recnum}`);
        getEmpresas();
    } catch (error) {
        console.error("Erro ao deletar empresa:", error);
    }
};
</script>

<template>
    <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Lista de Empresas</h1>

        <div class="flex justify-between mb-4">
            <router-link to="/" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">
                ⬅️ Voltar para Home
            </router-link>
            <button @click="novaEmpresa"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Criar Nova Empresa
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-200 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border border-gray-300">Código</th>
                        <th class="px-4 py-2 border border-gray-300">Empresa</th>
                        <th class="px-4 py-2 border border-gray-300">Sigla</th>
                        <th class="px-4 py-2 border border-gray-300">Razão Social</th>
                        <th class="px-4 py-2 border border-gray-300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="empresa in empresas" :key="empresa.recnum"
                        class="border border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-center border border-gray-300">{{ empresa.codigo }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ empresa.empresa }}</td>
                        <td class="px-4 py-2 text-center border border-gray-300">{{ empresa.sigla }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ empresa.razao_social }}</td>
                        <td class="px-4 py-3 flex justify-center space-x-2">
                            <button @click="onEdit(empresa.recnum)"
                                class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button @click="deleteEmpresa(empresa.recnum)"
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
