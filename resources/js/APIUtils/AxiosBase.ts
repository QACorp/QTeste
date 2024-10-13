import axios from "axios";
import {LoaderStore} from "@/GlobalStore/LoaderStore";

const AxiosApiConfig = {
    headers: {
        'Authorization': 'Bearer ' + document.querySelector("meta[name='api-token']")?.getAttribute('content')
    },
    baseURL: import.meta.env.VITE_API_URL
}
export const axiosApi = axios.create(AxiosApiConfig);
axiosApi.interceptors.request.use(function (config) {
    LoaderStore.setShowLoader();
    return config;
});
axiosApi.interceptors.response.use(function (response) {
    LoaderStore.setHideLoader();
    return response;
}, function (error) {
    LoaderStore.setHideLoader();
    return Promise.reject(error);
});
export const axiosApiWithoutLoader = axios.create(AxiosApiConfig);
axiosApiWithoutLoader.interceptors.request.use(function (config) {
    return config;
});
axiosApiWithoutLoader.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    return Promise.reject(error);
});

export const axiosWithoutLoader = axios.create();
axiosWithoutLoader.interceptors.request.use(function (config) {
    return config;
});
axiosWithoutLoader.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    return Promise.reject(error);
});


