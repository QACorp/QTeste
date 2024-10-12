<script setup lang="ts">
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {defineProps} from "vue";
import ModalEditAlocacao from "./ModalEditAlocacao.vue";
import FinishAlocacao from "./FinishAlocacao.vue";
import moment from "moment";
import InserirCheckpoint from "../../../../Checkpoint/Views/Vue/components/InserirCheckpoint.vue";
import {PermissionStore} from "../../../../../../../../resources/js/GlobalStore/PermissionStore";
import {PermissionEnum} from "../Enums/PermissionEnum";
import {PermissionEnum as CheckpointPermissionEnum} from "../../../../Checkpoint/Views/Vue/Enums/PermissionEnum";
const props = defineProps({
    alocacao: {
        type: Object as () => AlocacaoInterface,
        required: true,
    }
})

</script>

<template>
    <v-row class="px-2">
        <v-col md="12" >
            <modal-edit-alocacao
                :can-edit="!props.alocacao.concluida &&
                            moment(props.alocacao.termino,'YYYY-MM-DD').isSameOrAfter(moment(new Date().setHours(0,0,0,0))) &&
                            PermissionStore.hasPermission(PermissionEnum.CRIAR_ALOCACAO)"
                :alocacao-id="props.alocacao.id"
            />
            <finish-alocacao v-if="PermissionStore.hasPermission(PermissionEnum.CONCLUIR_ALOCACAO)" :alocacao-id="props.alocacao.id"/>
            <inserir-checkpoint v-if="PermissionStore.hasPermission(CheckpointPermissionEnum.CRIAR_CHECKPOINT) || !props.alocacao.concluida" :usuario="props.alocacao.user"/>
        </v-col>
    </v-row>
</template>

<style scoped>

</style>
