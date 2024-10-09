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
            <v-row class="mb-0 py-0" v-if="checkpoint.criador != null">
                <v-col cols="12" class="mb-0 pb-0" >
                    <span class="font-italic text-xs text-black"> Por {{ checkpoint.criador.name }}</span>
                </v-col>
            </v-row>
            <v-row v-if="checkpoint.tarefa">
                <v-col cols="4" class="mt-0 py-0">
                    <span class="font-italic text-xs text-black" :title="checkpoint.tarefa.titulo">  {{ checkpoint.tarefa.tarefa }}</span>
                </v-col>
                <v-col cols="8" class="mt-0 py-0">
                    <span class="font-italic text-xs text-black">  {{ checkpoint.tarefa.titulo }}</span>
                </v-col>
            </v-row>
            <v-row v-if="checkpoint.projeto">
                <v-col cols="12" class="mt-0 py-0" >
                    <span class="font-italic text-xs text-black" title="Projeto"> {{ checkpoint.projeto.nome }}</span>
                </v-col>
            </v-row>
            <v-row class="p-0">
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
