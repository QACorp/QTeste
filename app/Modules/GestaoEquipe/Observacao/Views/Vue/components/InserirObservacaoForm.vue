<script setup lang="ts">

import Editor from "@tinymce/tinymce-vue";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {useToast} from "vue-toast-notification";
import {ref} from "vue";
import ObservacaoInterface from "../Interfaces/Observacao.interface";
import moment from "moment/moment";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";

const props = defineProps({
  usuario: {
    type: Object as UsuarioInterface,
    required: true
  },

});
const emit = defineEmits(['close']);
const $toast = useToast();
const observacao = ref<ObservacaoInterface>({} as ObservacaoInterface);
observacao.value.user_id = props.usuario.id
observacao.value.data = new moment().format('YYYY-MM-DD');
const saveObservacao = async () => {
  LoaderStore.setShowLoader();
  await axiosApi.post(`observacao/${props.usuario.id}?idEquipe=${getIdEquipe()}`, observacao.value)
      .then(async response => {
        $toast.success('Observacao inserida com sucesso!');
        emit('close');
        observacao.value = {} as ObservacaoInterface;
        observacao.value.user_id = props.usuario.id;
        observacao.value.data = new moment().format('YYYY-MM-DD');

      })
      .catch(error => {
        $toast.error(error.response.data.message);
      });
  LoaderStore.setHideLoader();
}
</script>

<template>
  <v-form validate-on="blur" @submit.prevent="saveObservacao">
    <v-row dense>
      <v-col cols="6" sm="12" md="6">
        <v-text-field
            v-model="observacao.data"
            label="Data"
            type="date"
            size="large"
            :rules="[
                                              value => !observacao.data ? 'Informe a data' : true
                                          ]"
            required
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row dense>
      <v-col cols="12" sm="12" md="12">
        <label for="observacao">Observação</label>
        <Editor
            required
            :key="dialog"
            licenseKey="gpl"
            v-model="observacao.observacao"
        />

      </v-col>
    </v-row>
    <v-row dense>
      <v-col cols="12" sm="12" md="12">
        <v-spacer></v-spacer>
        <v-btn :disabled="!observacao.data || !observacao.observacao" type="submit" color="primary" variant="flat">Salvar</v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>

<style scoped>

</style>
