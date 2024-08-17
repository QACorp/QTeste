import {defineProps} from "vue";

export const getIdEquipe = () => {
    return document.querySelector("meta[name='id-equipe']").getAttribute('content')
}

