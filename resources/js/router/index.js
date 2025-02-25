import { createRouter, createWebHistory } from "vue-router";

import Index from "../components/Index.vue";
import notFound from "../components/notFound.vue";
import empresaIndex from "../components/empresas/Index.vue";
import empresaForm from "../components/empresas/Form.vue";
import clienteIndex from "../components/clientes/Index.vue";
import clienteForm from "../components/clientes/Form.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: Index,
    },
    {
        path: "/empresas",
        name: "empresas.index",
        component: empresaIndex,
    },
    {
        path: "/empresas/store",
        name: "empresas.store",
        component: empresaForm,
    },
    {
        path: "/empresas/:id/edit",
        name: "empresas.edit",
        component: empresaForm,
    },
    {
        path: "/clientes",
        name: "clientes.index",
        component: clienteIndex,
    },
    {
        path: "/clientes/store",
        name: "clientes.store",
        component: clienteForm,
    },
    {
        path: "/clientes/:id/edit",
        name: "clientes.edit",
        component: clienteForm,
    },
    {
        path: "/:pathMatch(.*)*",
        name: "notFound",
        component: notFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
