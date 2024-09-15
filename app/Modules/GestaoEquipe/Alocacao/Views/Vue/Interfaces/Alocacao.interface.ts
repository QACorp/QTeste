import {TarefaInterface} from "./Tarefa.interface";

export interface AlocacaoInterface{
    id: number,
    projeto_id: number,
    user_id: number,
    empresa_id: number,
    equipe_id: number,
    inicio: string,
    termino: string,
    concluida: string,
    tarefa_id: number,
    natureza: string,
    observacao: string,
    tarefa: TarefaInterface,
    "user": {
        id: number,
        name: string,
        email:string,
        empresa_id: number,
        empresa: {
            id: number,
            nome: string,
            usuarios: number
        },
        active: boolean
    },
    equipe: {
        id: 1,
        nome: "COMAR",
        empresa_id: 1,
        users: null,
        empresa: null
    },
    projeto: {
        id: number,
        nome: string,
        descricao: string,
        inicio: string,
        termino: string,
        aplicacao_id: number,
        aplicacao: {
            id: number,
            nome: string,
            descricao: string,
        }
    }
}
