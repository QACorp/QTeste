export interface ProjetoInterface{
    id:number,
    nome: string,
    inicio: string,
    termino: string,
    aplicacaoId: number,
    aplicacao: {
        id: number,
        nome: string,
        descricao: string,

    }
}
