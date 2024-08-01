<script setup lang="ts">
import {defineProps, onMounted, ref} from "vue";

import {axiosApi} from "../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import moment from "moment";
import {NaturezaEnum} from "../Enums/Natureza.enum";

const props = defineProps({
    tokenApi: {
        type: String,
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
const alocacoes = ref<AlocacaoInterface[]>([]);

onMounted(() => {
    axiosApi.get(`gestao-equipe/alocacao?idEquipe=${getIdEquipe()}`)
        .then(response => {
            alocacoes.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })
})
</script>

<template>
    <v-row>
        <v-col v-for="alocacao in alocacoes"
               :key="alocacao.id"
               sm="3"
               md="3"
               lg="3"
               class="pa-1 ma-1"

        >
            <v-card
                :class="defineBackgroud(diffDate(alocacao.termino))"

            >
                <v-card-title>{{ alocacao.user.name }}</v-card-title>
                <v-card-subtitle>
                    <span>{{ alocacao.equipe.nome }}</span> -
                    <span :class="[alocacao.projeto_id || alocacao.natureza === NaturezaEnum.MELHORIA ? 'cursor-pointer': '']">
                {{ alocacao.natureza }}
                <v-tooltip
                    v-if="alocacao.projeto_id !== null"
                    activator="parent"
                    location="bottom"
                >{{ alocacao.projeto.nome }}</v-tooltip>
                <v-tooltip
                    v-if="alocacao.natureza === NaturezaEnum.MELHORIA"
                    activator="parent"
                    location="bottom"
                >{{ alocacao.tarefa }}</v-tooltip>
            </span>
                </v-card-subtitle>
                <v-card-text>
                    <v-tooltip
                        activator="parent"
                        location="bottom"
                    >{{ alocacao.observacao }}</v-tooltip>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Início: {{ moment(alocacao.inicio).format('DD/MM/YYYY') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>Término: {{moment(alocacao.termino).format('DD/MM/YYYY')}}</p>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<style scoped>

</style>
