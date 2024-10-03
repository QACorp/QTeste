<script setup lang="ts">
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {ref, watch, watchEffect} from "vue";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";
import {AlocacaoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Alocacao.interface";
import moment from "moment/moment";
import CheckpointTimelineItem from "./CheckpointTimelineItem.vue";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";
import {useToast} from "vue-toast-notification";
import InserirCheckpoint from "./InserirCheckpoint.vue";
import {PermissionStore} from "../../../../../../../resources/js/GlobalStore/PermissionStore";
import {PermissionEnum} from "../Enums/PermissionEnum";
const props = defineProps({
    usuario: {
        type: Object as UsuarioInterface,
        required: true
    },

});
const $toast = useToast();
const dialog = ref(false);
const checkpoints = ref<CheckpointInterface[]>([]);
const loadCheckpoints = async () => {
    LoaderStore.setShowLoader();
    await axiosApi.get(`checkpoint/usuario/${props.usuario.id}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            checkpoints.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    LoaderStore.setHideLoader();
}
watchEffect(async () => {
    if(dialog.value){
        await loadCheckpoints();
    }

});

</script>

<template>
    <v-btn
        class="p-2 mx-1"
        size="sm"
        variant="tonal"
        color="primary"
        @click="dialog = true"
    >
        <v-icon size="sm">mdi-history</v-icon>
    </v-btn>
    <v-dialog
        data-bs-focus="false"
        v-model="dialog"
        min-width="50%"
        min-height="80%"
        persistent
        scroll-strategy="none"
    >
        <v-card >
            <v-toolbar :title="`Checkpoints - ${props.usuario.name}`">
                <inserir-checkpoint
                    :usuario="props.usuario"
                    @close="loadCheckpoints"
                    v-if="PermissionStore.hasPermission(PermissionEnum.CRIAR_CHECKPOINT)" />
                <v-btn
                    title="Fechar"
                    icon="mdi-close"
                    @click="dialog = false"
                ></v-btn>
            </v-toolbar>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-timeline side="end" v-if="checkpoints !== null" truncate-line="end">
                            <CheckpointTimelineItem v-for="checkpoint in checkpoints" :key="checkpoint.id" :checkpoint="checkpoint" />
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
    </v-dialog>
</template>

<style scoped>

</style>
