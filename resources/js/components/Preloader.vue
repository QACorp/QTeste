<script setup lang="ts">
import {LoaderStore} from "@/GlobalStore/LoaderStore";
import {watchEffect, ref} from "vue";
const dialog = ref<Number>(0);
watchEffect(() => {
    dialog.value = LoaderStore.showLoader;
});
</script>

<template>
    <v-dialog
        v-model="LoaderStore.showLoader"
        hide-overlay
        persistent
        width="300"
        lazy
    >
        <v-card
            color="gray"
            dark
        >
            <v-card-text>
                Carregando...
                <v-progress-linear
                    indeterminate
                    color="white"
                    class="mb-0"
                ></v-progress-linear>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
