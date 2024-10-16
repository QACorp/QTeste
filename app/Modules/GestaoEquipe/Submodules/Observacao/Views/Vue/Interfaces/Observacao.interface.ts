import {ProjetoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Projeto.interface";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {AlocacaoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Alocacao.interface";
import {TarefaInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Tarefa.interface";

export default interface ObservacaoInterface {
    id: number,
    criador_user_id: number,
    user_id: number,
    observacao: string,
    data: string,
    user: UsuarioInterface,
    criador: UsuarioInterface
}
