<script setup lang="ts">
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {defineProps} from "vue";
import ModalEditAlocacao from "./ModalEditAlocacao.vue";
import {helperStore} from "../HelperStore";
import FinishAlocacao from "./FinishAlocacao.vue";
const props = defineProps({
    alocacao: {
        type: Object as () => AlocacaoInterface,
        required: true
    }
})

</script>

<template>
    <v-row class="px-2">
        <v-col md="12" >
            <modal-edit-alocacao v-if="helperStore.editAlocacao === true" :alocacao-id="props.alocacao.id"/>
            <finish-alocacao v-if="helperStore.finishAlocacao === true" :alocacao-id="props.alocacao.id"/>
        </v-col>
    </v-row>
</template>

<style scoped>

</style>
