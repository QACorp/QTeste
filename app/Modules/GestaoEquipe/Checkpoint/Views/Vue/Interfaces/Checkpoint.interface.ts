import {ProjetoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Projeto.interface";
import {UsuarioInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {AlocacaoInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Alocacao.interface";
import {TarefaInterface} from "../../../../Alocacao/Views/Vue/Interfaces/Tarefa.interface";

export default interface CheckpointInterface {
    id: number,
    projeto_id: number,
    criador_user_id: number,
    equipe_id: number,
    user_id: number,
    alocacao_id: number,
    descricao: string,
    data: string,
    tarefa_id: number,
    tarefa: TarefaInterface,
    compareceu: boolean,
    projeto: ProjetoInterface,
    user: UsuarioInterface,
    criador: UsuarioInterface,
    alocacao: AlocacaoInterface
}
