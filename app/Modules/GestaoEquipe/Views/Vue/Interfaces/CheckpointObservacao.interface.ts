import {ProjetoInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Projeto.interface";
import {UsuarioInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {TarefaInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Tarefa.interface";

export default interface CheckpointObservacaoInterface {
    id: number,
    projeto_id: number,
    criador_user_id: number,
    user_id: number,
    descricao: string,
    data: string,
    tarefa_id: number,
    tarefa: TarefaInterface,
    projeto: ProjetoInterface,
    user: UsuarioInterface,
    criador: UsuarioInterface,
    tipo: string
}
