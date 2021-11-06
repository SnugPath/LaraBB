<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <div>
                        <p id="times-clicked-counter">Times clicked: {{ count }}</p>
                        <button @click="increment" id="increment-count-button">increment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core"
export default defineComponent({
    name: "ExampleComponent",
    data: () => ({
        count: 0,
    }),
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        increment() {
            this.count++
        },
    },
});
</script>
