<script setup lang="ts">
import {onBeforeMount, onMounted, ref} from "vue";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import InserirCheckpoint from "./InserirCheckpoint.vue";
import {helperStore} from "../../../../Alocacao/Views/Vue/HelperStore";
import {LoaderStore} from "../../../../../../../resources/js/GlobalStore/LoaderStore";
import {PermissionStore} from "../../../../../../../resources/js/GlobalStore/PermissionStore";
import {PermissionEnum as CheckpointPermissionEnum} from "../Enums/PermissionEnum";
import {PermissionEnum as ObservacaoPermissionEnum} from "../../../../Observacao/Views/Vue/Enums/PermissionEnum";

import VerCheckpoints from "./VerCheckpoints.vue";
import VerObservacoes from "../../../../Observacao/Views/Vue/components/VerObservacoes.vue";
const props = defineProps({
    canInsert: {
        type: Boolean,
        required: true,
        default: false
    }
});

const itemsPerPage = ref(10);
const search = ref('');
const loading = ref<boolean>(true);
const totalItems = ref<number>(0);
const headers = [
    {
        title: 'Usuários',
        align: 'start',
        sortable: false,
        key: 'name',
    },
    { title: 'Ações', key: 'id', align: 'center', sortable: false },
];
const listUsuario = ref<UsuarioInterface[]>();
const url = `${import.meta.env.VITE_APP_URL}/gestao-equipe/`;
const loadItems = async (options: any) => {
    loading.value = true;
    LoaderStore.setShowLoader();
    await axiosApi.get(`checkpoint/usuarios?idEquipe=${getIdEquipe()}&page=${options.page}&limit=${options.itemsPerPage}&search=${options.search}`)
        .then(response => {
            listUsuario.value = response.data.data;
            loading.value = false;
            totalItems.value = response.data.meta.total;
        });
    LoaderStore.setHideLoader();
};
</script>

<template>
    <v-data-table-server
        v-model:items-per-page="itemsPerPage"
        :headers="headers"
        :items="listUsuario"
        :items-length="totalItems"
        :loading="loading"
        :search="search"
        item-value="name"
        loading-text="Carregando..."
        @update:options="loadItems"
    >
        <template v-slot:item="{ item }">
            <tr>
                <td class="col-nome">{{ item.name }}</td>
                <td class="col-acoes">
                    <v-row>
                        <v-col cols="12">
                            <ver-checkpoints class="m" :usuario="item" v-if="PermissionStore.hasPermission(CheckpointPermissionEnum.VER_CHECKPOINT)"/>
                            <inserir-checkpoint v-if="PermissionStore.hasPermission(CheckpointPermissionEnum.CRIAR_CHECKPOINT) " :usuario="item"/>
                            <ver-observacoes v-if="PermissionStore.hasPermission(ObservacaoPermissionEnum.LISTAR_OBSERVACAO)" :usuario="item"/>
                            <v-btn
                                :href="`${url}${item.id}/`"
                                class="mx-2 p-2"
                                size="sm"
                                variant="tonal"
                                color="purple"
                            >
                                <v-icon size="sm">mdi-account-circle</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </td>
            </tr>

        </template>
    </v-data-table-server>
</template>

<style scoped>
.col-nome{
    width: 75%;
}
.col-acoes{
    text-align: center;
}
</style>
