import {TipoRetrabalhoInterface} from "./TipoRetrabalho.interface";
import {AplicacaoInterface} from "./Aplicacao.interface";
import {ProjetoInterface} from "./Projeto.interface";
import {UsuarioInterface} from "./Usuario.interface";
import {CasoTesteInterface} from "./CasoTeste.interface";

export interface RetrabalhoInterface {
    id:number,
    descricao: string,
    data: string,
    motivo_exclusao: string,
    numero_tarefa: number,
    tipo_retrabalho_id: number,
    usuario_criador: number,
    usuario_id: number,
    projeto_id: number,
    aplicacao_id: number,
    caso_teste_id: number,
    criticidade: string,
    tipo_retrabalho: TipoRetrabalhoInterface | null,
    aplicacao: AplicacaoInterface | null,
    projeto: ProjetoInterface | null,
    usuario: UsuarioInterface | null,
    caso_teste: CasoTesteInterface | null

}
