import {TipoRetrabalhoInterface} from "./TipoRetrabalho.interface";
import {AplicacaoInterface} from "./Aplicacao.interface";
import {ProjetoInterface} from "./Projeto.interface";
import {UsuarioInterface} from "./Usuario.interface";

export interface RetrabalhoInterface {
    id:number,
    descricao: string,
    data: string,
    motivo_exclusao: string,
    numero_tarefa: number,
    id_tipo_retrabalho: number,
    id_usuario_criador: number,
    id_usuario: number,
    id_projeto: number,
    id_aplicacao: number,
    id_caso_teste: number,
    tipo_retrabalho: TipoRetrabalhoInterface | null,
    aplicacao: AplicacaoInterface | null,
    projeto: ProjetoInterface | null,
    usuario: UsuarioInterface | null

}
