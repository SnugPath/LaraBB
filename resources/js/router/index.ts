import { createRouter, createWebHashHistory } from "vue-router";

declare module 'vue-router' {
    interface RouteMeta {
        layout?: string
    }
}


const routes = [
    {
        path: "/",
        name: "ExampleComponent",
        component: () =>
            import("../components/ExampleComponent.vue"),
        meta: {
            layout: 'default'
        }
    },
    {
        path: "/login",
        name: "LoginComponent",
        component: () =>
            import("../pages/Login.vue"),
        meta: {
            layout: 'login'
        }
    },
    {
        path: "/:catchAll(.*)",
        redirect: "/"
    }
];
// @ts-ignore
const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
