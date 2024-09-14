<script setup lang="ts">

import moment from "moment/moment";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";

const props = defineProps({
    checkpoint: {
        type: Object as CheckpointInterface,
        required: true
    }
});
</script>

<template>
    <v-timeline-item
        dot-color="primary"
        size="small"
    >
        <template v-slot:opposite>
            <span class="font-weight-bold">{{ moment(checkpoint.data).format('DD/MM/YYYY') }}</span>
        </template>
        <v-alert
            variant="tonal"
            :value="true"
        >
            <v-row class="mb-0">
                <v-col cols="12" class="mb-0 pb-0" >
                    <span v-if="checkpoint.criador != null" class="font-italic text-xs text-black"> Por {{ checkpoint.criador.name }}</span>
                    <v-skeleton-loader v-else width="100" height="10"></v-skeleton-loader>
                </v-col>

                <v-col cols="2" class="mt-0" v-if="checkpoint.tarefa">
                    <span class="font-italic text-xs text-black" title="Tarefa">  {{ checkpoint.tarefa }}</span>
                </v-col>
                <v-col cols="10" class="mt-0" v-if="checkpoint.projeto">
                    <span class="font-italic text-xs text-black" title="Projeto"> {{ checkpoint.projeto.nome }}</span>
                </v-col>
            </v-row>
            <v-row class="p-0 mt-0">
                <v-col cols="12">
                    <div v-html="checkpoint.descricao">

                    </div>
                </v-col>
            </v-row>
        </v-alert>
    </v-timeline-item>
</template>

<style scoped>

</style>
