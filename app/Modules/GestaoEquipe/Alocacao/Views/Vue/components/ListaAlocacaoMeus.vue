<script setup lang="ts">
import {defineProps, onBeforeMount, onMounted, ref, watch, watchEffect} from "vue";

import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import CardAlocacao from "./CardAlocacao.vue";
import {helperStore} from "../HelperStore";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {axiosApi} from "../../../../../../../resources/js/app";

const alocacoes = ref<AlocacaoInterface[]>(null);

onBeforeMount(() => {
    helperStore.editAlocacao = false;
    helperStore.finishAlocacao = false;
})
onMounted(() => {
    findAlocacoes();
    helperStore.refreshAlocacao = false;

})
const findAlocacoes = () => {
    axiosApi.get(`alocacao/minha?idEquipe=${getIdEquipe()}`)
        .then(response => {
            alocacoes.value = response.data;
        })
        .catch(error => {
            console.log(error)
        })
}
watchEffect(() => {
    if (helperStore.refreshAlocacao) {
        alocacoes.value = null;
        findAlocacoes();
        helperStore.refreshAlocacao = false;
    }
})
</script>

<template>

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
