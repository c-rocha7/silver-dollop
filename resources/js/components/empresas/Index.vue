<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

let empresas = ref([])

onMounted(async () => {
    getEmpresas()
})

const novaEmpresa = () => {
    router.push('/empresas/store')
}

const getEmpresas = async () => {
    let response = await axios.get('/api/empresas')
        .then((response) => {
            empresas.value = response.data.empresas
        })
}

const onEdit = (recnum) => {
    router.push(`/empresas/${recnum}/edit`);
}

const deleteEmpresa = (recnum) => {
    axios.delete(`/api/empresas/${recnum}`)
        .then(() => {
            getEmpresas();
        })
}

</script>
<template>
    <div>
        <h1>Listar todas as empresas</h1>
    </div>

    <div>
        <button @click="novaEmpresa">Criar nova empresa</button>
    </div>


    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Empresa</th>
                <th>Sigla</th>
                <th>Razão Social</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="empresa in empresas" :key="empresa.recnum">
                <td>{{ empresa.codigo }}</td>
                <td>{{ empresa.empresa }}</td>
                <td>{{ empresa.sigla }}</td>
                <td>{{ empresa.razao_social }}</td>
                <td>
                    <button>
                        <i class="fas fa-pencil-alt" @click="onEdit(empresa.recnum)"></i>
                    </button>
                    <button>
                        <i class="far fa-trash-alt" @click="deleteEmpresa(empresa.recnum)"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

</template>
