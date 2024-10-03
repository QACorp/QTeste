<script setup lang="ts">
import {useToast} from "vue-toast-notification";
import {ref, watch} from "vue";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";
import {helperStore} from "../../../../Alocacao/Views/Vue/HelperStore";
import Editor from "@tinymce/tinymce-vue";
const $toast = useToast();
const props = defineProps({
    observacao: {
        type: Object as ObservacaoInterface,
        required: true
    }
})
const emit = defineEmits(['close']);
const dialog = ref<boolean>(false);
const observacao = ref<ObservacaoInterface>(props.observacao);
observacao.value.observacao = props.observacao.descricao ?? props.observacao.observacao;
const alterarObservacao = () => {
    LoaderStore.setShowLoader();
    axiosApi.patch(`/observacao/${props.observacao.id}?idEquipe=${getIdEquipe()}`, observacao.value)
        .then(response => {
            dialog.value = false;
            $toast.success('Observacao alterada com sucesso!',{
                duration: 5000
            });
            LoaderStore.setHideLoader();
            helperStore.refreshObservacao = true;
            emit('close');
        })
        .catch(error => {
            LoaderStore.setHideLoader();
            $toast.error(error.response.data.message);
        })
}
watch(dialog, () => {
    if(dialog.value){
        observacao.value = props.observacao;
    }
});
</script>

<template>
    <v-btn class="p-2 mx-1" size="sm" variant="tonal" color="danger" @click="dialog = true" title="Alterar observação">
        <v-icon size="sm">mdi-tooltip-edit</v-icon>
    </v-btn>
    <v-dialog
        v-model="dialog"
        @close="emit('close')"
        width="auto"
        data-bs-focus="false"
        persistent
    >
        <v-card
            prepend-icon="mdi-tooltip-edit"
            title="Alterar observação"
        >
            <v-card-text>
                <v-row dense>
                    <v-col cols="12" sm="12" md="12">
                        <label for="observacao">Observação</label>
                        <Editor
                            required
                            licenseKey="gpl"
                            v-model="observacao.observacao"
                        />

                    </v-col>
                </v-row>
                <v-row class="p-0">
                    <v-col cols="12">
                        <v-btn
                            class="mx-1"
                            text="Salvar"
                            color="success"
                            @click="alterarObservacao"
                        ></v-btn>
                        <v-btn
                            class="mx-1"
                            text="Cancelar"
                            color="danger"
                            @click="dialog = false"
                        ></v-btn>
                    </v-col>
                </v-row>
            </v-card-text>

        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
