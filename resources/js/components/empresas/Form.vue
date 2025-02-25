<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();

const route = useRoute();

let errors = ref([])

const editMode = ref(false);

onMounted(() => {
    if (route.name === "empresas.edit") {
        editMode.value = true;
        getEmpresa();
    }
})

const getEmpresa = async () => {
    let response = await axios.get(`/api/empresas/${route.params.id}/edit`)
        .then((response) => {
            form.codigo = response.data.empresa.codigo;
            form.empresa = response.data.empresa.empresa;
            form.sigla = response.data.empresa.sigla;
            form.razao_social = response.data.empresa.razao_social;
        });
};

const form = reactive({
    codigo: "",
    empresa: "",
    sigla: "",
    razao_social: "",
});

const saveEmpresa = (values, actions) => {
    if (editMode.value) {
        updateEmpresa(values, actions)
    } else {
        createEmpresa(values, actions)
    }
};

const createEmpresa = (values, actions) => {
    axios.post('/api/empresas', form)
        .then((response) => {
            router.push("/empresas")
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        });
}

const updateEmpresa = (values, actions) => {
    axios.put(`/api/empresas/${route.params.id}`, form)
        .then((response) => {
            router.push("/empresas")
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        });
};

</script>

<template>
    <div>
        <h1>Formulário Empresas</h1>
    </div>

    <div>
        <p>Código da empresa</p>
        <input type="text" v-model="form.codigo">
        <small v-if="errors.codigo">{{ errors.codigo }}</small>

        <p>Empresa</p>
        <input type="text" v-model="form.empresa">
        <small v-if="errors.empresa">{{ errors.empresa }}</small>

        <p>Sigla</p>
        <input type="text" v-model="form.sigla">
        <small v-if="errors.sigla">{{ errors.sigla }}</small>

        <p>Razão Social</p>
        <input type="text" v-model="form.razao_social">
        <small v-if="errors.razao_social">{{ errors.razao_social }}</small>

        <button @click="saveEmpresa">
            <span v-if="editMode">Editar</span>
            <span v-else>Criar</span>
            Empresa
        </button>
    </div>
</template>
