<script setup lang="ts">

import {PermissionStore} from "../../../../../../resources/js/GlobalStore/PermissionStore";
import {PermissionEnum} from "../../../Observacao/Views/Vue/Enums/PermissionEnum";
import {LoaderStore} from "../../../../../../resources/js/GlobalStore/LoaderStore";
import {axiosApi} from "../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import CheckpointObservacaoInterface from "../Interfaces/CheckpointObservacao.interface";
import ObservacaoCheckpointTimelineItem from "./ObservacaoCheckpointTimelineItem.vue";
import {PermissionEnum as PermissionEnumCheckpoint} from "../../../Checkpoint/Views/Vue/Enums/PermissionEnum";
import {onMounted, ref} from "vue";
import {useToast} from "vue-toast-notification";
const props = defineProps({
    idUsuario: {
        type: Number,
        required: true
    },
});
const $toast = useToast();
const observacoesCheckpoints = ref<CheckpointObservacaoInterface[]>([]);
const loadObservacoesCheckpoints = async () => {
    LoaderStore.setShowLoader();
    await axiosApi.get(`gestao-equipe/${props.idUsuario}/registros?idEquipe=${getIdEquipe()}`)
        .then(response => {
            observacoesCheckpoints.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    LoaderStore.setHideLoader();
}
onMounted(async () => {
    await loadObservacoesCheckpoints()
});
</script>

<template>
    <v-card >
        <v-toolbar title="Histórico">
<!--            <v-btn-->
<!--                title="Fechar"-->
<!--                icon="mdi-close"-->
<!--                @click="dialog = false"-->
<!--            ></v-btn>-->
        </v-toolbar>
        <v-card-text
            class="overflow-y-auto"
            style="height: 75vh;"
        >
            <v-row>
                <v-col v-if="
                        PermissionStore.hasPermission(PermissionEnum.LISTAR_OBSERVACAO) ||
                        PermissionStore.hasPermission(PermissionEnumCheckpoint.VER_CHECKPOINT)"
                       :cols="12">
                    <v-timeline side="end" v-if="observacoesCheckpoints !== null" truncate-line="end">
                        <ObservacaoCheckpointTimelineItem
                            v-for="observacaoCheckpoint in observacoesCheckpoints"
                            :key="observacaoCheckpoint.id"
                            :observacao-checkpoint="observacaoCheckpoint"
                            @delete="loadObservacoesCheckpoints"
                            @alterar="loadObservacoesCheckpoints"
                        />
                        <v-timeline-item
                            dot-color="success"
                            size="small"
                        >
                            <v-alert
                                variant="tonal"
                                :value="true"
                            >
                                Início
                            </v-alert>
                        </v-timeline-item>
                    </v-timeline>
                    <v-skeleton-loader v-else type="list-item" width="100%" height="100"></v-skeleton-loader>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
