<script setup lang="ts">
import {axiosApi} from "../../../../../../resources/js/app";
import {ref} from "vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const props = defineProps({
    tarefa:{
        type: String,
        required: false,
        default: ''
    },
    disabled:{
        type: Boolean,
        required: false,
        default: false
    }
});
const $toast = useToast();
const idTarefa = defineModel();
const dialog = ref<boolean>(false);
const titulo = ref<string>('');
const tarefa = ref<string>(props.tarefa);

const verificarTarefa = async () => {
    await axiosApi.get(`projetos/tarefa/${tarefa.value}`)
        .then(response => {
            idTarefa.value = response.data.id;
        })
        .catch(error => {
            if(error.response.status === 404){
                dialog.value = true;
            }
        })
}
const cancelar = () => {
    tarefa.value = '';
    dialog.value = false;
}
const salvarTarefa = async () => {
    if(tarefa.value !== ''){
        await axiosApi.post(`projetos/tarefa/`,{
            tarefa: tarefa.value,
            titulo: titulo.value
        })
        .then(response => {
            $toast.success('Tarefa inserida com sucesso!', {
                duration: 5000
            });
            idTarefa.value = response.data.id;
            dialog.value = false;
        })
        .catch(error => {
            $toast.error(error.response.data.message, {
                duration: 5000
            });

        })
    }

}
</script>

<template>

    <v-text-field
        type="text"
        v-model="tarefa"
        label="Tarefa"
        @blur="verificarTarefa()"
        :disabled="props.disabled"
    ></v-text-field>
    <v-dialog v-model="dialog" >
        <v-card>
            <v-card-title>
                <span class="headline">Tarefa não existe.</span>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="12" md="12">
                        <p>Tarefa ainda não existe, digite o título para criá-la.</p>
                        <v-text-field v-model="titulo" name="tarefa_id" label="Título"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="12" md="12">
                        <v-btn @click="salvarTarefa()" color="primary" class="mr-1">Salvar</v-btn>
                        <v-btn @click="cancelar()" color="danger">Cancelar</v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
