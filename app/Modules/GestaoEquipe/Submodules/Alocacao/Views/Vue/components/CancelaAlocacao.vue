<script setup lang="ts">
import {helperStore} from "../HelperStore";
import {useToast} from "vue-toast-notification";
import {ref} from "vue";
import {getIdEquipe} from "../../../../../../../../resources/js/APIUtils/BaseAPI";
import {axiosApi} from "../../../../../../../../resources/js/APIUtils/AxiosBase";
import moment from "moment";
const $toast = useToast();
const props = defineProps({
    alocacaoId: {
        type: Number,
        required: true
    }
})
const dialog = ref<boolean>(false);
const motivo = ref<string>('');
const cancelAlocacao = () => {
    axiosApi.patch(`/alocacao/${props.alocacaoId}/cancelar?idEquipe=${getIdEquipe()}`,{motivo: motivo.value})
        .then(response => {
            dialog.value = false;
            helperStore.refreshAlocacao = true;
            $toast.success('Alocação cancelada com sucesso!',{
                duration: 5000
            });

        })
        .catch(error => {
            $toast.error(error.response.data.message);
        })
}
</script>

<template>
    <v-btn class="p-2" size="sm" variant="tonal" color="danger" @click="dialog = true">
        <v-icon size="sm">mdi-cancel</v-icon>
    </v-btn>
    <v-dialog
        v-model="dialog"
        width="auto"
    >
        <v-card
            class="overflow-hidden"
            prepend-icon="mdi-check-circle"
            text="Tem certeza que deseja cancelar esta alocação?"
            title="Cancelar alocação"
        >
            <v-card-text>
                <v-row class="p-0">
                    <v-col cols="12">
                        <v-textarea
                            label="Motivo"
                            v-model="motivo"
                        ></v-textarea>
                    </v-col>
                </v-row>
            </v-card-text>
            <template v-slot:actions>
                <v-row class="p-0">
                    <v-col cols="12">
                        <v-btn
                            class="ms-auto"
                            text="Sim"
                            color="danger"
                            @click="cancelAlocacao"
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
