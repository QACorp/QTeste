import { reactive } from 'vue'

export const LoaderStore = reactive({
    showLoader: false,
    contLoader: 0,
    setShowLoader() {
        this.contLoader++;
        this.showLoader = true;
    },
    setHideLoader() {
        if(this.contLoader > 0){
            this.contLoader--;
        }
        if(this.contLoader <= 0){
            this.contLoader = 0;
            this.showLoader = false;
        }
    }

})
