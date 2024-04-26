<script setup lang="ts">
import {onMounted, PropType, ref, watch, watchEffect} from "vue";
import {TipoRetrabalhoInterface} from "../Interfaces/TipoRetrabalho.interface";
import axios from "axios";
import {RetrabalhoInterface} from "../Interfaces/Retrabalho.interface";
import {AplicacaoInterface} from "../Interfaces/Aplicacao.interface";
import {ProjetoInterface} from "../Interfaces/Projeto.interface";
import {UsuarioInterface} from "../Interfaces/Usuario.interface";
import moment from "moment";
import {getError, hasError} from "../../../../../../resources/js/ErrorHelper";
import FormInserirCasoTeste from "./FormInserirCasoTeste.vue";

const props = defineProps({
    actionForm: {
        type: String,
        required: true
    },
    csrf: {
        type: String,
        required: true
    },
    errors: {
        type: Array,
        required: false,
        default: null
    },
    retrabalho: {
        type: Object as PropType<RetrabalhoInterface>,
        required: true

    }
});
const loading = ref(false);
const listaTiposRetrabalho = ref<TipoRetrabalhoInterface[]>([]);
const listaAplicacoes = ref<AplicacaoInterface[]>([]);
const listaProjetos = ref<ProjetoInterface[]>([]);
const listaUsuarios = ref<UsuarioInterface[]>([]);

const retrabalho = ref<RetrabalhoInterface>(props.retrabalho);
retrabalho.value.tipo_retrabalho = null;
retrabalho.value.aplicacao = null;
retrabalho.value.projeto = null;
retrabalho.value.usuario = null;
retrabalho.value.data = retrabalho.value.data ? retrabalho.value.data : moment().format('YYYY-MM-DD');

const shouldShowError = (field) => {
    return hasError(field, props.errors);
}
const getShowError = (field) => {
    return getError(field, props.errors);
}
const populaTiposRetrabalho = async () => {
    await axios.get('consultas/tipos').then((res) => {
        listaTiposRetrabalho.value = res.data;
        if (retrabalho.value.id_tipo_retrabalho) {
            retrabalho.value.tipo_retrabalho =
                listaTiposRetrabalho.value.find((item: TipoRetrabalhoInterface) => item.id == retrabalho.value.id_tipo_retrabalho);
        }
    })
}
const populaUsuarios = async () => {
    await axios.get('consultas/usuarios').then((res) => {
        listaUsuarios.value = res.data;
        if (retrabalho.value.id_usuario) {
            retrabalho.value.usuario =
                listaUsuarios.value.find((item: UsuarioInterface) => item.id == retrabalho.value.id_usuario);
        }
    })
}

const populaAplicacoes = async () => {
    await axios.get('../projetos/consultas/aplicacoes').then((res) => {
        listaAplicacoes.value = res.data;

        if (retrabalho.value.id_aplicacao) {
            retrabalho.value.aplicacao =
                listaAplicacoes.value.find((item: AplicacaoInterface) => item.id == retrabalho.value.id_aplicacao);
        }

    })
}

const populaProjetos = async (idAplicacao:number) => {
    await axios.get(`../projetos/consultas/aplicacoes/${idAplicacao}/projetos`).then((res) => {
        listaProjetos.value = res.data;
        if (retrabalho.value.id_projeto) {
            retrabalho.value.projeto =
                listaProjetos.value.find((item: ProjetoInterface) => item.id == retrabalho.value.id_projeto);
        }
    })
}

onMounted( () => {
    populaTiposRetrabalho();
    populaAplicacoes();
    populaUsuarios();
});
watchEffect(()  => {
    if(retrabalho.value.aplicacao?.id){
        populaProjetos(retrabalho.value.aplicacao.id);
    }
})

</script>

<template>
    <form id="form-rework" :action="actionForm" method="POST" autocomplete="off">
        <input type="hidden" name="_token" :value="csrf">
        <div class="row">
            <div class="col-md-6 border-e-sm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.tipo_retrabalho?.id" name="id_tipo_retrabalho" />
                            <v-combobox
                                v-model="retrabalho.tipo_retrabalho"
                                label="Tipo de retrabalho"
                                :items="listaTiposRetrabalho"
                                variant="solo"
                                :return-object="true"
                                item-title="descricao"
                                item-value="id"
                                id="tipo_retrabalho"
                                name="tipo_retrabalho"
                                :error="shouldShowError('id_tipo_retrabalho')"
                                :error-messages="getShowError('id_tipo_retrabalho')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.usuario?.id" name="id_usuario" />
                            <v-combobox
                                v-model="retrabalho.usuario"
                                label="Desenvolvedor"
                                :items="listaUsuarios"
                                variant="solo"
                                :return-object="true"
                                item-title="name"
                                item-value="id"
                                id="usuario"
                                name="usuario"
                                :error="shouldShowError('id_usuario')"
                                :error-messages="getShowError('id_usuario')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.aplicacao?.id" name="id_aplicacao" />
                            <v-combobox
                                v-model="retrabalho.aplicacao"
                                label="Aplicação"
                                :items="listaAplicacoes"
                                variant="solo"
                                :return-object="true"
                                item-title="nome"
                                item-value="id"
                                id="aplicacao"
                                name="aplicacao"
                                :error="shouldShowError('id_aplicacao')"
                                :error-messages="getShowError('id_aplicacao')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.projeto?.id" name="id_projeto" />
                            <v-combobox
                                v-model="retrabalho.projeto"
                                label="Projeto"
                                :items="listaProjetos"
                                variant="solo"
                                :return-object="true"
                                item-title="nome"
                                item-value="id"
                                id="projeto"
                                name="projeto"
                                :disabled="retrabalho.aplicacao === null"
                                :error="shouldShowError('id_projeto')"
                                :error-messages="getShowError('id_projeto')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <v-text-field
                                v-model="retrabalho.data"
                                label="Data"
                                name="data"
                                id="data"
                                type="date"
                                :error="shouldShowError('data')"
                                :error-messages="getShowError('data')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <v-text-field
                                v-model="retrabalho.numero_tarefa"
                                label="Tarefa"
                                name="numero_tarefa"
                                id="numero_tarefa"
                                :error="shouldShowError('numero_tarefa')"
                                :error-messages="getShowError('numero_tarefa')"
                            ></v-text-field>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <v-textarea
                                v-model="retrabalho.descricao"
                                label="Descrição"
                                name="descricao"
                                id="descricao"
                                :error="shouldShowError('descricao')"
                                :error-messages="getShowError('descricao')"
                            ></v-textarea>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <form-inserir-caso-teste
                    :casoTeste="retrabalho.caso_teste"
                    :errors="props.errors"
                />

                <div class="row m-1">
                    <v-btn
                        color="primary"
                        type="submit"
                        :loading="loading"
                        @click="loading = true"
                    >
                        Salvar
                    </v-btn>
                </div>
            </div>
        </div>
    </form>
</template>

<style scoped>
.border-right{
    border-right: 1px solid #000;
}
</style>
