<script setup lang="ts">
import {helperStore} from "../HelperStore";
import {useToast} from "vue-toast-notification";
import {ref} from "vue";
import {axiosApi} from "../../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../../resources/js/APIUtils/BaseAPI";
const $toast = useToast();
const props = defineProps({
    alocacaoId: {
        type: Number,
        required: true
    }
})
const dialog = ref<boolean>(false);
const finishAlocacao = () => {
    axiosApi.patch(`/alocacao/${props.alocacaoId}/concluir?idEquipe=${getIdEquipe()}`)
        .then(response => {
            dialog.value = false;
            helperStore.refreshAlocacao = true;
            $toast.success('Alocação concluída com sucesso!',{
                duration: 5000
            });

        })
        .catch(error => {
            $toast.error(error.response.data.message);
        })
}
</script>

<template>
    <v-btn class="p-2" size="sm" variant="tonal" @click="dialog = true">
        <v-icon size="sm">mdi-check-circle</v-icon>
    </v-btn>
    <v-dialog
        v-model="dialog"

        width="auto"
    >
        <v-card
            class="overflow-hidden"
            prepend-icon="mdi-check-circle"
            text="Tem certeza que deseja concluir esta alocação?"
            title="Concluir alocação"
        >
            <template v-slot:actions>
                <v-row class="p-0">
                    <v-col cols="12">
                        <v-btn
                            class="ms-auto"
                            text="Sim"
                            color="danger"
                            @click="finishAlocacao"
                        ></v-btn>
                        <v-btn
                            class="ms-auto"
                            text="Não"
                            color="success"
                            @click="dialog = false"
                        ></v-btn>
                    </v-col>
                </v-row>

            </template>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
