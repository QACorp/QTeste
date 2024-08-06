<script setup lang="ts">
import {defineProps, ref, watch} from "vue";
import {AlocacaoInterface} from "../Interfaces/Alocacao.interface";
import {axiosApi} from "../../../../../../resources/js/app";
import {getIdEquipe} from "../../../../../../resources/js/APIUtils/BaseAPI";
import {UsuarioInterface} from "../../../../Retrabalhos/Views/Vue/Interfaces/Usuario.interface";
const props = defineProps({
    alocacaoId: {
        type: Number,
        required: true
    }
})
const dialog = ref<boolean>(false);
const alocacao = ref<AlocacaoInterface>({} as AlocacaoInterface);
const usuarios = ref<UsuarioInterface[]>(null);
watch(dialog, (newValue) => {
    if(dialog){
        axiosApi.get(`gestao-equipe/alocacao/${props.alocacaoId}?idEquipe=${getIdEquipe()}`)
            .then(response => {
                alocacao.value = response.data;
            })
            .catch(error => {
                console.log(error)
            })
    }
});

const findUsers = () => {
    axiosApi.get(`gestao-equipe/alocacao/usuarios-disponiveis/${alocacao.value.inicio}/${alocacao.value.termino}/?idEquipe=${getIdEquipe()}`)
        .then(response => {
            usuarios.value = response.data;
            usuarios.value.push(alocacao.value.user as UsuarioInterface);
        })
        .catch(error => {
            console.log(error)
        })
}
</script>

<template>
    <v-btn class="p-2" size="sm" variant="tonal"  @click="dialog = true" stacked>
        <v-icon size="sm">mdi-pencil</v-icon>
    </v-btn>
    <v-dialog
        v-model="dialog"
        min-width="50%"
        persistent
        scroll-strategy="none"
    >
        <v-card >
            <v-toolbar title="Alterar alocação">
                <v-btn
                    icon="mdi-close"
                    @click="dialog = false"
                ></v-btn>
            </v-toolbar>
            <v-card-text>
                <form >
                    <v-row dense>
                        <v-col cols="12" sm="5" md="5">
                            <v-text-field
                                type="date"
                                v-model="alocacao.inicio"
                                label="Início"
                                size="large"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="5" md="5">
                            <v-text-field
                                type="date"
                                v-model="alocacao.termino"
                                label="Término"
                                size="large"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="1" md="1">
                            <v-btn @click="findUsers()" size="x-large" variant="tonal" class="py-3">
                                <v-icon >mdi-account-search</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" sm="3" md="3" v-if="usuarios">
                            <input type="hidden" :value="alocacao.user?.id" name="usuario_id" />
                            <v-select
                                v-model="alocacao.user"
                                :items="usuarios"
                                item-title="name"
                                item-value="id"
                                label="Usuário"
                                required
                            ></v-select>
                        </v-col>
                    </v-row>
                </form>
            </v-card-text>
            <v-card-actions>

            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>

</style>
