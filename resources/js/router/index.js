import { createRouter, createWebHashHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "ExampleComponent",
        component: () =>
            import("../components/ExampleComponent")
    },
    {
        path: "/:catchAll(.*)",
        redirect: "/"
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
