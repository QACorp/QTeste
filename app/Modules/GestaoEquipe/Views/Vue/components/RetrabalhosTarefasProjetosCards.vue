<script setup lang="ts">
import moment from "moment/moment";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {axiosApi} from "../../../../../../resources/js/APIUtils/AxiosBase";
import {onMounted, ref} from "vue";
import RelatorioRetrabalhoInterface from "../Interfaces/RelatorioRetrabalho.interface";
import {useToast} from "vue-toast-notification";

const $toast = useToast();
const props = defineProps({
    idUsuario: {
        type: Number,
        required: true
    },
    inicio: {
        type: String,
        default: moment().startOf('month').format('YYYY-MM-DD')
    },
    termino: {
        type: String,
        default: moment().endOf('month').format('YYYY-MM-DD')
    }
});
const dados = ref<RelatorioRetrabalhoInterface>({} as RelatorioRetrabalhoInterface);
const loadDados = async () => {
    //LoaderStore.setShowLoader();
    let url = `gestao-equipe/${props.idUsuario}/retrabalhos?idEquipe=${getIdEquipe()}`;
    if(props.inicio){
        url += `&inicio=${props.inicio}`;
    }
    if(props.termino){
        url += `&termino=${props.termino}`;
    }
    await axiosApi.get(url)
        .then(response => {
            dados.value = response.data;
        })
        .catch(error => {
            $toast.error(error.response.data.message);
        });
    //LoaderStore.setHideLoader();
}
onMounted(async () => {
    await loadDados()
});
</script>

<template>
    <v-col cols="12" md="4" class="pb-0">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ dados.total_retrabalhos }}</h3>
                <h5>Retrabalhos</h5>
            </div>
            <div class="icon">
                <i class="fas fa-bug text-dark"></i>
            </div>
            <div class="overlay d-none">
                <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
            </div>
        </div>
    </v-col>
    <v-col cols="12" md="4" class="pb-0">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ dados.total_projetos }}</h3>
                <h5>Projetos</h5>
            </div>
            <div class="icon">
                <i class="fas fa-project-diagram text-dark"></i>
            </div>
            <div class="overlay d-none">
                <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
            </div>
        </div>
    </v-col>
    <v-col cols="12" md="4" class="pb-0">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3> {{ dados.total_tarefas }} </h3>
                <h5>Tarefas</h5>
            </div>
            <div class="icon">
                <i class="fas fa-tasks text-dark"></i>
            </div>
            <div class="overlay d-none">
                <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
            </div>
        </div>
    </v-col>


</template>

<style scoped>

</style>
