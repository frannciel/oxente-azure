<?php

namespace App\Services;

use Exception;
use App\Models\Item;
use App\Models\Requisicao;
use App\Traits\StringToTrait;
use App\Models\UnidadeAdministrativa;

class RequisicaoService
{
    use StringToTrait;
    /**
     * Função que salva a requisição na base de dados
     *
     * @param Array  $data  
     * @param \App\Requisicao  $requisicao   
     */
    public function store(array $request)
    {
        try{

            $requisicao = Requisicao::create([
                'numero'        => Requisicao::where('ano', date('Y'))->max('numero') + 1,// Retona o número da ultima requisção e acarescenta mais um
                'ano'           => date('Y'),
                'tipo'          => $request['tipo'],
                'prioridade'    => $request['prioridade'],
                'renovacao'     => $request['renovacao'],
                'capacitacao'   => $request['capacitacao'],
                'pac'           => $request['pac'],
                'metas'         => $request['metas'],
                'descricao'     => $request['descricao'],
                'justificativa' => $request['justificativa'],
                'data'          => $request['previsao'],
                'requisitante_id' => UnidadeAdministrativa::findByUuid($request['requisitante'])->id
            ]);

            return [
                'status' => true,
                'mensagem' => 'Requisicão criado com sucesso!',
                'objectOrError' => $requisicao
            ];
        } catch (Exception $e) {
            return [
               'status' => false,
               'message' => 'Ao cadastrar a requisição, tente novamente ou contate o administrador',
               'objectOrError' => $e
            ];
        }
    }
    
    /**
     * Registra na base de dados as alteração em uma requisiação específica
     *
     * @param array $request
     * @param Requisicao $requisicao
     * @return array
     */
    public function update(array $request, Requisicao $requisicao)
    {
        try{

            $requisicao->descricao      = $request['descricao'];
            $requisicao->justificativa  = $request['justificativa'];
            $requisicao->prioridade     = $request['prioridade'];
            $requisicao->tipo           = $request['tipo'];
            $requisicao->renovacao      = $request['renovacao'];
            $requisicao->capacitacao    = $request['capacitacao'];
            $requisicao->pac            = $request['pac'];
            $requisicao->data           = $request['previsao'];
            $requisicao->metas          = $request['metas'];
            $requisicao->requisitante()->dissociate(); // remove todas as relações
            $requisicao->requisitante()->associate(UnidadeAdministrativa::findByUuid($request['requisitante'])); // refaz as relaçoes
            $requisicao->save();

            return [
                'situacao' => true,
                'mensagem' => 'Requisicão alterada com sucesso!',
                'data' => $requisicao
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ao editar a requisição, tente novamente ou contate o administrador',
               'objectOrError' => $e
            ];
        }
    }    

    /**
     * Remove uma cotação específica
     * 
     * @param Requisicao $requisicao 
     * @return type
     */
    public function destroy(Requisicao $requisicao)
    {
        try {
            
            $requisicao->delete();

            return [
                'situacao' => true,
                'mensagem' => 'Requisicao Excluida  com sucesso',
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ao excluir a requisicao, tente novamente ou contate o administrador',
               'objectOrError' => $e
            ];
        }
    }

    public function duplicarItens(array $request)
    {
        try {
            
            $itens = $request['itens'];
            if (empty($itens)) {
                    abort(
                        redirect()
                        ->route('requisicao.show', $request['requisicao'])
                        ->with(['codigo' => 500, 'mensagem' => 'Nenhum item duplicado, selecione um ou mais itens e tente novamente.'])
                        ->withInput()
                    ); 
            } else {
                $requisicao = Requisicao::findByUuid($request['requisicao']);
                foreach ($itens as  $uuid) {
                    $item = Item::findByUuid($uuid);
                    if ($requisicao->uuid == $item->requisicao->uuid) { // verifica se o item pertence a requisição
                       $requisicao->itens()->create([
                            'numero'        => $requisicao->itens()->max('numero')+1, // este número indicara itens mesclados nas  licitcaoes, eles não pertencem a nenhuma requisicão
                            'quantidade'    => $item['quantidade'],
                            'codigo'        => $item['codigo'],
                            'objeto'        => $item['objeto'],
                            'descricao'     => $item['descricao'],
                            'unidade_id'    => $item['unidade_id'],
                        ]);
                    }
                }   
            }

            return [
                'situacao' => true,
                'mensagem' => 'Itens duplicado com sucesso',
                'objectOrError' => $itens
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ocorreu durante a tentiva duplicar itens',
               'objectOrError' => $e
            ];
        }
    }

    public function deleteItens(array $request)
    {
        try {
            
            foreach ($request['itens'] as  $uuid) {
                $item = Item::findByUuid($uuid);
                if ($request['requisicao'] == $item->requisicao->uuid) { // verifica se o item pertence a requisição
                    if (!$item->licitacao) { // verifica se o item não está relacionado a uma licitação
                        $item->delete();
                    }
                }
            }
            $this->ordenarItens(Requisicao::findByUuid($request['requisicao']));

            return [
                'situacao' => true,
                'mensagem' => 'Itens duplicado com sucesso',
                'objectOrError' => null
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ocorreu durante a tentiva remover itens',
               'objectOrError' => $e
            ];
        }
    }

    public function ordenarItens(Requisicao $requisicao)
    {
        try {
            
            $numero = 1;
            foreach ($requisicao->itens()->orderBy('numero', 'asc')->get() as $item) {
                $item->numero = $numero;
                $item->save();
                $numero += 1;
            }

            return [
                'situacao' => true,
                'mensagem' => 'Itens da requisição ordenado com sucesso!',
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ocorreu durante a tentiva de ordenação  dos itens da requisição',
               'objectOrError' => $e
            ];
        }
    }
}