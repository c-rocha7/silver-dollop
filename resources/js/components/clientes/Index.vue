<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const clientes = ref([]);
const empresas = ref([]);

const getEmpresas = async () => {
    try {
        const response = await axios.get('/api/empresas');
        empresas.value = response.data.empresas;
    } catch (error) {
        console.error("Erro ao buscar empresas", error);
    }
};

const getClientes = async () => {
    try {
        const response = await axios.get('/api/clientes');
        clientes.value = response.data.clientes;
    } catch (error) {
        console.error("Erro ao buscar clientes", error);
    }
};

onMounted(async () => {
    await getEmpresas();
    await getClientes();
});

const getEmpresaNome = (empresaRecnum) => {
    const empresa = empresas.value.find(e => e.recnum == empresaRecnum);
    return empresa ? empresa.razao_social : 'Desconhecida';
};

const novoCliente = () => {
    router.push("/clientes/store");
};

const onEdit = (recnum) => {
    router.push(`/clientes/${recnum}/edit`);
};

const deleteCliente = async (recnum) => {
    try {
        await axios.delete(`/api/clientes/${recnum}`);
        await getClientes();
    } catch (error) {
        console.error("Erro ao deletar cliente", error);
    }
};
</script>

<template>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Lista de Clientes</h1>

        <div class="flex justify-end mb-4">
            <button @click="novoCliente"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Criar Novo Cliente
            </button>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-left">
                        <th class="px-4 py-3 border">Empresa</th>
                        <th class="px-4 py-3 border">Código</th>
                        <th class="px-4 py-3 border">Razão Social</th>
                        <th class="px-4 py-3 border">Tipo</th>
                        <th class="px-4 py-3 border">CPF/CNPJ</th>
                        <th class="px-4 py-3 border text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cliente in clientes" :key="cliente.recnum" class="border-b hover:bg-gray-100 transition">
                        <td class="px-4 py-3">{{ getEmpresaNome(cliente.empresa) }}</td>
                        <td class="px-4 py-3">{{ cliente.codigo }}</td>
                        <td class="px-4 py-3">{{ cliente.razao_social }}</td>
                        <td class="px-4 py-3">{{ cliente.tipo }}</td>
                        <td class="px-4 py-3">{{ cliente.cpf_cnpj }}</td>
                        <td class="px-4 py-3 flex justify-center space-x-2">
                            <button @click="onEdit(cliente.recnum)"
                                class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button @click="deleteCliente(cliente.recnum)"
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
