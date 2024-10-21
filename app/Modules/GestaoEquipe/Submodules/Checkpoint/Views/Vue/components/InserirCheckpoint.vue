<script setup lang="ts">
import {onMounted, ref, watch} from "vue";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";
import {getIdEquipe} from "../../../../../../../../resources/js/APIUtils/BaseAPI";
import {useToast} from "vue-toast-notification";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import CheckpointTimelineItem from "./CheckpointTimelineItem.vue";
import InserirCheckpointForm from "./InserirCheckpointForm.vue";
import {axiosApi} from "../../../../../../../../resources/js/APIUtils/AxiosBase";
import moment from "moment";

const $toast = useToast();
const emit = defineEmits(['close']);
const dialog = ref(false);
const lastCheckPoints = ref<CheckpointInterface[]>([]);
const checkpoint = ref<CheckpointInterface>({} as CheckpointInterface);
const idAlocacao = ref<number>(null);
const props = defineProps({
    usuario: {
        type: Object as UsuarioInterface,
        required: true
    },
    idAlocacao: {
        type: Number,
        required: false,
        default: null
    }

});

watch(dialog, () => {
    checkpoint.value = {} as CheckpointInterface;
    checkpoint.value.data = moment().format('YYYY-MM-DD');
    checkpoint.value.user_id = props.usuario.id;
    checkpoint.value.compareceu = false;
    checkpoint.value.alocacao_id = props.idAlocacao;
})

const loadCheckpoints = async () => {
    if(checkpoint.value.alocacao_id != null) {
        axiosApi.get(`checkpoint/alocacao/${checkpoint.value.alocacao_id}?idEquipe=${getIdEquipe()}`)
            .then(response => {
                lastCheckPoints.value = response.data;
            });
    }else {
        lastCheckPoints.value = [];
    }
}
const close = () => {
    dialog.value = false;
}

</script>

<template>

  <v-btn
      class="p-2"
      size="sm"
      title="Ver checkpoints"
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
              <v-card-title>Checkpoints anteriores</v-card-title>
              <v-card-text>
                <v-timeline side="end">
                  <checkpoint-timeline-item v-for="checkpoint in lastCheckPoints" :key="checkpoint.id" :checkpoint="checkpoint"  />
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
            <InserirCheckpointForm @select-alocacao="loadCheckpoints" v-model="checkpoint" :usuario="usuario" @close="close"/>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<style scoped>

</style>
