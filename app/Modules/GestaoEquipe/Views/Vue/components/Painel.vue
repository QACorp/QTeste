<script setup lang="ts">
import ListaObservacaoCheckpoint from "./ListaObservacaoCheckpoint.vue";
import InserirCheckpoint from "../../../Checkpoint/Views/Vue/components/InserirCheckpoint.vue";
import InserirCheckpointForm from "../../../Checkpoint/Views/Vue/components/InserirCheckpointForm.vue";
import InserirObservacaoForm from "../../../Observacao/Views/Vue/components/InserirObservacaoForm.vue";
import {onMounted, ref} from "vue";
import {axiosApi} from "../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {UsuarioInterface} from "../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import moment from "moment";

const opcao = ref<string>('checkpoint');
const props = defineProps({
    idUsuario: {
        type: Number,
        required: true
    }
});
const usuario = ref<UsuarioInterface>({} as UsuarioInterface);
const keyLista = ref<string>(moment().format('YYYYMMDDHHMMSS'));
onMounted(async () => {
    await axiosApi.get(`user/${props.idUsuario}?idEquipe=${getIdEquipe()}`)
        .then(response => {
            usuario.value = response.data;
        })
        .catch(error => {
            console.log(error)
        });
});
const refreshKey = () => {
    keyLista.value = moment().format('YYYYMMDDHHMMSS');
}
</script>

<template>
    <v-row v-if="usuario.id">
        <v-col cols="12" md="6" lg="6">
            <v-card>
                <v-card-title>
                    Observações/Checkpoint
                </v-card-title>
                <v-card-text>
                    <ListaObservacaoCheckpoint :key="keyLista" :id-usuario="usuario.id" />
                </v-card-text>
            </v-card>

        </v-col>
        <v-col cols="12" md="6" lg="6" >
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-text>
                            <v-switch
                                inset
                                :label="`Inserir ${opcao}`"
                                v-model="opcao"
                                label-checked="Observação"
                                label-unchecked="Checkpoint"
                                false-value="checkpoint"
                                true-value="observacao"
                            ></v-switch>
                        </v-card-text>
                    </v-card>
                </v-col>

            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-card v-if="opcao === 'checkpoint'">
                        <v-card-title>
                            Inserir checkpoint
                        </v-card-title>
                        <v-card-text>
                            <InserirCheckpointForm @close="refreshKey"  :usuario="usuario" />
                        </v-card-text>
                    </v-card>
                    <v-card v-else>
                        <v-card-title>
                            Inserir observação
                        </v-card-title>
                        <v-card-text>
                            <InserirObservacaoForm @close="refreshKey" :usuario="usuario" />
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

        </v-col>
    </v-row>
</template>

<style scoped>

</style>
