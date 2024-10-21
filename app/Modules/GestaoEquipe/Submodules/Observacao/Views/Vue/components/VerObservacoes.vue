<script setup lang="ts">
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {ref, watch, watchEffect} from "vue";
import {getIdEquipe} from "../../../../../../../../resources/js/APIUtils/BaseAPI";
import {useToast} from "vue-toast-notification";
import {PermissionStore} from "../../../../../../../../resources/js/GlobalStore/PermissionStore";
import ObservacaoInterface from "../Interfaces/Observacao.interface";
import {PermissionEnum} from "../Enums/PermissionEnum";
import ObservacaoTimelineItem from "./ObservacaoTimelineItem.vue";
import {helperStore} from "../../../../Alocacao/Views/Vue/HelperStore";
import InserirObservacaoForm from "./InserirObservacaoForm.vue";
import {axiosApi} from "../../../../../../../../resources/js/APIUtils/AxiosBase";
const props = defineProps({
    usuario: {
        type: Object as UsuarioInterface,
        required: true
    },

});
const $toast = useToast();
const dialog = ref(false);
const observacoes = ref<ObservacaoInterface[]>([]);
const loadObservacoes = async () => {
    await axiosApi.get(`observacao/${props.usuario.id}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            observacoes.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
}

watch(helperStore.refreshObservacao,()=>{
    if(helperStore.refreshObservacao){
        loadObservacoes();
        helperStore.refreshObservacao = false;
    }
});
watchEffect(async () => {
    if(dialog.value){
        await loadObservacoes();
    }

});
</script>

<template>
    <v-btn
        class="p-2 ml-1"
        title="Ver observações"
        size="sm"
        variant="tonal"
        color="primary"
        @click="dialog = true"
        v-if="PermissionStore.hasPermission(PermissionEnum.LISTAR_OBSERVACAO) || PermissionStore.hasPermission(PermissionEnum.INSERIR_OBSERVACAO)"
    >
        <v-icon size="sm">mdi-comment-account</v-icon>
    </v-btn>
    <v-dialog
        data-bs-focus="false"
        persistent
        v-model="dialog"
        min-width="50%"
        min-height="80%"
        scroll-strategy="none"
    >
        <v-card >
            <v-toolbar :title="`Observações - ${props.usuario.name}`">
                <v-btn
                    title="Fechar"
                    icon="mdi-close"
                    @click="dialog = false"
                ></v-btn>
            </v-toolbar>
            <v-card-text>
                <v-row>
                    <v-col v-if="PermissionStore.hasPermission(PermissionEnum.LISTAR_OBSERVACAO)" :cols="PermissionStore.hasPermission(PermissionEnum.INSERIR_OBSERVACAO) ? 6 : 12">
                        <v-timeline side="end" v-if="checkpoints !== null" truncate-line="end">
                            <ObservacaoTimelineItem
                                v-for="observacao in observacoes"
                                :key="observacao.id"
                                :observacao="observacao"
                                @delete="loadObservacoes"
                                @alterar="loadObservacoes"
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
                    <v-col
                        :cols="PermissionStore.hasPermission(PermissionEnum.LISTAR_OBSERVACAO) ? 6 : 12"
                        v-if="PermissionStore.hasPermission(PermissionEnum.INSERIR_OBSERVACAO)"
                    >
                        <InserirObservacaoForm @close="loadObservacoes" :usuario="props.usuario" />
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
