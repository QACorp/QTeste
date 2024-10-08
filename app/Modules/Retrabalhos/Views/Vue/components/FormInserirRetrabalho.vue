<script setup lang="ts">
import {onMounted, ref, watchEffect} from "vue";
import {TipoRetrabalhoInterface} from "../Interfaces/TipoRetrabalho.interface";
import {RetrabalhoInterface} from "../Interfaces/Retrabalho.interface";
import {AplicacaoInterface} from "../Interfaces/Aplicacao.interface";
import {ProjetoInterface} from "../Interfaces/Projeto.interface";
import {UsuarioInterface} from "../Interfaces/Usuario.interface";
import moment from "moment";
import FormInserirCasoTeste from "./FormInserirCasoTeste.vue";
import {CasoTesteInterface} from "../Interfaces/CasoTeste.interface";
import {TipoRetrabalhoEnum} from "../Enums/TipoRetrabalho.enum";
import {LoaderStore} from "../../../../../../resources/js/GlobalStore/LoaderStore";
import TFieldTarefas from "../../../../Projetos/Views/Vue/components/TFieldTarefas.vue";
import {axiosApi, axiosWithoutLoader} from "../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {useToast} from "vue-toast-notification";
import {SubmitEventPromise} from "vuetify";


const props = defineProps({
    idRetrabalho: {
        type: Number,
        required: false,
        default: null

    },

});
const loading = ref(false);
const noDataText = ref<string>('Digite para iniciar a busca');
const listaTiposRetrabalho = ref<TipoRetrabalhoInterface[]>([]);
const listaAplicacoes = ref<AplicacaoInterface[]>([]);
const listaProjetos = ref<ProjetoInterface[]>([]);
const listaUsuarios = ref<UsuarioInterface[]>([]);
const listaCasosTeste = ref<CasoTesteInterface[]>([]);
const listaCriticidades = ref<string[]>([]);
const casoTeste = ref<CasoTesteInterface>(null);
const retrabalho = ref<RetrabalhoInterface>({} as RetrabalhoInterface);
retrabalho.value.caso_teste = {} as CasoTesteInterface;
retrabalho.value.data = retrabalho.value.data ? retrabalho.value.data : moment().format('YYYY-MM-DD');

const $toast = useToast();
const findCriticidades = async () => {
   // LoaderStore.setShowLoader();
    axiosApi.get(`/retrabalhos/criticidade`).then((res) => {
        listaCriticidades.value = res.data.map((item) => {
            return {name: item, value: item}
        });
    });
    //LoaderStore.setHideLoader();
}



const populaTiposRetrabalho = async () => {
  //  LoaderStore.setShowLoader();
    await axios.get(import.meta.env.VITE_APP_URL+'/retrabalhos/consultas/tipos').then((res) => {
        listaTiposRetrabalho.value = res.data;
        if (retrabalho.value.tipo_retrabalho_id) {
            retrabalho.value.tipo_retrabalho =
                listaTiposRetrabalho.value.find((item: TipoRetrabalhoInterface) => item.id == retrabalho.value.tipo_retrabalho_id);
        }
    });
   // LoaderStore.setHideLoader();
}
const populaUsuarios = async () => {
  //  LoaderStore.setShowLoader();
    await axios.get(import.meta.env.VITE_APP_URL+'/retrabalhos/consultas/usuarios').then((res) => {
        listaUsuarios.value = res.data;
        if (retrabalho.value.usuario_id) {
            retrabalho.value.usuario =
                listaUsuarios.value.find((item: UsuarioInterface) => item.id == retrabalho.value.usuario_id);
        }
    });
  //  LoaderStore.setHideLoader();
}

const populaAplicacoes = async () => {
 //   LoaderStore.setShowLoader();
    await axios.get(import.meta.env.VITE_APP_URL+'/projetos/consultas/aplicacoes').then((res) => {
        listaAplicacoes.value = res.data;
        if (retrabalho.value.aplicacao_id) {
            retrabalho.value.aplicacao =
                listaAplicacoes.value.find((item: AplicacaoInterface) => item.id == retrabalho.value.aplicacao_id);
        }
    });
 //   LoaderStore.setHideLoader();
}

const populaProjetos = async (idAplicacao:number) => {
 //   LoaderStore.setShowLoader();
    await axios.get(import.meta.env.VITE_APP_URL+`/projetos/consultas/aplicacoes/${idAplicacao}/projetos`).then((res) => {
        listaProjetos.value = res.data;
        if (retrabalho.value.projeto_id) {
            retrabalho.value.projeto =
                listaProjetos.value.find((item: ProjetoInterface) => item.id == retrabalho.value.projeto_id);
        }
    });
//    LoaderStore.setHideLoader();
}

const populaCasosTeste = async (term:string) => {
    if(!term || term.length < 3) return;

    noDataText.value = 'Buscando...'
    await axiosWithoutLoader.get(import.meta.env.VITE_APP_URL+`/projetos/consultas/casos-testes?term=${term}`).then((res) => {
        listaCasosTeste.value = res.data;
        listaCasosTeste.value = listaCasosTeste.value.map((item: any) => {
            return {
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
    });
}
const populaCasosTestePorId = async (idCasoTeste:number) => {
 //   LoaderStore.setShowLoader();
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
        });
        // casoTeste.value = retrabalho.value.caso_teste;
        if (retrabalho.value.caso_teste.id) {
            casoTeste.value =
                listaCasosTeste.value.find((item: CasoTesteInterface) => {
                    return item.caso_teste_id === retrabalho.value.caso_teste.id;
                });
            retrabalho.value.caso_teste = casoTeste.value
        }
    });
  //  LoaderStore.setHideLoader();
}
const findRetrabalho = async () => {
   // LoaderStore.setShowLoader();
    await axiosApi.get(`/retrabalhos/${props.idRetrabalho}`)
        .then((res) => {
            retrabalho.value = res.data;

            retrabalho.value.data = moment(retrabalho.value.data).format('YYYY-MM-DD');
            if (retrabalho.value.caso_teste?.caso_teste_id) {
                populaCasosTestePorId(retrabalho.value.caso_teste.caso_teste_id);
            }
        });

  //  LoaderStore.setHideLoader();
}
onMounted( async () => {
    await populaTiposRetrabalho();
    await populaAplicacoes();
    await populaUsuarios();
    await findCriticidades();
    if(props.idRetrabalho){
        await findRetrabalho();
        if (!retrabalho.value.caso_teste){
            retrabalho.value.caso_teste = {} as CasoTesteInterface;
        }
    }
    if (retrabalho.value.caso_teste_id) {
        await populaCasosTestePorId(retrabalho.value.caso_teste_id);

    }


});
watchEffect(()  => {
    if(retrabalho.value.aplicacao?.id){
        populaProjetos(retrabalho.value.aplicacao.id);
    }
});
const saveRetrabalho = async (submitEventPromise: SubmitEventPromise) => {
    const {valid, errors} = await submitEventPromise;
    if (!valid) return;
    retrabalho.value.titulo_caso_teste = retrabalho.value.caso_teste.titulo_caso_teste;
    retrabalho.value.requisito_caso_teste = retrabalho.value.caso_teste.requisito_caso_teste;
    retrabalho.value.cenario_caso_teste = retrabalho.value.caso_teste.cenario_caso_teste;
    retrabalho.value.teste_caso_teste = retrabalho.value.caso_teste.teste_caso_teste;
    retrabalho.value.resultado_esperado_caso_teste = retrabalho.value.caso_teste.resultado_esperado_caso_teste;
   // LoaderStore.setShowLoader();
    if(!retrabalho.value.id) {
        await axiosApi.post(`/retrabalhos/?idEquipe=${getIdEquipe()}`, retrabalho.value)
            .then((res) => {
                $toast.success("Retrabalho inserido com sucesso!");
                window.location.href = `./show/${res.data.id}`;
            })
            .catch((error) => {
                $toast.error(error.response.data.message);
            })
    }else{
        await axiosApi.put(`/retrabalhos/${retrabalho.value.id}?idEquipe=${getIdEquipe()}`, retrabalho.value)
            .then((res) => {
                $toast.success("Retrabalho alterado com sucesso!");
                window.location.href = `../show/${res.data.id}`;
            })
            .catch((error) => {
                $toast.error(error.response.data.message);
            })
    }
  //  LoaderStore.setHideLoader();
}

</script>

<template>
    <v-form ref="form" validate-on="blur" @submit.prevent="saveRetrabalho">
        <div class="row">
            <div class="col-md-6 border-e-sm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                             <v-combobox
                                v-model="retrabalho.tipo_retrabalho"
                                @update:modelValue="retrabalho.tipo_retrabalho_id = retrabalho.tipo_retrabalho.id"
                                label="Tipo de retrabalho"
                                :rules="[
                                        value => !retrabalho.tipo_retrabalho ? 'Selecione um tipo de retrabalho' : true
                                     ]"
                                :items="listaTiposRetrabalho"
                                variant="solo"
                                :return-object="true"
                                item-title="descricao"
                                item-value="id"
                                id="_tipo_retrabalho"
                                name="_tipo_retrabalho"
                            >
                            </v-combobox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <v-combobox
                                v-model="retrabalho.usuario"
                                label="Desenvolvedor"
                                :items="listaUsuarios"
                                @update:modelValue="retrabalho.usuario_id = retrabalho.usuario.id"
                                variant="solo"
                                :return-object="true"
                                :rules="[
                                        value => !retrabalho.usuario ? 'Selecione um usuário' : true
                                     ]"
                                item-title="name"
                                item-value="id"
                                id="_usuario"
                                name="_usuario"
                            >
                            </v-combobox>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <v-combobox
                                v-model="retrabalho.aplicacao"
                                label="Aplicação"
                                :items="listaAplicacoes"
                                @update:modelValue="retrabalho.aplicacao_id = retrabalho.aplicacao.id"
                                variant="solo"
                                :return-object="true"
                                item-title="nome"
                                item-value="id"
                                :rules="[
                                        value => !retrabalho.aplicacao ? 'Selecione uma aplicação' : true
                                     ]"
                            >
                            </v-combobox>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <v-combobox
                                v-model="retrabalho.projeto"
                                label="Projeto"
                                :items="listaProjetos"
                                @update:modelValue="retrabalho.projeto_id = retrabalho.projeto.id"
                                variant="solo"
                                :return-object="true"
                                item-title="nome"
                                item-value="id"
                                :disabled="retrabalho.aplicacao === null"
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
                                :rules="[
                                        value => !retrabalho.data ? 'Preencha a data.' : true
                                     ]"
                            />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                           <TFieldTarefas :key="retrabalho.tarefa?.tarefa" v-model="retrabalho.tarefa_id" :tarefa="retrabalho.tarefa?.tarefa" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <v-combobox
                                v-model="retrabalho.criticidade"
                                label="Criticidade"
                                :items="listaCriticidades"
                                variant="solo"
                                :rules="[
                                        value => !retrabalho.criticidade ? 'Selecione uma criticidade.' : true
                                     ]"
                                :return-object="false"
                                item-title="name"
                                item-value="value"
                            >
                            </v-combobox>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <v-autocomplete
                                v-model="casoTeste"
                                label="Caso de teste"
                                :items="listaCasosTeste"
                                @update:modelValue="() => {
                                    retrabalho.caso_teste_id = casoTeste?.id;
                                    retrabalho.caso_teste = casoTeste ?? {} as CasoTesteInterface;
                                }"
                                variant="solo"
                                return-object
                                :no-data-text="noDataText"
                                hint="Digite pelo menos 3 letras para para começar a filtrar"
                                item-title="titulo_caso_teste"
                                item-value="id"
                                :clearable="true"
                                @click:clear="retrabalho.caso_teste = {} as CasoTesteInterface"
                                @update:search="populaCasosTeste"
                                v-if="retrabalho.tipo_retrabalho?.tipo === TipoRetrabalhoEnum.FUNCIONAL"
                                :rules="[
                                        (value) => {
                                            if(retrabalho.tipo_retrabalho?.tipo === TipoRetrabalhoEnum.FUNCIONAL &&
                                                (!retrabalho.caso_teste?.id && (
                                                    !retrabalho.caso_teste.teste_caso_teste ||
                                                    !retrabalho.caso_teste.cenario_caso_teste ||
                                                    !retrabalho.caso_teste.requisito_caso_teste ||
                                                    !retrabalho.caso_teste.resultado_esperado_caso_teste ||
                                                    !retrabalho.caso_teste.titulo_caso_teste))){
                                                return 'Selecione um caso de teste';
                                            }
                                            return true;
                                        }
                                     ]"
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
                                :rules="[
                                        value => !retrabalho.descricao ? 'Digite uma descrição.' : true
                                     ]"
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
                                :loading="LoaderStore.showLoader"
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
                    :retrabalho="retrabalho"
                    :key="retrabalho.caso_teste.id"
                    v-if="retrabalho.tipo_retrabalho?.tipo === TipoRetrabalhoEnum.FUNCIONAL"
                />
            </div>
        </div>

    </v-form>
</template>

<style scoped>
.border-right{
    border-right: 1px solid #000;
}
</style>
