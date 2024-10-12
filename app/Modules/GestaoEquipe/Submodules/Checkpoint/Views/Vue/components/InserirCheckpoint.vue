<script setup lang="ts">
import {ref, watch} from "vue";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";
import {axiosApi} from "../../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../../resources/js/APIUtils/BaseAPI";
import {useToast} from "vue-toast-notification";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import CheckpointTimelineItem from "./CheckpointTimelineItem.vue";
import InserirCheckpointForm from "./InserirCheckpointForm.vue";

const $toast = useToast();
const emit = defineEmits(['close']);
const dialog = ref(false);
const lastCheckPoint = ref<CheckpointInterface>({} as CheckpointInterface);

const props = defineProps({
  usuario: {
    type: Object as UsuarioInterface,
    required: true
  },

});
watch(dialog, async () => {

    if(dialog.value){
        //LoaderStore.setShowLoader();
        axiosApi.get(`checkpoint/ultimo/${props.usuario.id}?idEquipe=${getIdEquipe()}`)
            .then(response => {
                lastCheckPoint.value = response.data;
            });
        //LoaderStore.setHideLoader();

    }
});

const close = () => {
    dialog.value = false;
}

</script>

<template>

  <v-btn
      class="p-2 mx-2"
      size="sm"
      variant="tonal"
      @click="dialog = true"
  >
    <v-icon size="sm">mdi-comment-plus-outline</v-icon>
  </v-btn>
  <v-dialog
      data-bs-focus="false"
      v-model="dialog"
      min-width="50%"
      persistent
      scroll-strategy="none"
  >
    <v-card >
      <v-toolbar title="Inserir checkpoint">
        <v-btn
            title="Adicionar checkpoint"
            icon="mdi-close"
            @click="() => {dialog = false; emit('close');}"
        ></v-btn>
      </v-toolbar>
      <v-card-text>

        <v-row>
          <v-col cols="6">
            <v-card>
              <v-card-title>Último checkpoint</v-card-title>
              <v-card-text>
                <v-timeline side="end" v-if="lastCheckPoint.descricao">
                  <CheckpointTimelineItem :checkpoint="lastCheckPoint" />

                </v-timeline>
              </v-card-text>

            </v-card>
          </v-col>
          <v-col cols="6">
              <v-row class=" mb-3">
                  <v-col cols="12" md="12" sm="12" class="border-black border-b-thin">
                      <span class="text-gray-dark font-weight-bold">Colaborador: </span><span class="text-gray-dark">{{ usuario.name }}</span>
                  </v-col>
              </v-row>
            <InserirCheckpointForm :usuario="usuario" @close="close"/>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<style scoped>

</style>
