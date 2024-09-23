<script setup lang="ts">
import {defineProps, ref, watch, onMounted} from "vue";
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {NaturezaEnum} from "../Enums/Natureza.enum";
import {ProjetoInterface} from "../Interfaces/Projeto.interface";
import Editor from '@tinymce/tinymce-vue'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import {helperStore} from "../HelperStore";
import moment from "moment";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {axiosApi} from "../../../../../../../resources/js/app";
import {UsuarioInterface} from "../../../../../Retrabalhos/Views/Vue/Interfaces/Usuario.interface";
import CheckpointInterface from "../../../../Checkpoint/Views/Vue/Interfaces/Checkpoint.interface";
import CheckpointTimelineItem from "../../../../Checkpoint/Views/Vue/components/CheckpointTimelineItem.vue";
import TFieldTarefas from "../../../../../Projetos/Views/Vue/components/TFieldTarefas.vue";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";

const props = defineProps({
    alocacaoId: {
        type: Number,
        required: true
    },
    canEdit: {
        type: Boolean,
        required: true
    }
})

const dialog = ref<boolean>(false);
const alocacao = ref<AlocacaoInterface>({} as AlocacaoInterface);
const usuarios = ref<UsuarioInterface[]>(null);
const projetos = ref<ProjetoInterface[]>(null);
const checkpoints = ref<CheckpointInterface[]>(null)
const $toast = useToast();
watch(dialog, async (newValue) => {
    if(dialog){
        LoaderStore.showLoader = true;
        await axiosApi.get(`alocacao/${props.alocacaoId}?idEquipe=${getIdEquipe()}`)
            .then(async response => {
                LoaderStore.showLoader = false;
                alocacao.value = response.data;
                if(
                    alocacao.value.natureza === NaturezaEnum.PROJETO &&
                    alocacao.value.inicio &&
                    alocacao.value.termino){
                    await findProjetos();
                }
                await findUsers();
            })
            .catch(error => {
                $toast.error(error.response.data.message);
            });
        await findCheckpoints();


    }
});

const findUsers = async () => {
    LoaderStore.showLoader = true;
    axiosApi.get(`alocacao/usuarios-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            usuarios.value = response.data;
            usuarios.value.push(alocacao.value.user as UsuarioInterface);

        })
        .catch(error => {
            console.log(error)
        })
    LoaderStore.showLoader = false;
}

const saveAlocacao = async () => {
    LoaderStore.showLoader = true;
    await axiosApi.put(`alocacao/${props.alocacaoId}`, alocacao.value)
        .then(response => {
            $toast.success('Alocação alterada com sucesso!',{
                duration: 5000
            });
            helperStore.refreshAlocacao = true;
            dialog.value = false;

        })
        .catch(error => {

            $toast.error(error.response.data.message);
        })
    LoaderStore.showLoader = false;
}

const findProjetos = async () => {
    LoaderStore.showLoader = true;
    await axiosApi.get(`alocacao/projetos-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            projetos.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    LoaderStore.showLoader = false;
}
const findCheckpoints = async () => {
    //LoaderStore.showLoader = true;
    await axiosApi.get(`checkpoint/alocacao/${props.alocacaoId}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            checkpoints.value = response.data;
            //LoaderStore.showLoader = false;
        })
        .catch(error => {
            //LoaderStore.showLoader = false;
            $toast.error(error.response.data.message);
        })
}
</script>

<template>
    <v-btn
        class="p-2"
        size="sm"
        variant="tonal"
        @click="dialog = true"
    >
        <v-icon size="sm">mdi-pencil</v-icon>
    </v-btn>
    <v-dialog
        data-bs-focus="false"
        v-model="dialog"
        min-width="50%"
        max-height="90dvh"
        persistent
        scroll-strategy="block"
    >
        <v-card >
            <v-toolbar title="Alterar alocação">
                <v-btn
                    icon="mdi-close"
                    @click="dialog = false"
                ></v-btn>
            </v-toolbar>
            <v-card-text>
                <v-row class="h-screen">
                    <v-col cols="6" md="6" sm="12" class="h-screen overflow-auto">
                        <h3>Checkpoints</h3>
                        <v-timeline side="end" v-if="checkpoints !== null" truncate-line="end">
                            <CheckpointTimelineItem v-for="checkpoint in checkpoints" :key="checkpoint.id" :checkpoint="checkpoint" />
                            <v-timeline-item
                                dot-color="success"
                                size="small"
                            >
                                <template v-slot:opposite>
                                    <span class="font-weight-bold">{{ moment(alocacao.inicio).format('DD/MM/YYYY') }}</span>
                                </template>
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
                    <v-col cols="6" md="6" sm="12">
                        <v-form ref="form" validate-on="blur" @submit.prevent="saveAlocacao">
                            <v-row dense>
                                <v-col cols="12" sm="5" md="5">
                                    <v-text-field
                                        type="date"
                                        :disabled="!props.canEdit"
                                        v-model="alocacao.inicio"
                                        label="Início"
                                        size="large"
                                        :rules="[
                                        value => alocacao.termino && moment(alocacao.termino).isBefore(alocacao.inicio) ? 'A data de término deve ser maior que a data de início' : true,
                                        value => !alocacao.inicio ? 'Selecione a data de início' : true
                                     ]"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="5" md="5">
                                    <v-text-field
                                        type="date"
                                        v-model="alocacao.termino"
                                        label="Término"
                                        size="large"
                                        :disabled="!props.canEdit"
                                        :rules="[
                                    value => alocacao.inicio && moment(alocacao.inicio).isAfter(alocacao.termino) ? 'A data de término deve ser maior que a data de início' : true,
                                    value => !alocacao.termino ? 'Selecione a data de término' : true
                                    ]"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="2" md="2">
                                    <v-btn @click="findUsers()" :disabled="!props.canEdit" size="x-large" variant="tonal" class="py-3">
                                        <v-icon >mdi-account-search</v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12" sm="3" md="3" v-if="usuarios">
                                    <v-select
                                        v-model="alocacao.user"
                                        @update:modelValue="() => {alocacao.user_id = alocacao.user.id}"
                                        :items="usuarios"
                                        :rules="[value => !alocacao.user ?  'Selecione um usuário' : true]"
                                        return-object
                                        :disabled="!props.canEdit"
                                        item-title="name"
                                        item-value="id"
                                        label="Usuário"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="3" md="3" v-if="usuarios">
                                    <TFieldTarefas v-model="alocacao.tarefa_id" :tarefa="alocacao.tarefa?.tarefa" :disabled="!props.canEdit" label="Tarefa" size="large"/>
                                </v-col>
                                <v-col cols="12" sm="3" md="3" v-if="usuarios">
                                    <v-select
                                        @update:menu="() => {alocacao.natureza === NaturezaEnum.PROJETO ? findProjetos(): '';}"
                                        v-model="alocacao.natureza"
                                        :rules="[value => !alocacao.natureza ?  'Selecione a natureza da alocação' : true]"
                                        :items="[
                                                    NaturezaEnum.SUSTENTACAO,
                                                    NaturezaEnum.MELHORIA,
                                                    NaturezaEnum.PROJETO,
                                                    NaturezaEnum.FERIAS,
                                                    NaturezaEnum.LICENCA,
                                                    NaturezaEnum.AFASTAMENTO
                                                ]"
                                        label="Natureza da alocação"
                                        required
                                        :disabled="!props.canEdit"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="3" md="3" v-if="alocacao.natureza === NaturezaEnum.PROJETO && projetos">
                                    <v-select
                                        v-model="alocacao.projeto"
                                        @update:modelValue="alocacao.projeto_id = alocacao.projeto.id"
                                        :items="projetos"
                                        :rules="[value => !alocacao.projeto && alocacao.natureza === NaturezaEnum.PROJETO ?  'Selecione um projeto' : true]"
                                        item-title="nome"
                                        return-object
                                        item-value="id"
                                        label="Projeto"
                                        required
                                        :disabled="!props.canEdit"
                                    ></v-select>
                                </v-col>

                            </v-row>
                            <v-row dense>
                                <v-col cols="12" sm="12" md="12" v-if="usuarios">
                                    <label for="observacao">Observação</label>
                                    <Editor
                                        :disabled="!props.canEdit"
                                        licenseKey="gpl"
                                        v-model="alocacao.observacao"
                                    />

                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="12" sm="12" md="12" v-if="usuarios">
                                    <v-spacer></v-spacer>
                                    <v-btn :disabled="!props.canEdit" type="submit" color="primary" variant="flat">Salvar</v-btn>
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
