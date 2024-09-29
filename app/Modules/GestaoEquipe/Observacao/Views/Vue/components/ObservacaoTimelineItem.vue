<script setup lang="ts">

import moment from "moment/moment";
import ObservacaoInterface from "../Interfaces/Observacao.interface";

const props = defineProps({
    observacao: {
        type: Object as ObservacaoInterface,
        required: true
    }
});
</script>

<template>
    <v-timeline-item
        dot-color="orange"
        size="small"
    >
        <template v-slot:opposite>
            <span class="font-weight-bold">{{ moment(observacao.data).format('DD/MM/YYYY') }}</span>
        </template>
        <v-alert
            variant="tonal"
            :value="true"
        >
            <v-row class="mb-0">
                <v-col cols="12" class="mb-0 pb-0" >
                    <span v-if="observacao.criador != null" class="font-italic text-xs text-black"> Por {{ observacao.criador.name }}</span>
                    <v-skeleton-loader v-else width="100" height="10"></v-skeleton-loader>
                </v-col>
            </v-row>
            <v-row class="p-0 mt-0">
                <v-col cols="12">
                    <div v-html="observacao.observacao">

                    </div>
                </v-col>
            </v-row>
        </v-alert>
    </v-timeline-item>
</template>

<style scoped>

</style>
