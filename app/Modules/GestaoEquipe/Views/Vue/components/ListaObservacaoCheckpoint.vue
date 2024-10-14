<script setup lang="ts">

import {PermissionStore} from "../../../../../../resources/js/GlobalStore/PermissionStore";
import {PermissionEnum} from "../../../Submodules/Observacao/Views/Vue/Enums/PermissionEnum";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import CheckpointObservacaoInterface from "../Interfaces/CheckpointObservacao.interface";
import ObservacaoCheckpointTimelineItem from "./ObservacaoCheckpointTimelineItem.vue";
import {PermissionEnum as PermissionEnumCheckpoint} from "../../../Submodules/Checkpoint/Views/Vue/Enums/PermissionEnum";
import {onMounted, ref, watch} from "vue";
import moment from "moment";
import {useToast} from "vue-toast-notification";
import {axiosApi} from "../../../../../../resources/js/APIUtils/AxiosBase";
const props = defineProps({
    idUsuario: {
        type: Number,
        required: true
    },
    inicio: {
        type: String,
        default: moment().startOf('month').format('YYYY-MM-DD')
    },
    termino: {
        type: String,
        default: moment().endOf('month').format('YYYY-MM-DD')
    }
});
const $toast = useToast();
const observacoesCheckpoints = ref<CheckpointObservacaoInterface[]>([]);


const loadObservacoesCheckpoints = async () => {
    //LoaderStore.setShowLoader();
    let url = `gestao-equipe/${props.idUsuario}/registros?idEquipe=${getIdEquipe()}`;
    if(props.inicio){
        url += `&inicio=${props.inicio}`;
    }
    if(props.termino){
        url += `&termino=${props.termino}`;
    }
    await axiosApi.get(url)
        .then(response => {
            observacoesCheckpoints.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    //LoaderStore.setHideLoader();
}
onMounted(async () => {
    await loadObservacoesCheckpoints()
});
</script>

<template>
    <v-card >

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
