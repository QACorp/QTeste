<script setup lang="ts">
import {CasoTesteInterface} from "../Interfaces/CasoTeste.interface";
import {getError, hasError} from "../../../../../../resources/js/ErrorHelper";
import {watch, watchEffect} from "vue";
import {types} from "sass";
import Boolean = types.Boolean;
import {RetrabalhoInterface} from "../Interfaces/Retrabalho.interface";

const props = defineProps({
  retrabalho: {
    type: Object as () => RetrabalhoInterface,
    required: true
  }
});
const casoTeste = defineModel<CasoTesteInterface>();

const isDisable = ():boolean => {
    return (casoTeste.value && props.retrabalho.caso_teste_id != null);
}

</script>

<template>
    <div class="row">
        <label class="ml-3">Informações do Caso de Teste</label>
        <div class="col-md-12">
            <div class="form-group">
                <v-text-field
                    :disabled="isDisable()"
                    v-model="casoTeste.titulo_caso_teste"
                    label="Título"
                    name="titulo_caso_teste"
                    id="titulo_caso_teste"
                    :rules="[
                               value => props.retrabalho.caso_teste_id == null && !casoTeste.titulo_caso_teste ? 'Digite o titulo' : true
                            ]"
                ></v-text-field>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <v-text-field
                    v-model="casoTeste.requisito_caso_teste"
                    :disabled="isDisable()"
                    label="Requisito"
                    name="requisito_caso_teste"
                    id="requisito_caso_teste"
                    :rules="[
                               value => props.retrabalho.caso_teste_id == null && !casoTeste.requisito_caso_teste ? 'Descreva o requisito.' : true
                            ]"
                ></v-text-field>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <v-textarea
                    v-model="casoTeste.cenario_caso_teste"
                    :disabled="isDisable()"
                    label="Cenário"
                    name="cenario_caso_teste"
                    id="cenario_caso_teste"
                    :rules="[
                               value => props.retrabalho.caso_teste_id == null && !casoTeste.cenario_caso_teste ? 'Descreva o cenário' : true
                            ]"
                ></v-textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <v-textarea
                    v-model="casoTeste.teste_caso_teste"
                    label="Teste"
                    :disabled="isDisable()"
                    name="teste_caso_teste"
                    id="teste_caso_teste"
                    :rules="[
                               value => props.retrabalho.caso_teste_id == null && !casoTeste.teste_caso_teste ? 'Digite o teste' : true
                            ]"
                ></v-textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <v-textarea
                    v-model="casoTeste.resultado_esperado_caso_teste"
                    :disabled="isDisable()"
                    label="Resultado esperado"
                    name="resultado_esperado_caso_teste"
                    id="resultado_esperado_caso_teste"
                    :rules="[
                               value => props.retrabalho.caso_teste_id == null && !casoTeste.resultado_esperado_caso_teste ? 'Digite um resultado esperado' : true
                            ]"
                ></v-textarea>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
