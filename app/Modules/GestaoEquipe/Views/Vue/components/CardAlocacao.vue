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
const diffDate = (data: string): number =>
{
    return moment(data).diff(moment(), 'weeks');
}

const defineBackgroud = (weeks: number)=>{
    if(weeks <= 1){
        return 'bg-danger';
    }else if(weeks <= 2) {
        return 'bg-warning';
    }else {
        return 'bg-success';
    }
}
</script>

<template>
    <v-card
        :class="defineBackgroud(diffDate(alocacao.termino))"

    >
        <v-card-title>
            <v-row>
                <v-col md="12">{{ alocacao.user.name }}</v-col>
            </v-row>
        </v-card-title>
        <v-card-subtitle>
            <span>{{ alocacao.equipe.nome }}</span> -
            <span :class="[alocacao.projeto_id || alocacao.natureza === NaturezaEnum.MELHORIA ? 'cursor-pointer': '']">
                        {{ alocacao.natureza }}
                        <UseClipboard
                            v-slot="{ copy, copied }"
                            :source="alocacao.tarefa"
                            v-if="alocacao.tarefa !== null">
                               [<span @click="copy()">
                                    <span v-if="!copied">{{ alocacao.tarefa }}</span>
                                    <span v-else>Copiado!</span>
                                    <v-icon size="sm">mdi-content-copy</v-icon>
                                </span>]
                        </UseClipboard>
                        <v-tooltip
                            v-if="alocacao.projeto_id !== null"
                            activator="parent"
                            location="bottom"
                        >{{ alocacao.projeto.nome }}</v-tooltip>

                    </span>
        </v-card-subtitle>
        <v-card-text class="py-0 pt-1">
            <v-tooltip
                activator="parent"
                location="bottom"
            >{{ alocacao.observacao }}</v-tooltip>
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
