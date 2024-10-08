<script setup lang="ts">

import moment from "moment/moment";
import TFieldTarefas from "../../../../../Projetos/Views/Vue/components/TFieldTarefas.vue";
import Editor from "@tinymce/tinymce-vue";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {onMounted, ref} from "vue";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";
import {ProjetoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Projeto.interface";
import {AlocacaoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Alocacao.interface";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {useToast} from "vue-toast-notification";

const props = defineProps({
    usuario: {
        type: Object as UsuarioInterface,
        required: true
    },

});
const $toast = useToast();
const emit = defineEmits(['close']);

const checkpoint = ref<CheckpointInterface>({} as CheckpointInterface);
const projetos = ref<ProjetoInterface>([]);
const alocacoes = ref<AlocacaoInterface>([]);
const usuario = ref<UsuarioInterface>(props.usuario)


onMounted( async () => {

    //LoaderStore.setShowLoader();
    checkpoint.value = {} as CheckpointInterface;
    checkpoint.value.data = moment().format('YYYY-MM-DD');
    checkpoint.value.user_id = usuario.value.id;
    checkpoint.value.compareceu = false;
    await axiosApi.get(`checkpoint/projetos?idEquipe=${getIdEquipe()}`)
        .then(response => {
            projetos.value = response.data;
        })
        .catch(error => {
            console.log(error)
        });
    await findAlocacao(checkpoint.value.data);
    //LoaderStore.setHideLoader();


});
const updateAlocacao = () => {
    if(checkpoint.value.alocacao) {
        checkpoint.value.alocacao_id = checkpoint.value.alocacao.id;
        checkpoint.value.projeto_id = checkpoint.value.alocacao.projeto_id;
        checkpoint.value.tarefa = checkpoint.value.alocacao.tarefa;
        checkpoint.value.projeto = projetos.value.find(projeto => projeto.id == checkpoint.value.alocacao.projeto_id);
    }else {
        checkpoint.value.alocacao_id = null;
        checkpoint.value.projeto_id = null;
        checkpoint.value.tarefa = null;
        checkpoint.value.projeto = null;
    }

}


const findAlocacao = async (data: string) => {
    if(!data) return;
    //LoaderStore.setShowLoader();
    checkpoint.value.alocacao = null;
    await axiosApi.get(`checkpoint/alocacao/usuario/${usuario.value.id}/data/${data}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            alocacoes.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })

    //LoaderStore.setHideLoader();
}
const saveCheckpoint = async () => {
    //LoaderStore.setShowLoader();
    await axiosApi.post(`checkpoint/?idEquipe=${getIdEquipe()}`, checkpoint.value)
        .then(response => {
            $toast.success('Checkpoint inserido com sucesso!', {
                duration: 5000
            });

        })
        .catch(error => {
            $toast.error(error.response.data.message, {
                duration: 5000
            });
        })
    //LoaderStore.setHideLoader();
    emit('close');
}
</script>

<template>
    <v-form validate-on="blur" @submit.prevent="saveCheckpoint">
        <v-row dense>
            <v-col cols="6" sm="12" md="6">
                <v-text-field
                    v-model="checkpoint.data"
                    label="Data"
                    @blur="findAlocacao(checkpoint.data)"
                    type="date"
                    size="large"
                    :rules="[
                          value => !checkpoint.data ? 'Informe a data' : true
                      ]"
                    required
                ></v-text-field>
            </v-col>
            <v-col cols="6" sm="12" md="6">
                <v-select
                    v-model="checkpoint.alocacao"
                    @update:modelValue="updateAlocacao()"
                    :items="alocacoes"
                    no-data-text="Nenhuma alocação encontrada para esta data"
                    return-object
                    clearable
                    item-value="id"
                    label="Alocação"
                >
                    <template v-slot:item="{ props, item }">
                        <v-list-item v-bind="props" :title="`${moment(item.raw.inicio).format('DD/MM/YYYY')} - ${moment(item.raw.termino).format('DD/MM/YYYY')}`"></v-list-item>
                    </template>
                    <template v-slot:selection="{ props, item }">
                        <span class="">{{ moment(item.raw.inicio).format('DD/MM/YYYY') }} - {{ moment(item.raw.termino).format('DD/MM/YYYY')  }}</span>
                    </template>

                </v-select>
            </v-col>

        </v-row>
        <v-row dense>
            <v-col cols="10" sm="12" md="10">
                <v-select
                    v-model="checkpoint.projeto"
                    @update:modelValue="checkpoint.projeto_id = checkpoint.projeto.id"
                    :items="projetos"
                    item-title="nome"
                    no-data-text="Nenhum projeto encontrado"
                    return-object
                    clearable
                    item-value="id"
                    label="Projeto"
                    required
                ></v-select>
            </v-col>
            <v-col cols="2" sm="12" md="2">
                <TFieldTarefas v-model="checkpoint.tarefa_id" :key="checkpoint.tarefa?.tarefa" :tarefa="checkpoint.tarefa?.tarefa"/>
            </v-col>
        </v-row>
        <v-row dense>
            <v-col cols="4" sm="12" md="4">
                <v-switch
                    label="Compareceu"
                    v-model="checkpoint.compareceu"
                    :false-value="false"
                    :true-value="true"
                    color="primary"
                    inset
                ></v-switch>
            </v-col>
        </v-row>
        <v-row dense>
            <v-col cols="12" sm="12" md="12">
                <label for="descricao">Descrição</label>
                <Editor
                    required
                    licenseKey="gpl"
                    v-model="checkpoint.descricao"
                />

            </v-col>
        </v-row>
        <v-row dense>
            <v-col cols="12" sm="12" md="12">
                <v-spacer></v-spacer>
                <v-btn type="submit" color="primary" variant="flat">Salvar</v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<style scoped>

</style>
