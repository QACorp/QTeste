<script setup lang="ts">
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {defineProps} from "vue";
const props = defineProps({
    alocacao: {
        type: Object as () => AlocacaoInterface,
        required: true
    }
})
</script>

<template>
    <v-row class="px-2">
        <v-col md="12" >
            <v-btn class="p-2" size="sm" variant="tonal" stacked>
                <v-icon size="sm">mdi-pencil</v-icon>
            </v-btn>
            <v-btn class="p-2" size="sm" variant="tonal" stacked>
                <v-icon size="sm">mdi-check-circle</v-icon>
            </v-btn>
        </v-col>
    </v-row>
</template>

<style scoped>

</style>
