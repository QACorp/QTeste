export const hasError = (field:string, errors) => {
    return errors && errors[field] ? true : false;
}
export const getError = (field:string, errors) => {
    return errors && errors[field] ? errors[field][0] : [];
}
