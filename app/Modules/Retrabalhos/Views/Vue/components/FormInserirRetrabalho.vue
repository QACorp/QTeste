<script setup lang="ts">
import {onMounted, PropType, ref, watchEffect} from "vue";
import {TipoRetrabalhoInterface} from "../Interfaces/TipoRetrabalho.interface";
import axios from "axios";
import {RetrabalhoInterface} from "../Interfaces/Retrabalho.interface";

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

const retrabalho = ref<RetrabalhoInterface>(props.retrabalho);
retrabalho.value.tipo_retrabalho = {} as TipoRetrabalhoInterface;
const tipoRetrabalho = ref<TipoRetrabalhoInterface>(retrabalho.value.tipo_retrabalho);
const populaTipoRetrabalho = async () => {
    await axios.get('consultas/tipos').then((res) => {
        listaTiposRetrabalho.value = res.data;
        if (retrabalho.value.id_tipo_retrabalho) {
            retrabalho.value.tipo_retrabalho =
                listaTiposRetrabalho.value.find((item: TipoRetrabalhoInterface) => item.id == retrabalho.value.id_tipo_retrabalho);
        }
    })
}
onMounted( () => {
    populaTipoRetrabalho();
});

</script>

<template>
    <form id="form-rework" :action="actionForm" method="POST">
        <input type="hidden" name="_token" :value="csrf">

        <div class="row">

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" :value="retrabalho.tipo_retrabalho.id" name="id_tipo_retrabalho" />
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
                            >
                            </v-combobox>
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
                            ></v-textarea>
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
                            ></v-text-field>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
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
    </form>
</template>

<style scoped>

</style>
