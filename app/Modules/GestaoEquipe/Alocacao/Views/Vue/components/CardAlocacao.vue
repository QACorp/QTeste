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
    <v-card
        :class="isAusencia(alocacao) ? 'bg-primary' : defineBackgroud(diffDate(alocacao.termino))"

    >
        <v-card-title>

            <v-row>
                <v-col md="12"><span :title="alocacao.user.name">{{ alocacao.user.name }}</span></v-col>
            </v-row>
        </v-card-title>
        <v-card-subtitle>
            <span >{{ alocacao.equipe.nome }}</span> -
            <span :class="[alocacao.projeto_id || alocacao.natureza === NaturezaEnum.MELHORIA ? 'cursor-pointer': '']">
                        <a class="text-light text-decoration-none" target="_blank" v-if="alocacao.natureza === NaturezaEnum.PROJETO" :href="getUrlProjeto()">{{ alocacao.natureza }}<v-icon size="sm">mdi-open-in-new</v-icon></a>
                        <span v-else>{{ alocacao.natureza }}</span>
                        <UseClipboard
                            v-slot="{ copy, copied }"
                            :source="alocacao.tarefa.tarefa"
                            v-if="alocacao.tarefa !== null">

                               [<span @click="copy()" class="cursor-pointer">
                                     <v-tooltip
                                         v-if="alocacao.tarefa_id !== null"
                                         activator="parent"
                                         location="bottom"
                                     >
                                        <span>{{ alocacao.tarefa.titulo }}</span>
                                    </v-tooltip>
                                    <span v-if="!copied">{{ alocacao.tarefa.tarefa }}</span>
                                    <span v-else>Copiado!</span>
                                    <v-icon size="sm">mdi-content-copy</v-icon>
                                </span>]

                        </UseClipboard>
                        <v-tooltip
                            v-if="alocacao.projeto_id !== null"
                            activator="parent"
                            location="bottom"
                        ><span v-html="alocacao.projeto.nome"></span> </v-tooltip>

                    </span>
        </v-card-subtitle>
        <v-card-text class="py-0 pt-1">
            <v-tooltip
                activator="parent"
                location="bottom"
            ><span v-html="alocacao.observacao "></span> </v-tooltip>
            <div class="row">
                <div class="col-md-6">
                    <span>Início: {{ moment(alocacao.inicio).format('DD/MM/YYYY') }}</span>
                </div>
                <div class="col-md-6">
                    <span>Término: {{moment(alocacao.termino).format('DD/MM/YYYY')}}</span>
                </div>
            </div>
        </v-card-text>
        <v-card-actions class="py-0 pt-1">
            <ActionButtonsAlocacao :alocacao="alocacao"></ActionButtonsAlocacao>
        </v-card-actions>
    </v-card>
</template>

<style scoped>

</style>
