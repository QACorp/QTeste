<script setup lang="ts">
import ListaObservacaoCheckpoint from "./ListaObservacaoCheckpoint.vue";
import InserirCheckpointForm from "../../../Submodules/Checkpoint/Views/Vue/components/InserirCheckpointForm.vue";
import InserirObservacaoForm from "../../../Submodules/Observacao/Views/Vue/components/InserirObservacaoForm.vue";
import {onMounted, ref} from "vue";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {UsuarioInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Usuario.interface";
import moment from "moment";
import {axiosApi} from "../../../../../../resources/js/APIUtils/AxiosBase";
import CheckpointTimelineItem from "../../../Submodules/Checkpoint/Views/Vue/components/CheckpointTimelineItem.vue";
import CheckpointInterface from "../../../Submodules/Checkpoint/Views/Vue/Interfaces/Checkpoint.interface";

const opcao = ref<string>('checkpoint');
const props = defineProps({
    idUsuario: {
        type: Number,
        required: true
    }
});
const usuario = ref<UsuarioInterface>({} as UsuarioInterface);
const keyLista = ref<string>(moment().format('YYYYMMDDHHMMSS'));
const checkpoint = ref<CheckpointInterface>({} as CheckpointInterface);
onMounted(async () => {
    checkpoint.value.data = moment().format('YYYY-MM-DD');
    checkpoint.value.user_id = props.idUsuario;
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
                <v-col cols="12" >
                    <v-card >
                        <v-card-text class="pb-0">
                            <v-switch
                                inset
                                :label="`Inserir ${opcao}`"
                                v-model="opcao"
                                label-checked="Observação"
                                label-unchecked="Checkpoint"
                                false-value="checkpoint"
                                true-value="observação"
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
                            <InserirCheckpointForm v-model="checkpoint" @close="refreshKey"  :usuario="usuario" />
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
