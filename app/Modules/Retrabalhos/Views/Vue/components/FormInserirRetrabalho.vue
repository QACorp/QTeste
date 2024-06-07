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
import {CasoTesteInterface} from "../Interfaces/CasoTeste.interface";
import {TipoRetrabalhoEnum} from "../Enums/TipoRetrabalho.enum";

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

    },
    criticidades: {
        type: Array,
        required: true
    },
    method:{
        type: String,
        required: true,
        default: 'POST'
    }
});
const loading = ref(false);
const noDataText = ref<string>('Digite para iniciar a busca');
const listaTiposRetrabalho = ref<TipoRetrabalhoInterface[]>([]);
const listaAplicacoes = ref<AplicacaoInterface[]>([]);
const listaProjetos = ref<ProjetoInterface[]>([]);
const listaUsuarios = ref<UsuarioInterface[]>([]);
const listaCasosTeste = ref<CasoTesteInterface[]>([]);

const retrabalho = ref<RetrabalhoInterface>(props.retrabalho);
retrabalho.value.tipo_retrabalho = null;
retrabalho.value.aplicacao = null;
retrabalho.value.projeto = null;
retrabalho.value.usuario = null;
retrabalho.value.criticidade = retrabalho.value.criticidade == '' ? null : retrabalho.value.criticidade;
retrabalho.value.data = retrabalho.value.data ? retrabalho.value.data : moment().format('YYYY-MM-DD');

const caso_teste = ref<CasoTesteInterface>(props.retrabalho.caso_teste?.caso_teste_id ? props.retrabalho.caso_teste : null);
const shouldShowError = (field) => {
    return hasError(field, props.errors);
}
const getShowError = (field) => {
    return getError(field, props.errors);
}
const populaTiposRetrabalho = async () => {
    await axios.get(import.meta.env.VITE_APP_URL+'/retrabalhos/consultas/tipos').then((res) => {
        listaTiposRetrabalho.value = res.data;
        if (retrabalho.value.tipo_retrabalho_id) {
            retrabalho.value.tipo_retrabalho =
                listaTiposRetrabalho.value.find((item: TipoRetrabalhoInterface) => item.id == retrabalho.value.tipo_retrabalho_id);
        }
    })
}
const populaUsuarios = async () => {
    await axios.get(import.meta.env.VITE_APP_URL+'/retrabalhos/consultas/usuarios').then((res) => {
        listaUsuarios.value = res.data;
        if (retrabalho.value.usuario_id) {
            retrabalho.value.usuario =
                listaUsuarios.value.find((item: UsuarioInterface) => item.id == retrabalho.value.usuario_id);
        }
    })
}

const populaAplicacoes = async () => {
    await axios.get(import.meta.env.VITE_APP_URL+'/projetos/consultas/aplicacoes').then((res) => {
        listaAplicacoes.value = res.data;
        if (retrabalho.value.aplicacao_id) {
            retrabalho.value.aplicacao =
                listaAplicacoes.value.find((item: AplicacaoInterface) => item.id == retrabalho.value.aplicacao_id);
        }

    })
}

const populaProjetos = async (idAplicacao:number) => {
    await axios.get(import.meta.env.VITE_APP_URL+`/projetos/consultas/aplicacoes/${idAplicacao}/projetos`).then((res) => {
        listaProjetos.value = res.data;
        if (retrabalho.value.projeto_id) {
            retrabalho.value.projeto =
                listaProjetos.value.find((item: ProjetoInterface) => item.id == retrabalho.value.projeto_id);
        }
    })
}

const populaCasosTeste = async (term:string) => {
    if(!term || term.length < 3) return;

    noDataText.value = 'Buscando...'
    await axios.get(import.meta.env.VITE_APP_URL+`/projetos/consultas/casos-testes?term=${term}`).then((res) => {
        listaCasosTeste.value = res.data;
        listaCasosTeste.value = listaCasosTeste.value.map((item: any) => {
            return {
                caso_teste_id: item.id,
                titulo_caso_teste: item.titulo,
                cenario_caso_teste: item.cenario,
                requisito_caso_teste: item.requisito,
                teste_caso_teste: item.teste,
                resultado_esperado_caso_teste: item.resultado_esperado,
                id: item.id
            }
        })
        if(listaCasosTeste.value.length === 0){
            noDataText.value = 'Nenhum registro encontrado'
        }
        if (retrabalho.value.caso_teste.caso_teste_id) {
            retrabalho.value.caso_teste =
                listaCasosTeste.value.find((item: CasoTesteInterface) => item.caso_teste_id == retrabalho.value.caso_teste.caso_teste_id);
        }
    })
}
const populaCasosTestePorId = async (idCasoTeste:number) => {

    await axios.get(import.meta.env.VITE_APP_URL+`/projetos/consultas/casos-testes/${idCasoTeste}`).then((res) => {
        listaCasosTeste.value = [res.data];
        listaCasosTeste.value = listaCasosTeste.value.map((item: any) => {
            return {
                caso_teste_id: item.id,
                titulo_caso_teste: item.titulo,
                cenario_caso_teste: item.cenario,
                requisito_caso_teste: item.requisito,
                teste_caso_teste: item.teste,
                resultado_esperado_caso_teste: item.resultado_esperado,
                id: item.id
            }
        })
        if (retrabalho.value.caso_teste.caso_teste_id) {
            retrabalho.value.caso_teste =
                listaCasosTeste.value.find((item: CasoTesteInterface) => {
                    return item.caso_teste_id === retrabalho.value.caso_teste.caso_teste_id;
                });
        }
    })
}

onMounted( async () => {
    populaTiposRetrabalho();
    populaAplicacoes();
    populaUsuarios();

    if (retrabalho.value.caso_teste?.caso_teste_id) {
        await populaCasosTestePorId(retrabalho.value.caso_teste.caso_teste_id);
        caso_teste.value = retrabalho.value.caso_teste;
    }


});
watchEffect(()  => {
    if(retrabalho.value.aplicacao?.id){
        populaProjetos(retrabalho.value.aplicacao.id);
    }
});
watch(caso_teste, (new_caso_teste, old_caso_teste) => {
    if(new_caso_teste  && new_caso_teste?.id !== null){
        retrabalho.value.caso_teste = new_caso_teste;
    }
})

</script>

<template>
    <form id="form-rework" :action="actionForm" method="POST" autocomplete="off">
        <input type="hidden" name="_method" :value="method">
        <input type="hidden" name="_token" :value="csrf">
        <div class="row">
            <div class="col-md-6 border-e-sm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.tipo_retrabalho?.id" name="tipo_retrabalho_id" />
                            <v-combobox
                                v-model="retrabalho.tipo_retrabalho"
                                label="Tipo de retrabalho"
                                :items="listaTiposRetrabalho"
                                variant="solo"
                                :return-object="true"
                                item-title="descricao"
                                item-value="id"
                                id="_tipo_retrabalho"
                                name="_tipo_retrabalho"
                                :error="shouldShowError('tipo_retrabalho_id')"
                                :error-messages="getShowError('tipo_retrabalho_id')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.usuario?.id" name="usuario_id" />
                            <v-combobox
                                v-model="retrabalho.usuario"
                                label="Desenvolvedor"
                                :items="listaUsuarios"
                                variant="solo"
                                :return-object="true"
                                item-title="name"
                                item-value="id"
                                id="_usuario"
                                name="_usuario"
                                :error="shouldShowError('usuario_id')"
                                :error-messages="getShowError('usuario_id')"
                            >
                            </v-combobox>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.aplicacao?.id" name="aplicacao_id" />
                            <v-combobox
                                v-model="retrabalho.aplicacao"
                                label="Aplicação"
                                :items="listaAplicacoes"
                                variant="solo"
                                :return-object="true"
                                item-title="nome"
                                item-value="id"
                                id="_aplicacao"
                                name="_aplicacao"
                                :error="shouldShowError('aplicacao_id')"
                                :error-messages="getShowError('aplicacao_id')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.projeto?.id" name="projeto_id" />
                            <v-combobox
                                v-model="retrabalho.projeto"
                                label="Projeto"
                                :items="listaProjetos"
                                variant="solo"
                                :return-object="true"
                                item-title="nome"
                                item-value="id"
                                id="_projeto"
                                name="_projeto"
                                :disabled="retrabalho.aplicacao === null"
                                :error="shouldShowError('projeto_id')"
                                :error-messages="getShowError('projeto_id')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <v-text-field
                                v-model="retrabalho.data"
                                label="Data"
                                name="data"
                                variant="solo"
                                id="data"
                                type="date"
                                :error="shouldShowError('data')"
                                :error-messages="getShowError('data')"
                            />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <v-text-field
                                v-model="retrabalho.numero_tarefa"
                                label="Tarefa"
                                name="numero_tarefa"
                                id="numero_tarefa"
                                variant="solo"
                                :error="shouldShowError('numero_tarefa')"
                                :error-messages="getShowError('numero_tarefa')"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.criticidade" name="criticidade" />
                            <v-combobox
                                v-model="retrabalho.criticidade"
                                label="Criticidade"
                                :items="props.criticidades"
                                variant="solo"
                                :return-object="true"
                                item-title="name"
                                item-value="id"
                                id="_criticidade"
                                name="_criticidade"
                                :error="shouldShowError('criticidade')"
                                :error-messages="getShowError('criticidade')"
                            >
                            </v-combobox>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.caso_teste?.caso_teste_id" name="caso_teste_id" />
                            <v-autocomplete
                                v-model="caso_teste"
                                label="Caso de teste"
                                :items="listaCasosTeste"
                                variant="solo"
                                return-object
                                :no-data-text="noDataText"
                                hint="Digite pelo menos 3 letras para para começar a filtrar"
                                item-title="titulo_caso_teste"
                                item-value="caso_teste_id"
                                :clearable="true"
                                id="_caso_teste"
                                name="_caso_teste"
                                @click:clear="retrabalho.caso_teste = {} as CasoTesteInterface"
                                @update:search="populaCasosTeste"
                                v-if="retrabalho.tipo_retrabalho?.tipo === TipoRetrabalhoEnum.FUNCIONAL"
                                :error="shouldShowError('caso_teste_id')"
                                :error-messages="getShowError('caso_teste_id')"
                            >
                            </v-autocomplete>
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
                <div class="row">
                    <div class="col-md-12">
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
            </div>

            <div class="col-md-6">

                <form-inserir-caso-teste
                    v-model="retrabalho.caso_teste"
                    v-if="retrabalho.tipo_retrabalho?.tipo === TipoRetrabalhoEnum.FUNCIONAL"
                    :errors="props.errors"
                />
            </div>
        </div>

    </form>
</template>

<style scoped>
.border-right{
    border-right: 1px solid #000;
}
</style>
