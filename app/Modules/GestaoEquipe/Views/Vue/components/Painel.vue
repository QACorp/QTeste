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
import RetrabalhosTarefasProjetosCards from "./RetrabalhosTarefasProjetosCards.vue";
import {PermissionStore} from "../../../../../../resources/js/GlobalStore/PermissionStore";
import {PermissionEnum as PermissionEnumRetrabalho} from "../../../../Retrabalhos/Views/Vue/Enums/PermissionEnum";
import ModalInserirObservacao from "./ModalInserirObservacao.vue";
import ModalInserirCheckpoint from "./ModalInserirCheckpoint.vue";

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
const inicio = ref<string>(moment().startOf('month').format('YYYY-MM-DD'));
const termino = ref<string>(moment().endOf('month').format('YYYY-MM-DD'));
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
    <v-row class="pb-0">
        <v-col cols="12" class="pb-0">
            <v-card>
                <v-card-text>
                    <v-row class="pb-0">
                        <v-col class="pb-0" cols="12" md="5" >
                            <v-text-field
                                type="date"
                                clearable
                                on-click:clear="termino = null"
                                v-model="inicio"
                                label="Início"></v-text-field>
                        </v-col >
                        <v-col class="pb-0" cols="12" md="6">
                            <v-text-field
                                type="date"
                                clearable
                                on-click:clear="termino = null"
                                v-model="termino"
                                label="Término"></v-text-field>
                        </v-col>
                        <v-col class="pb-0" cols="12" md="1">
                            <v-btn
                                @click="refreshKey()"
                                density="default"
                                variant="tonal"
                                color="primary"
                                icon="mdi-find-replace"
                            ></v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
    <v-row class="pb-0" v-if="usuario.id && PermissionStore.hasPermission(PermissionEnumRetrabalho.VER_RELATORIO_GESTOR)">
        <v-col cols="12" class="pb-0">
            <v-row class="pb-0">
                <RetrabalhosTarefasProjetosCards :key="keyLista" :id-usuario="usuario.id" :inicio="inicio" :termino="termino" />
            </v-row>
        </v-col>
    </v-row>
    <v-row v-if="usuario.id">
        <v-col cols="12" md="7" lg="7">
            <v-card>
                <v-card-title>
                    Observações/Checkpoint
                </v-card-title>
                <v-card-text>
                    <ListaObservacaoCheckpoint :inicio="inicio" :termino="termino" :key="keyLista" :id-usuario="usuario.id" />
                </v-card-text>
            </v-card>

        </v-col>
        <v-col cols="12" md="5" lg="5" >
            <v-row>
                <v-col cols="12" >
                    <v-card >
                        <v-card-text class="space-btn">
                            <modal-inserir-observacao :usuario="usuario" @close="refreshKey" />
                            <modal-inserir-checkpoint v-model="checkpoint" :usuario="usuario" @close="refreshKey" />
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

        </v-col>
    </v-row>
</template>

<style scoped>
.space-btn {
    display: flex;
    justify-content: space-between;
}
</style>
