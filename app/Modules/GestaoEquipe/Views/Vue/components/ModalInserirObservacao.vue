<script setup lang="ts">

import InserirObservacaoForm from "../../../Submodules/Observacao/Views/Vue/components/InserirObservacaoForm.vue";
import {ref} from "vue";
import {UsuarioInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Usuario.interface";
const props = defineProps({
    usuario: {
        type: Object as UsuarioInterface,
        required: true
    }
});
const emits = defineEmits(['close']);
const dialog = ref<boolean>(false);
</script>

<template>
    <v-btn @click="dialog = true" color="primary">Inserir observação</v-btn>
    <v-dialog
        v-model="dialog"
        persistent
        @close="emit('close')"
    >
        <v-card>
            <v-toolbar title="Inserir observação">
                <v-btn
                    icon="mdi-close"
                    @click="dialog = false"
                ></v-btn>
            </v-toolbar>
            <v-card-text>
                <InserirObservacaoForm @close="() => { emits('close'); dialog = false; }" :usuario="props.usuario" />
            </v-card-text>
        </v-card>

    </v-dialog>
</template>

<style scoped>

</style>
