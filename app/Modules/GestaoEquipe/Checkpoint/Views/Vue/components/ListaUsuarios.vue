<script setup lang="ts">
import {onBeforeMount, onMounted, ref} from "vue";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {axiosApi} from "../../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../../resources/js/APIUtils/BaseAPI";
import InserirCheckpoint from "./InserirCheckpoint.vue";
import {helperStore} from "../../../../Alocacao/Views/Vue/HelperStore";
const props = defineProps({
    canInsert: {
        type: Boolean,
        required: true,
        default: false
    }
});
onBeforeMount(() => {
    helperStore.insertCheckpoint = props.canInsert;
})
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
    { title: 'Ações', key: 'id', align: 'end', sortable: false },
];
const listUsuario = ref<UsuarioInterface[]>();

const loadItems = async (options: any) => {
    loading.value = true;
    await axiosApi.get(`checkpoint/usuarios?idEquipe=${getIdEquipe()}&page=${options.page}&limit=${options.itemsPerPage}&search=${options.search}`)
        .then(response => {
            listUsuario.value = response.data.data;
            loading.value = false;
            totalItems.value = response.data.meta.total;
        });
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
                <td class="w-100">{{ item.name }}</td>
                <td class="w-auto"><inserir-checkpoint v-if="helperStore.insertCheckpoint" :usuario="item"/></td>
            </tr>

        </template>
    </v-data-table-server>
</template>

<style scoped>

</style>
