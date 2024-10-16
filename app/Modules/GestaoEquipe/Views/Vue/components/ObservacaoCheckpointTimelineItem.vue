<script setup lang="ts">

import moment from "moment/moment";
import CheckpointObservacaoInterface from "../Interfaces/CheckpointObservacao.interface";
import ExcluirObservacao from "../../../Submodules/Observacao/Views/Vue/components/ExcluirObservacao.vue";
import AlterarObservacao from "../../../Submodules/Observacao/Views/Vue/components/AlterarObservacao.vue";

const props = defineProps({
    observacaoCheckpoint: {
        type: Object as CheckpointObservacaoInterface,
        required: true
    }
});
const emit = defineEmits(['delete', 'alterar']);
</script>

<template>
    <v-timeline-item
        :dot-color="observacaoCheckpoint.tipo === 'Observacao' ? 'orange' : 'success'"
        size="small"
    >
        <template v-slot:opposite>
            <span class="font-weight-bold">{{ moment(observacaoCheckpoint.data).format('DD/MM/YYYY') }}</span>
        </template>
        <v-alert
            variant="tonal"
            :value="true"
        >

            <v-row class="mb-0">
                <v-col cols="12" class="mb-0 pb-0" >
                    <span v-if="observacaoCheckpoint.criador !== null" class="font-italic text-xs text-black"> Por {{ observacaoCheckpoint.criador.name }}</span>
                    <v-skeleton-loader v-else width="100" height="10"></v-skeleton-loader>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4" class="mt-0 py-0" v-if="observacaoCheckpoint.tarefa">
                    <span class="font-italic text-xs text-black"  :title="observacaoCheckpoint.tarefa.titulo">  {{ observacaoCheckpoint.tarefa.tarefa }}</span>
                </v-col>
                <v-col cols="8" class="mt-0 py-0" v-if="observacaoCheckpoint.tarefa">
                    <span class="font-italic text-xs text-black"  :title="observacaoCheckpoint.tarefa.titulo">  {{ observacaoCheckpoint.tarefa.titulo }}</span>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="mt-0 pt-0" v-if="observacaoCheckpoint.projeto">
                    <span class="font-italic text-xs text-black" title="Projeto"> {{ observacaoCheckpoint.projeto.nome }}</span>
                </v-col>
            </v-row>
            <v-row class="p-0 mt-0">
                <v-col cols="12">
                    <div v-html="observacaoCheckpoint.descricao">

                    </div>
                </v-col>
            </v-row>
            <v-row class="p-0 mt-0">
                <v-col cols="12" v-if="observacaoCheckpoint.tipo === 'Observacao'">
                    <ExcluirObservacao @close="emit('delete')" :observacao-id="observacaoCheckpoint.id"/>
                    <AlterarObservacao :observacao="observacaoCheckpoint" @close="emit('alterar')"/>
                </v-col>
            </v-row>
        </v-alert>
    </v-timeline-item>
</template>

<style scoped>

</style>
