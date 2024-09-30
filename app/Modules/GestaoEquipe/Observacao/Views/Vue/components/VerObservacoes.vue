<script setup lang="ts">
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {ref, watch, watchEffect} from "vue";

import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";
import {useToast} from "vue-toast-notification";
import {PermissionStore} from "../../../../../../../resources/js/GlobalStore/PermissionStore";
import ObservacaoInterface from "../Interfaces/Observacao.interface";
import {PermissionEnum} from "../Enums/PermissionEnum";
import ObservacaoTimelineItem from "./ObservacaoTimelineItem.vue";
import Editor from "@tinymce/tinymce-vue";
import moment from "moment";
import {helperStore} from "../../../../Alocacao/Views/Vue/HelperStore";
const props = defineProps({
    usuario: {
        type: Object as UsuarioInterface,
        required: true
    },

});
const $toast = useToast();
const dialog = ref(false);
const observacoes = ref<ObservacaoInterface[]>([]);
const observacao = ref<ObservacaoInterface>({} as ObservacaoInterface);
observacao.value.user_id = props.usuario.id
observacao.value.data = new moment().format('YYYY-MM-DD');
const loadObservacoes = async () => {
    LoaderStore.showLoader = true;
    await axiosApi.get(`observacao/${props.usuario.id}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            observacoes.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    LoaderStore.showLoader = false;
}
const saveObservacao = async () => {
    LoaderStore.showLoader = true;
    await axiosApi.post(`observacao/${props.usuario.id}?idEquipe=${getIdEquipe()}`, observacao.value)
        .then(async response => {
            $toast.success('Observacao inserida com sucesso!');
            await loadObservacoes();
            observacao.value = {} as ObservacaoInterface;
            observacao.value.user_id = props.usuario.id;
            observacao.value.data = new moment().format('YYYY-MM-DD');

        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    LoaderStore.showLoader = false;
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
        class="p-2 mx-1"
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
        v-model="dialog"
        min-width="50%"
        min-height="80%"
        persistent
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
                        <v-form validate-on="blur" @submit.prevent="saveObservacao">
                            <v-row dense>
                                <v-col cols="6" sm="12" md="6">
                                    <v-text-field
                                        v-model="observacao.data"
                                        label="Data"
                                        type="date"
                                        size="large"
                                        :rules="[
                                              value => !observacao.data ? 'Informe a data' : true
                                          ]"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12" sm="12" md="12">
                                    <label for="observacao">Observação</label>
                                    <Editor
                                        required
                                        licenseKey="gpl"
                                        v-model="observacao.observacao"
                                    />

                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12" sm="12" md="12">
                                    <v-spacer></v-spacer>
                                    <v-btn :disabled="!observacao.data || !observacao.observacao" type="submit" color="primary" variant="flat">Salvar</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
