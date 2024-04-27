<script setup lang="ts">
import {PropType, ref} from "vue";
import {CasoTesteInterface} from "../Interfaces/CasoTeste.interface";
import {getError, hasError} from "../../../../../../resources/js/ErrorHelper";

const props = defineProps({
    casoTeste: {
        type: {} as PropType<CasoTesteInterface>,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});
const casoTeste = defineModel<CasoTesteInterface>()
//const casoTeste = ref<CasoTesteInterface>(props.casoTeste);
const isDisable = () => {
    return casoTeste.value.id_caso_teste !== null;
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
                    :error="hasError('titulo_caso_teste', errors)"
                    :error-messages="getError('titulo_caso_teste', errors)"
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
                    :error="hasError('requisito_caso_teste', errors)"
                    :error-messages="getError('requisito_caso_teste', errors)"
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
                    :error="hasError('cenario_caso_teste', errors)"
                    :error-messages="getError('cenario_caso_teste', errors)"
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
                    :error="hasError('teste_caso_teste', errors)"
                    :error-messages="getError('teste_caso_teste', errors)"
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
                    :error="hasError('resultado_esperado_caso_teste', errors)"
                    :error-messages="getError('resultado_esperado_caso_teste', errors)"
                ></v-textarea>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
