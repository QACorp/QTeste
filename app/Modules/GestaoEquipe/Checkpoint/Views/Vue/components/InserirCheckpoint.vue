<script setup lang="ts">
import {onMounted, ref, watch, watchEffect} from "vue";
import CheckpointInterface from "../Interfaces/Checkpoint.interface";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import moment from "moment";
import {AlocacaoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Alocacao.interface";
import {ProjetoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Projeto.interface";
import {useToast} from "vue-toast-notification";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import CheckpointTimelineItem from "./CheckpointTimelineItem.vue";
import Editor from "@tinymce/tinymce-vue";
import TFieldTarefas from "../../../../../Projetos/Views/Vue/components/TFieldTarefas.vue";
import {LoaderStore} from "@/GlobalStore/LoaderStore";

const $toast = useToast();
const props = defineProps({
  usuario: {
    type: Object as UsuarioInterface,
    required: true
  },

});
const dialog = ref(false);
const lastCheckPoint = ref<CheckpointInterface>({} as CheckpointInterface);
const checkpoint = ref<CheckpointInterface>({} as CheckpointInterface);
const projetos = ref<ProjetoInterface>([]);
const alocacoes = ref<AlocacaoInterface>([]);

watch(dialog, async () => {

  if(dialog.value){
    LoaderStore.showLoader = true;
    checkpoint.value = {} as CheckpointInterface;
    checkpoint.value.data = moment().format('YYYY-MM-DD');
    checkpoint.value.user_id = props.usuario.id;
    checkpoint.value.compareceu = false;
    axiosApi.get(`checkpoint/ultimo/${props.usuario.id}?idEquipe=${getIdEquipe()}`)
        .then(response => {
          lastCheckPoint.value = response.data;
        });
    axiosApi.get(`checkpoint/projetos?idEquipe=${getIdEquipe()}`)
        .then(response => {
          projetos.value = response.data;
        })
        .catch(error => {
          console.log(error)
        });
    await findAlocacao(checkpoint.value.data);
    LoaderStore.showLoader = false;

  }
});
const updateAlocacao = () => {
    console.log(checkpoint.value.alocacao);
  if(checkpoint.value.alocacao) {
    checkpoint.value.alocacao_id = checkpoint.value.alocacao.id;
    checkpoint.value.projeto_id = checkpoint.value.alocacao.projeto_id;
    checkpoint.value.tarefa = checkpoint.value.alocacao.tarefa;
    checkpoint.value.projeto = projetos.value.find(projeto => projeto.id == checkpoint.value.alocacao.projeto_id);
  }else {
    checkpoint.value.alocacao_id = null;
    checkpoint.value.projeto_id = null;
    checkpoint.value.tarefa = null;
    checkpoint.value.projeto = null;
  }

}

watchEffect(async  () => {
  if(dialog.value){
    //await findAlocacao(checkpoint.value.data);

  }

})

const findAlocacao = async (data: string) => {
  if(!data) return;
  LoaderStore.showLoader = true;
  checkpoint.value.alocacao = null;
  await axiosApi.get(`checkpoint/alocacao/usuario/${props.usuario.id}/data/${data}?idEquipe=${getIdEquipe()}`)
      .then(response => {
        alocacoes.value = response.data;
      })
      .catch(error => {
        console.log(error)
      })
  LoaderStore.showLoader = false;
}
const saveCheckpoint = async () => {
  LoaderStore.showLoader = true;
  await axiosApi.post(`checkpoint/?idEquipe=${getIdEquipe()}`, checkpoint.value)
      .then(response => {
        $toast.success('Checkpoint inserido com sucesso!', {
          duration: 5000
        });
        dialog.value = false;
      })
      .catch(error => {
        $toast.error(error.response.data.message, {
          duration: 5000
        });
      })
    LoaderStore.showLoader = false;
}
</script>

<template>

  <v-btn
      class="p-2"
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
            @click="dialog = false"
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
            <v-form validate-on="blur" @submit.prevent="saveCheckpoint">
              <v-row dense>
                <v-col cols="6" sm="12" md="6">
                  <v-text-field
                      v-model="checkpoint.data"
                      label="Data"
                      @blur="findAlocacao(checkpoint.data)"
                      type="date"
                      size="large"
                      :rules="[
                          value => !checkpoint.data ? 'Informe a data' : true
                      ]"
                      required
                  ></v-text-field>
                </v-col>
                <v-col cols="6" sm="12" md="6">
                  <v-select
                      v-model="checkpoint.alocacao"
                      @update:modelValue="updateAlocacao()"
                      :items="alocacoes"
                      no-data-text="Nenhuma alocação encontrada para esta data"
                      return-object
                      clearable
                      item-value="id"
                      label="Alocação"
                  >
                    <template v-slot:item="{ props, item }">
                      <v-list-item v-bind="props" :title="`${moment(item.raw.inicio).format('DD/MM/YYYY')} - ${moment(item.raw.termino).format('DD/MM/YYYY')}`"></v-list-item>
                    </template>
                    <template v-slot:selection="{ props, item }">
                      <span class="">{{ moment(item.raw.inicio).format('DD/MM/YYYY') }} - {{ moment(item.raw.termino).format('DD/MM/YYYY')  }}</span>
                    </template>

                  </v-select>
                </v-col>

              </v-row>
              <v-row dense>
                <v-col cols="10" sm="12" md="10">
                  <v-select
                      v-model="checkpoint.projeto"
                      @update:modelValue="checkpoint.projeto_id = checkpoint.projeto.id"
                      :items="projetos"
                      item-title="nome"
                      no-data-text="Nenhum projeto encontrado"
                      return-object
                      clearable
                      item-value="id"
                      label="Projeto"
                      required
                  ></v-select>
                </v-col>
                <v-col cols="2" sm="12" md="2">
                  <TFieldTarefas v-model="checkpoint.tarefa_id" :key="checkpoint.tarefa?.tarefa" :tarefa="checkpoint.tarefa?.tarefa"/>
                </v-col>
              </v-row>
              <v-row dense>
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
                <v-col cols="12" sm="12" md="12">
                  <label for="descricao">Descrição</label>
                  <Editor
                      required
                      licenseKey="gpl"
                      v-model="checkpoint.descricao"
                  />

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
