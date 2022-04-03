<template>
    <div>
        <component :is="layout">
            <router-view />
        </component>
    </div>
</template>

<script lang="ts">
const defaultLayout = "default";

export default {
    computed: {
        layout(): string {
            return (this.$route.meta.layout || defaultLayout) + '-layout';
        }
    }
}
</script>
