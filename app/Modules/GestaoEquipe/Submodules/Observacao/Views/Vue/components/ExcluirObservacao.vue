<script setup lang="ts">
import {useToast} from "vue-toast-notification";
import {ref} from "vue";
import {axiosApi} from "../../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../../resources/js/APIUtils/BaseAPI";
import {LoaderStore} from "../../../../../../../../resources/js/GlobalStore/LoaderStore";
import {helperStore} from "../../../../Alocacao/Views/Vue/HelperStore";
const $toast = useToast();
const props = defineProps({
    observacaoId: {
        type: Number,
        required: true
    }
})
const emit = defineEmits(['close']);
const dialog = ref<boolean>(false);
const deleteObservacao = () => {
    LoaderStore.setShowLoader();
    axiosApi.delete(`/observacao/${props.observacaoId}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            dialog.value = false;
            $toast.success('Observacao removida com sucesso!',{
                duration: 5000
            });
            LoaderStore.setHideLoader();
            helperStore.refreshObservacao = true;
            emit('close');
        })
        .catch(error => {
            dialog.value = false;
            LoaderStore.setHideLoader();
            $toast.error(error.response.data.message);
        })
}
</script>

<template>
    <v-btn class="p-2 mx-1" size="sm" variant="tonal" color="danger" @click="dialog = true" title="Excluir observação">
        <v-icon size="sm">mdi-delete</v-icon>
    </v-btn>
    <v-dialog
        v-model="dialog"
        @close="emit('close')"
        width="auto"
    >
        <v-card
            class="overflow-hidden"
            prepend-icon="mdi-check-circle"
            text="Tem certeza que deseja excluir esta observação?"
            title="Excluir observacao"
        >
            <template v-slot:actions>
                <v-row class="p-0">
                    <v-col cols="12">
                        <v-btn
                            class="ms-auto"
                            text="Sim"
                            color="danger"
                            @click="deleteObservacao"
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
