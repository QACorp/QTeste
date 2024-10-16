import {ProjetoInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Projeto.interface";
import {UsuarioInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Usuario.interface";
import {TarefaInterface} from "../../../Submodules/Alocacao/Views/Vue/Interfaces/Tarefa.interface";

export default interface RelatorioRetrabalhoInterface {
    total_retrabalhos: number,
    total_tarefas: number,
    total_projetos: number,
}
