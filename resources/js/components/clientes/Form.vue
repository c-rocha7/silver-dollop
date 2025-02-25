<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

const editMode = ref(false);
const errors = ref({});

const tipos = ref([
    { value: "PF" },
    { value: "PJ" }
]);

const empresas = ref([]);
const form = reactive({
    empresa: "",
    codigo: "",
    razao_social: "",
    tipo: "",
    cpf_cnpj: "",
});

onMounted(async () => {
    await getEmpresas();

    if (route.name === "clientes.edit") {
        editMode.value = true;
        await getCliente();
    }
});

const getEmpresas = async () => {
    try {
        const response = await axios.get('/api/empresas');
        empresas.value = response.data.empresas;
    } catch (error) {
        console.error("Erro ao buscar empresas:", error);
    }
};

const getCliente = async () => {
    try {
        const response = await axios.get(`/api/clientes/${route.params.id}/edit`);
        Object.assign(form, response.data.cliente);
    } catch (error) {
        console.error("Erro ao buscar cliente:", error);
    }
};

const saveCliente = async () => {
    try {
        if (editMode.value) {
            await axios.put(`/api/clientes/${route.params.id}`, form);
        } else {
            await axios.post('/api/clientes', form);
        }
        router.push("/clientes");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
    }
};
</script>

<template>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ editMode ? "Editar Cliente" : "Criar Cliente" }}
        </h1>

        <div class="space-y-4">
            <!-- Empresa -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Empresa</label>
                <select v-model="form.empresa"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    <option value="" disabled>Selecione uma empresa</option>
                    <option v-for="empresa in empresas" :key="empresa.recnum" :value="empresa.recnum">
                        {{ empresa.razao_social }}
                    </option>
                </select>
                <p v-if="errors.empresa" class="text-red-500 text-sm mt-1">{{ errors.empresa }}</p>
            </div>

            <!-- Código do Cliente -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Código do Cliente</label>
                <input type="text" v-model="form.codigo"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.codigo" class="text-red-500 text-sm mt-1">{{ errors.codigo }}</p>
            </div>

            <!-- Razão Social -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Razão Social</label>
                <input type="text" v-model="form.razao_social"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.razao_social" class="text-red-500 text-sm mt-1">{{ errors.razao_social }}</p>
            </div>

            <!-- Tipo -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Tipo</label>
                <select v-model="form.tipo" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    <option v-for="tipo in tipos" :key="tipo.value" :value="tipo.value">
                        {{ tipo.value }}
                    </option>
                </select>
                <p v-if="errors.tipo" class="text-red-500 text-sm mt-1">{{ errors.tipo }}</p>
            </div>

            <!-- CPF/CNPJ -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">CPF/CNPJ</label>
                <input type="text" v-model="form.cpf_cnpj"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.cpf_cnpj" class="text-red-500 text-sm mt-1">{{ errors.cpf_cnpj }}</p>
            </div>

            <!-- Botão de Salvar -->
            <div class="flex justify-end">
                <button @click="saveCliente"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    {{ editMode ? "Salvar Alterações" : "Criar Cliente" }}
                </button>
            </div>
        </div>
    </div>
</template>
