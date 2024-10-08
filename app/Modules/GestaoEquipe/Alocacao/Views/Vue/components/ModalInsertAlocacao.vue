<script setup lang="ts">
import {ref, watch} from "vue";
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {NaturezaEnum} from "../Enums/Natureza.enum";
import {ProjetoInterface} from "../Interfaces/Projeto.interface";
import Editor from '@tinymce/tinymce-vue'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import {helperStore} from "../HelperStore";
import moment from "moment";
import {SubmitEventPromise} from "vuetify";
import {UsuarioInterface} from "../../../../../Retrabalhos/Views/Vue/Interfaces/Usuario.interface";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import TFieldTarefas from "../../../../../Projetos/Views/Vue/components/TFieldTarefas.vue";


const dialog = ref<boolean>(false);
const alocacao = ref<AlocacaoInterface>({} as AlocacaoInterface);
const usuarios = ref<UsuarioInterface[]>(null);
const projetos = ref<ProjetoInterface[]>(null);
const $toast = useToast();
const form = ref<any>(null);
const findUsers = () => {
    alocacao.value.user = null;
    alocacao.value.user_id = null;
    usuarios.value = null;
    //LoaderStore.setShowLoader();
    axiosApi.get(`alocacao/usuarios-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            usuarios.value = response.data;
            //LoaderStore.setHideLoader();
        })
        .catch(error => {
            console.log(error)
        })
}
watch(dialog, (newValue) => {
    if(dialog){
        alocacao.value = {} as AlocacaoInterface;
    }
});

const saveAlocacao = async (submitEventPromise: SubmitEventPromise) => {
    const {valid, errors} = await submitEventPromise;
    if (!valid) return;
    alocacao.value.equipe_id = parseInt(getIdEquipe());
    //LoaderStore.setShowLoader();
    axiosApi.post(`alocacao`, alocacao.value)
        .then(response => {
            //LoaderStore.setHideLoader();
            $toast.success('Alocação inserida com sucesso!', {
                duration: 5000
            });
            helperStore.refreshAlocacao = true;
            alocacao.value = {} as AlocacaoInterface;
            usuarios.value = null;
            dialog.value = false;
        })
        .catch(error => {
            $toast.error(error.response.data.message, {
                duration: 5000
            });
        })
}

const findProjetos = () => {
    //LoaderStore.setShowLoader();
    axiosApi.get(`alocacao/projetos-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            projetos.value = response.data;
            //LoaderStore.setHideLoader();
        })
        .catch(error => {
            console.log(error)
        })
}
</script>

<template>

    <v-btn class="p-2" size="sm" color="primary"  @click="dialog = true" >
        <v-icon size="sm">mdi-plus</v-icon>
        Inserir alocação
    </v-btn>
    <v-dialog
        data-bs-focus="false"
        v-model="dialog"
        min-width="50%"
        persistent
        scroll-strategy="none"
    >
        <v-card >
            <v-toolbar title="Inserir alocação">
                <v-btn
                    icon="mdi-close"
                    @click="dialog = false"
                ></v-btn>
            </v-toolbar>
            <v-card-text>
                <v-form ref="form" validate-on="blur" @submit.prevent="saveAlocacao">
                    <v-row dense>
                        <v-col cols="12" sm="5" md="5">
                            <v-text-field
                                type="date"
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
                                :rules="[
                                    value => alocacao.inicio && moment(alocacao.inicio).isAfter(alocacao.termino) ? 'A data de término deve ser maior que a data de início' : true,
                                    value => !alocacao.termino ? 'Selecione a data de término' : true
                                    ]"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="2" md="2">
                            <v-btn @click="findUsers()" size="x-large" variant="tonal" class="py-3">
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
                                item-title="name"
                                item-value="id"
                                label="Usuário"
                                required
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="3" md="3" v-if="usuarios">
                            <TFieldTarefas v-model="alocacao.tarefa_id" label="Tarefa" size="large" required/>
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
                            ></v-select>
                        </v-col>

                    </v-row>
                    <v-row dense>
                        <v-col cols="12" sm="12" md="12" v-if="usuarios">
                            <label for="observacao">Observação</label>
                            <Editor
                                licenseKey="gpl"
                                v-model="alocacao.observacao"
                            />

                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col cols="12" sm="12" md="12" v-if="usuarios">
                            <v-spacer></v-spacer>
                            <v-btn type="submit" color="primary" variant="flat">Salvar</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
