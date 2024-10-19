<script setup lang="ts">

import {NaturezaEnum} from "../Enums/Natureza.enum";
import moment from "moment/moment";
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {UseClipboard} from "@vueuse/components";
import {defineProps} from "vue";
import ActionButtonsAlocacao from "./ActionButtonsAlocacao.vue";
const props = defineProps({
    alocacao: {
        type: Object as () => AlocacaoInterface,
        required: true
    }
})
const emit = defineEmits(['showMessage']);
const diffDate = (data: string): number =>
{
    return moment(data).diff(moment(), 'days');
}

const defineBackgroud = (days: number)=>{
    if(days <= 5){
        return 'bg-danger';
    }else if(days <= 14) {
        return 'bg-warning';
    }else {
        return 'bg-success';
    }
}
const isAusencia = (alocacao: AlocacaoInterface):boolean => {
    return alocacao.natureza === NaturezaEnum.AFASTAMENTO ||
        alocacao.natureza === NaturezaEnum.LICENCA ||
        alocacao.natureza === NaturezaEnum.FERIAS;

}
const getUrlProjeto = () => {
    return `${import.meta.env.VITE_APP_URL}/projetos/aplicacoes/${props.alocacao.projeto.aplicacao_id}/projetos/${props.alocacao.projeto_id}/editar`;
}
</script>

<template>
    <v-card color="light">
        <v-card-title>
            <v-row>
                <v-col md="12">
                    <span :title="alocacao.user.name" class="mr-3">
                        {{ alocacao.user.name }}
                    </span>
                    <v-chip class="mr-3" title="Equipe">{{ alocacao.equipe.nome }}</v-chip>
                    <v-chip class="mr-3" title="Natureza" :color="isAusencia(alocacao) ? 'primary' : 'purple'">
                        <a class="text-decoration-none" target="_blank" v-if="alocacao.natureza === NaturezaEnum.PROJETO" :href="getUrlProjeto()">{{ alocacao.natureza }}<v-icon size="sm">mdi-open-in-new</v-icon></a>
                        <span v-else>{{ alocacao.natureza }}</span>
                    </v-chip>
                    <v-chip class="mr-3" density="compact" size="x-small" :class="[isAusencia(alocacao) ? 'bg-primary' : defineBackgroud(diffDate(alocacao.termino))]"></v-chip>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="">
            <v-row class="pb-0 mb-0">
                <v-col cols="12" md="3" v-if="alocacao.tarefa">
                    <span class="font-weight-bold">Tarefa: </span>
                    <span :class="[alocacao.projeto_id || alocacao.natureza === NaturezaEnum.MELHORIA ? 'cursor-pointer': '']">
                        <UseClipboard
                            v-slot="{ copy, copied }"
                            :source="alocacao.tarefa.tarefa"
                            v-if="alocacao.tarefa !== null">
                            <span @click="copy()" class="cursor-pointer">
                                 <v-tooltip
                                     v-if="alocacao.tarefa_id !== null"
                                     activator="parent"
                                     location="bottom"
                                 >
                                    <span>{{ alocacao.tarefa.titulo }}</span>
                                </v-tooltip>
                                <span v-if="!copied">{{ alocacao.tarefa.tarefa }} </span>
                                <span v-else>Copiado!</span>
                                <v-icon size="sm">mdi-content-copy</v-icon>
                            </span>
                        </UseClipboard>
                        <v-tooltip
                            v-if="alocacao.projeto_id !== null"
                            activator="parent"
                            location="bottom"
                        ><span v-html="alocacao.projeto.nome"></span> </v-tooltip>
                    </span>
                </v-col>
                <v-col cols="12" md="9" v-if="alocacao.projeto">
                    <UseClipboard
                        v-slot="{ copy, copied }"
                        :source="alocacao.projeto.nome">
                        <span class="font-weight-bold">Projeto: </span>
                        <span @click="copy()" v-if="alocacao.projeto_id !== null" class="cursor-pointer">
                            <span v-if="!copied">{{ alocacao.projeto.nome }} </span>
                            <span v-else>Copiado!</span>
                            <v-icon size="sm">mdi-content-copy</v-icon>
                        </span>
                    </UseClipboard>
                </v-col>
            </v-row>
            <v-row class="mt-0 pt-0">
                <v-col cols="12" md="12">
                    <v-tooltip
                        activator="parent"
                        location="bottom"
                    >
                        <span v-html="alocacao.observacao "></span>
                    </v-tooltip>
                    <div class="row">
                        <div class="col-md-2">
                            <span class="font-weight-bold">Início:</span> <span>{{ moment(alocacao.inicio).format('DD/MM/YYYY') }}</span>
                        </div>
                        <div class="col-md-2">
                            <span class="font-weight-bold">Término:</span> <span>{{moment(alocacao.termino).format('DD/MM/YYYY')}}</span>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions class="py-0 pt-1">
            <ActionButtonsAlocacao :alocacao="alocacao"></ActionButtonsAlocacao>
        </v-card-actions>
    </v-card>
</template>

<style scoped>

</style>
