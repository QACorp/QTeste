<script setup lang="ts">
import {defineProps, ref, watch, onMounted} from "vue";
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {axiosApi} from "../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {UsuarioInterface} from "../../../../Retrabalhos/Views/Vue/Interfaces/Usuario.interface";
import {NaturezaEnum} from "../Enums/Natureza.enum";
import {ProjetoInterface} from "../Interfaces/Projeto.interface";
import Editor from '@tinymce/tinymce-vue'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import {helperStore} from "../HelperStore";

const props = defineProps({
    alocacaoId: {
        type: Number,
        required: true
    }
})

const dialog = ref<boolean>(false);
const alocacao = ref<AlocacaoInterface>({} as AlocacaoInterface);
const usuarios = ref<UsuarioInterface[]>(null);
const projetos = ref<ProjetoInterface[]>(null);
onMounted(() => {


});
const $toast = useToast();
watch(dialog, (newValue) => {
    if(dialog){
        axiosApi.get(`gestao-equipe/alocacao/${props.alocacaoId}?idEquipe=${getIdEquipe()}`)
            .then(response => {
                alocacao.value = response.data;

                if(
                    alocacao.value.natureza === NaturezaEnum.PROJETO &&
                    alocacao.value.inicio &&
                    alocacao.value.termino){
                    findProjetos();
                }
                findUsers();
            })
            .catch(error => {
                console.log(error)
            })

    }
});

const findUsers = () => {
    axiosApi.get(`gestao-equipe/alocacao/usuarios-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            usuarios.value = response.data;
            usuarios.value.push(alocacao.value.user as UsuarioInterface);
        })
        .catch(error => {
            console.log(error)
        })
}

const saveAlocacao = () => {
    axiosApi.put(`gestao-equipe/alocacao/${props.alocacaoId}`, alocacao.value)
        .then(response => {
            $toast.success('Alocação alterada com sucesso!',{
                duration: 5000
            });
            helperStore.refreshAlocacao = true;
            dialog.value = false;
        })
        .catch(error => {
            $toast.error(error);
        })
}

const findProjetos = () => {
    axiosApi.get(`gestao-equipe/alocacao/projetos-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            projetos.value = response.data;
            //projetos.value.push(alocacao.value.projeto as ProjetoInterface);
        })
        .catch(error => {
            console.log(error)
        })
}
</script>

<template>
    <v-btn class="p-2" size="sm" variant="tonal"  @click="dialog = true" stacked>
        <v-icon size="sm">mdi-pencil</v-icon>
    </v-btn>
    <v-dialog
        data-bs-focus="false"
        v-model="dialog"
        min-width="50%"
        persistent
        scroll-strategy="none"
    >
        <v-card >
            <v-toolbar title="Alterar alocação">
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
                            <v-text-field
                                type="text"
                                v-model="alocacao.tarefa"
                                label="Tarefa"
                                size="large"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="3" md="3" v-if="usuarios">
                            <v-select
                                @update:menu="() => {alocacao.natureza === NaturezaEnum.PROJETO ? findProjetos(): '';}"
                                v-model="alocacao.natureza"
                                :rules="[value => !alocacao.natureza ?  'Selecione a natureza da alocação' : true]"
                                :items="[
                                    NaturezaEnum.SUSTENTACAO,
                                    NaturezaEnum.MELHORIA,
                                    NaturezaEnum.PROJETO
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
