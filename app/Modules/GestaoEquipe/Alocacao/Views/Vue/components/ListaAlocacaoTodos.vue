<script setup lang="ts">
import {defineProps, onBeforeMount, onMounted, ref, watch, watchEffect} from "vue";

import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import CardAlocacao from "./CardAlocacao.vue";
import {helperStore} from "../HelperStore";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {ProjetoInterface} from "../Interfaces/Projeto.interface";
import {UsuarioInterface} from "../Interfaces/Usuario.interface";
import axios from "axios";
import {AplicacaoInterface} from "../../../../../Retrabalhos/Views/Vue/Interfaces/Aplicacao.interface";

const props = defineProps({
    editAlocacao: {
        type: Boolean,
        required: false,
        default: false
    },
    finishAlocacao: {
        type: Boolean,
        required: false,
        default: false
    }
})

const alocacoes = ref<AlocacaoInterface[]>([]);
const projetos = ref<ProjetoInterface[]>([]);
const usuarios = ref<UsuarioInterface[]>([]);
const aplicacoes = ref<AplicacaoInterface[]>([]);

const filtroUser = ref<UsuarioInterface>(null);
const filtroProjeto = ref<ProjetoInterface>(null);
const filtroInicio = ref<string>();
const filtroTermino = ref<string>();
const filtroAplicacao = ref<AplicacaoInterface>();
onBeforeMount(() => {
    helperStore.editAlocacao = props.editAlocacao;
    helperStore.finishAlocacao = props.finishAlocacao;
})
watch(filtroAplicacao, (newValue, oldValue) => {
    if(oldValue !== filtroAplicacao.value) {
        projetos.value = [];
        filtroProjeto.value = null;
        if (filtroAplicacao.value) {
            findProjetos();
        }
    }
});
onMounted(() => {
    findUsers();
    findAplicacoes();
    findAlocacoes();
    helperStore.refreshAlocacao = false;

})
const findAlocacoes = () => {
    alocacoes.value = null;
    axiosApi.get(`alocacao?idEquipe=${getIdEquipe()}${prepareParameters()}`)
        .then(response => {
            alocacoes.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })
}
const prepareParameters = ():string => {
    let parameter = '';
    if (filtroUser.value) {
        parameter += `&idUsuario=${filtroUser.value.id}`;
    }
    if (filtroAplicacao.value) {
        parameter += `&idAplicacao=${filtroAplicacao.value.id}`;
    }
    if (filtroProjeto.value) {
        parameter += `&idProjeto=${filtroProjeto.value.id}`;
    }
    if (filtroInicio.value) {
        parameter += `&dataInicio=${filtroInicio.value}`;
    }
    if (filtroTermino.value) {
        parameter += `&dataTermino=${filtroTermino.value}`;
    }
    return parameter;
}
watchEffect(() => {
    if (helperStore.refreshAlocacao) {
        alocacoes.value = null;
        findAlocacoes();
        helperStore.refreshAlocacao = false;
    }
});
const findUsers = () => {
    axiosApi.get(`user/equipe/${getIdEquipe()}`)
        .then(response => {
            usuarios.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })
}
const findAplicacoes = () => {
    axiosApi.get(`projetos/equipe/${getIdEquipe()}/aplicacao`)
        .then(response => {
            aplicacoes.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })
}
const findProjetos = () => {
    axiosApi.get(`projetos/equipe/${getIdEquipe()}/aplicacao/${filtroAplicacao.value.id}`)
        .then(response => {
            projetos.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })
}
</script>

<template>
    <v-row>
        <v-col cols="2" md="2" sm="12">
            <v-combobox
                v-model="filtroUser"
                :items="usuarios"
                return-object
                no-data-text="Nenhum usuário na equipe"
                clearable
                item-title="name"
                item-value="id"
                label="Usuário"
                required
            ></v-combobox>
        </v-col>
        <v-col cols="2" md="2" sm="12">
            <v-select
                v-model="filtroAplicacao"
                :items="aplicacoes"
                item-title="nome"
                return-object
                clearable
                @on-click:clear="() => {filtroProjeto = null; projetos = []}"
                no-data-text="Nenhuma aplicação na equipe"
                item-value="id"
                label="Aplicação"
                required
            ></v-select>
        </v-col>
        <v-col cols="3" md="3" sm="12">
            <v-combobox
                v-model="filtroProjeto"
                :items="projetos"
                item-title="nome"
                clearable
                return-object
                :disabled="!projetos.length"
                no-data-text="Nenhum projeto para esta aplicação"
                item-value="id"
                label="Projeto"
                required
            ></v-combobox>
        </v-col>
        <v-col cols="2" md="2" sm="12">
            <v-text-field clearable type="date" v-model="filtroInicio" label="Data Inicio"></v-text-field>
        </v-col>
        <v-col cols="2" md="2" sm="12">
            <v-text-field clearable type="date" v-model="filtroTermino" label="Data término"></v-text-field>
        </v-col>
        <v-col cols="1" md="1" sm="12">
            <v-btn
                @click="findAlocacoes()"
                density="default"
                variant="tonal"
                color="primary"
                icon="mdi-find-replace"
            ></v-btn>
        </v-col>
    </v-row>
    <v-row>
        <v-col md="3" v-if="!alocacoes">
            <v-skeleton-loader type="card"></v-skeleton-loader>
        </v-col>
        <v-col md="3" v-if="!alocacoes">
            <v-skeleton-loader type="card"></v-skeleton-loader>
        </v-col>

        <v-col v-if="alocacoes" v-for="alocacao in alocacoes"
               :key="alocacao.id"
               cols="12"
               sm="3"
               md="3"
               lg="3"

        >
           <CardAlocacao :alocacao="alocacao as AlocacaoInterface" />
        </v-col>
    </v-row>
</template>

<style scoped>

</style>
