<?php

namespace App\Services;

use Excel;
use Exception;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Fornecedor;
use App\Models\PessoaFisica;
use App\Models\PessoaJuridica;

class FornecedorService
{
    /**
     *  Salva uma novo fornecedor na base de dados
     *
     * @param array $request
     * @return [type]
     */
    public function store(array $request)
    {

        try{

            $cidade = Cidade::firstOrCreate([
                'nome' => $request['cidade'], 
                'estado_id'=> Estado::where('sigla', $request['estado'])->first()->id
            ]); 
           
            $pessoa = null;
            if(strlen(preg_replace("/[^0-9]/", "", $request['cpf_cnpj'])) == 11){
                $pessoa = $this->storePessoaFisica($request);
            } elseif (strlen(preg_replace("/[^0-9]/", "", $request['cpf_cnpj'])) == 14) {
                $pessoa = $this->storePessoaJuridica($request);
            }
            $fornecedor = $pessoa->fornecedor()->create([
                'endereco'      => $request['endereco'],
                'cep'           => $request['cep'],
                'cidade_id'     => $cidade->id,
            ]);
    
            return [
                'situacao' => true,
                'mensagem' => 'Novo fornecedor cadastrado com sucesso!',
                'objectOrError' => $fornecedor
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Fornecedor não cadastrado, tente novamente ou contate o administrador',
               'objectOrError' => $e
            ];
        }
    }

    /**
     * Registra na base de dados uma entidade pessoa física
     *
     * @param array $request
     * @return PessoaFisica
     * 
     */
    protected function storePessoaFisica(array $request): PessoaFisica
    {   
        return PessoaFisica::create([
            'cpf'    => $request['cpf_cnpj'],
            'nome'   => $request['razaoSocial']
        ]);
    }

    /**
     * Registra na base de dados uma entidade pessoa Jurídica
     *
     * @param array $request
     * @return PessoaJuridica
     */
    protected function storePessoaJuridica(array $request):PessoaJuridica
    {
        return PessoaJuridica::create([
            'cnpj'          => $request['cpf_cnpj'],
            'razao_social'  => $request['razaoSocial'],
            'representante' => $request['representante'],
        ]);

    }

    public function update(array $request, Fornecedor $fornecedor)
    {
        try{
            $cidade = Cidade::firstOrCreate([
                'nome' => $request['cidade'], 
                'estado_id' => Estado::where('sigla', $request['estado'])->first()->id
            ]); 
            $fornecedor->endereco       = $request['endereco'];
            $fornecedor->cep            = $request['cep'];
            $fornecedor->cidade_id      = $cidade->id;
            $fornecedor->save();
    
            if($fornecedor->fornecedorable_type =='Pessoa Física') {
                $PF = $fornecedor->fornecedorable;
                $PF->cpf    = $request['cpf_cnpj'];
                $PF->nome   = $request['razao_social'];
                $PF->save();
            } 
            if ($fornecedor->fornecedorable_type =='Pessoa Jurídica') {
                $PJ = $fornecedor->fornecedorable;
                $PJ->cnpj           = $request['cpf_cnpj'];
                $PJ->razao_social   = $request['razao_social'];
                $PJ->representante  = $request['representante'];
                $PJ->save();
            }
            return [
                'situacao' => true,
                'mensagem' => 'Fornecedor atualizado com sucesso!',
                'objectOrError' => $fornecedor
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Não foi possível alterar o fornecedor, tente novamente ou contate o administrador',
               'objectOrError' => $e
            ];
        }
    }

    public function default(array $data)
    {
        try{

            return [
                'situacao' => true,
                'mensagem' => 'Sucesso',
                'objectOrError' => $data
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ocorreu durante a execução',
               'objectOrError' => $e
            ];
        }
    }

    public function destroy(Fornecedor $fornecedor)
    {
        try {
            
            $fornecedor->fornecedorable()->delete(); // exclui pessoa física ou jurídica
            $fornecedor->delete();
            return [
                'situacao' => true,
                'mensagem' => 'Fornecedor Excluído com sucesso',
            ];
        } catch (Exception $e) {
            return [
               'situacao' => false,
               'mensagem' => 'Ao tentar excluir o Fornecedor, tente novamente ou contate o administrador',
               'objectOrError' => $e
            ];
        }
    }

    public function importar(array $data)
    {
        try{

            $dados = array_chunk(explode("&", substr($data['texto'],  0, -1)), 10);// remove o ultimo caracter e quebra a texto em celulas e organiza por linhas
            foreach ($dados as $valor) {
                $fornecedor = null;
                if(strlen(preg_replace("/[^0-9]/", "", trim($valor[0]))) == 11){
                    $fornecedor = PessoaFisica::firstOrCreate([
                        ['cpf'    => trim($valor[0])],
                        ['nome'   => trim($valor[1])]
                    ]);
                } elseif (strlen(preg_replace("/[^0-9]/", "", trim($valor[0]))) == 14){
                    $fornecedor = PessoaJuridica::firstOrCreate(
                        ['cnpj'         => trim($valor[0])],
                        ['razao_social' => trim($valor[1]), 'representante' => trim($valor[9])]
                    );
                    // atualiza o representante caso este esteja vazio
                    if ($fornecedor->representante == '') {
                        $fornecedor->representante = trim($valor[9]);
                        $fornecedor->save();
                    }
                }

                // realiza a validação de estado e realiza a consulta na base de dados retornando incosiste caso não encontrado
                $estado = null;
                if (strlen(trim($valor[5])) == 2) {
                    $estado = Estado::where('sigla', strtoupper(trim($valor[5])))->first();
                } elseif ($estado === null) {
                    $estado = Estado::where('nome', $valor[5])->first();
                } elseif ($estado === null) {
                    $estado = Estado::where('nome', 'Inconsistente')->first();
                }
                // consulta a cidade criando uma cidade caso esta não esteja presente na base de dados
                $cidade = Cidade::firstOrCreate(['nome' =>trim($valor[4]), 'estado_id'=> $estado->id]); 

                $fornec = $fornecedor->fornecedor;
                if ($fornec == null) {
                    $fornecedor->fornecedor()->updateOrCreate([
                        'endereco'      => trim($valor[2]),
                        'cep'           => trim($valor[3]),
                        'cidade_id'     => $cidade->id,
                        'email'         => trim($valor[6]),
                        'telefone_1'    => trim($valor[7]),
                        'telefone_2'    => trim($valor[8])
                    ]);
                } else {
                    $fornec->endereco   = trim($valor[2]);
                    $fornec->cep        = trim($valor[3]);
                    $fornec->cidade_id  = $cidade->id;
                    $fornec->email      = trim($valor[6]);
                    $fornec->telefone_1 = trim($valor[7]);
                    $fornec->telefone_2 = trim($valor[8]);
                    $fornec->save();
                }
            }
            return [
                'situacao' => true,
                'mensagem' => 'Fornecedor(es) cadastrado(s) com sucesso',
                'objectOrError' => $data
            ];
        } catch (Exception $e) {
            return [ 
                'situacao' => false, 
                'mensagem' => 'Ocorreu durante a execução', 
                'objectOrError' => $e 
            ];
        }
    }
}