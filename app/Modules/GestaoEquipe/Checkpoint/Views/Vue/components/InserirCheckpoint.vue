<script setup lang="ts">
import {onMounted, ref, watch} from "vue";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import moment from "moment";
import {NaturezaEnum} from "../../../../Alocacao/Views/Vue/Enums/Natureza.enum";
import {ProjetoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Projeto.interface";

const props = defineProps({
  idUsuario: {
    type: Number,
    required: true
  }
});
const dialog = ref(false);
const lastCheckPoint = ref<CheckpointInterface>({} as CheckpointInterface);
const checkpoint = ref<CheckpointInterface>({} as CheckpointInterface);
const projetos = ref<ProjetoInterface>([]);

watch(dialog, async () => {
  if(dialog.value){
    await axiosApi.get(`checkpoint/ultimo/${props.idUsuario}?idEquipe=${getIdEquipe()}`)
        .then(response => {
          lastCheckPoint.value = response.data;
        });
    await axiosApi.get(`checkpoint/projetos?idEquipe=${getIdEquipe()}`)
        .then(response => {
          projetos.value = response.data;
        })
        .catch(error => {
          console.log(error)
        })
    checkpoint.value = {} as CheckpointInterface;
    checkpoint.value.data = moment().format('YYYY-MM-DD');
    checkpoint.value.user_id = props.idUsuario;
    checkpoint.value.compareceu = false;
  }

});
const saveCheckpoint = () => {
  console.log('salvar checkpoint');
}
</script>

<template>

  <v-btn
      class="p-2"
      size="sm"
      variant="tonal"
      color="primary"
      @click="dialog = true"
  >
    <v-icon size="sm">mdi-plus-circle-outline</v-icon>
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
            icon="mdi-close"
            @click="dialog = false"
        ></v-btn>
      </v-toolbar>
      <v-card-text>
        <v-row>
          <v-col cols="6">
            <v-card>
              <v-card-title>Último checkpoint</v-card-title>
              <v-card-text>
                <v-timeline side="end">

                  <v-timeline-item
                      dot-color="primary"
                      size="small"
                  >
                    <template v-slot:opposite>
                      <span class="font-weight-bold">{{ moment(lastCheckPoint.data).format('DD/MM/YYYY') }}</span>
                    </template>
                    <v-alert
                        variant="tonal"
                        :value="true"
                    >
                      <v-row class="mb-0">
                        <v-col cols="12" class="mb-0 pb-0">
                          <span class="font-italic text-xs text-black"> Por {{ lastCheckPoint.criador.name }}</span>
                        </v-col>
                        <v-col cols="2" class="mt-0" v-if="lastCheckPoint.tarefa">
                          <span class="font-italic text-xs text-black" title="Tarefa">  {{ lastCheckPoint.tarefa }}</span>
                        </v-col>
                        <v-col cols="10" class="mt-0" v-if="lastCheckPoint.projeto">
                          <span class="font-italic text-xs text-black" title="Projeto"> {{ lastCheckPoint.projeto.nome }}</span>
                        </v-col>
                      </v-row>
                      <v-row class="p-0 mt-0">
                        <v-col cols="12">
                          {{ lastCheckPoint.descricao}}
                        </v-col>
                      </v-row>

                    </v-alert>
                  </v-timeline-item>
                </v-timeline>
              </v-card-text>

            </v-card>
          </v-col>
          <v-col cols="6">
            <v-form validate-on="blur" @submit.prevent="saveCheckpoint">
              <v-row dense>
                <v-col cols="8" sm="12" md="8">
                  <v-text-field
                      v-model="checkpoint.data"
                      label="Data"
                      type="date"
                      size="large"
                      :rules="[
                          value => !checkpoint.data ? 'Informe a data' : true
                      ]"
                      required
                  ></v-text-field>
                </v-col>
                <v-col cols="4" sm="12" md="4">
                  <v-switch
                      label="Compareceu"
                      v-model="checkpoint.compareceu"
                      :false-value="false"
                      :true-value="true"
                      color="primary"
                      inset
                  ></v-switch>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="10" sm="12" md="10">
                  <v-select
                      v-model="checkpoint.projeto"
                      @update:modelValue="checkpoint.projeto_id = checkpoint.projeto.id"
                      :items="projetos"
                      item-title="nome"
                      return-object
                      clearable
                      item-value="id"
                      label="Projeto"
                      required
                  ></v-select>
                </v-col>
                <v-col cols="2" sm="12" md="2">
                  <v-text-field
                      v-model="checkpoint.tarefa"
                      label="Tarefa"
                      size="large"

                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                      v-model="checkpoint.descricao"
                      label="Descrição"
                      size="large"
                      :rules="[
                          value => !checkpoint.descricao ? 'Informe a descrição' : true
                      ]"
                      required
                  ></v-textarea>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="12" sm="12" md="12">
                  <v-spacer></v-spacer>
                  <v-btn type="submit" color="primary" variant="flat">Salvar</v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<style scoped>

</style>
