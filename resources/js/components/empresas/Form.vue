<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

const editMode = ref(false);
const errors = ref({});

const form = reactive({
    codigo: "",
    empresa: "",
    sigla: "",
    razao_social: "",
});

onMounted(async () => {
    if (route.name === "empresas.edit") {
        editMode.value = true;
        await getEmpresa();
    }
});

const getEmpresa = async () => {
    try {
        const response = await axios.get(`/api/empresas/${route.params.id}/edit`);
        Object.assign(form, response.data.empresa);
    } catch (error) {
        console.error("Erro ao buscar empresa:", error);
    }
};

const saveEmpresa = async () => {
    try {
        if (editMode.value) {
            await axios.put(`/api/empresas/${route.params.id}`, form);
        } else {
            await axios.post('/api/empresas', form);
        }
        router.push("/empresas");
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
            {{ editMode ? "Editar Empresa" : "Criar Empresa" }}
        </h1>

        <div class="space-y-4">
            <!-- Código da Empresa -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Código da Empresa</label>
                <input type="text" v-model="form.codigo"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.codigo" class="text-red-500 text-sm mt-1">{{ errors.codigo }}</p>
            </div>

            <!-- Empresa -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Empresa</label>
                <input type="text" v-model="form.empresa"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.empresa" class="text-red-500 text-sm mt-1">{{ errors.empresa }}</p>
            </div>

            <!-- Sigla -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Sigla</label>
                <input type="text" v-model="form.sigla"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.sigla" class="text-red-500 text-sm mt-1">{{ errors.sigla }}</p>
            </div>

            <!-- Razão Social -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Razão Social</label>
                <input type="text" v-model="form.razao_social"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                <p v-if="errors.razao_social" class="text-red-500 text-sm mt-1">{{ errors.razao_social }}</p>
            </div>

            <!-- Botão de Salvar -->
            <div class="flex justify-between">
                <router-link to="/empresas"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 transition">
                    ⬅️ Voltar para Listar Empresas
                </router-link>
                <button @click="saveEmpresa"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    {{ editMode ? "Salvar Alterações" : "Criar Empresa" }}
                </button>
            </div>
        </div>
    </div>
</template>
