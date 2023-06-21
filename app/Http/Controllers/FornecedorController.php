<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Fornecedor;
use App\Models\PessoaFisica;
use Illuminate\Http\Request;
use App\Models\PessoaJuridica;
use App\Services\BreadcrumbService;
use App\Services\FornecedorService;

class FornecedorController extends Controller
{

    protected $breadcrumbService, $service;
    /**
     * method constructor .   
     */
    public function __construct(
        BreadcrumbService $breadcrumbService, 
        FornecedorService $service 
    ) {
        $this->breadcrumbService = $breadcrumbService;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $return  = $this->breadcrumbService->generate('fornecedor.index');
		return view('agenteContratacao.fornecedor.index', ['breadcrumbs'=> $return['data']])
            ->with('fornecedores', Fornecedor::orderBy('updated_at', 'desc')->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $return  = $this->breadcrumbService->generate('fornecedor.create');
        return view('agenteContratacao.fornecedor.create', ['breadcrumbs'=> $return['data']])
            ->with('estados', array_column(Estado::select('sigla', 'nome')->orderBy('nome', 'asc')->get()->toArray(), 'nome', 'sigla'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cpf_cnpj'      =>'required|string|between:11,18', // se 11 cpf ou 14 cnpj max 18 pois pode incluir pontos 
            'razaoSocial'   =>'required|string',
            'endereco'      =>'required|string',
            'cidade'        =>'required|string',
            'estado'        =>'required|string|size:2',
            'cep'           =>'string|nullable|max:9',
            'representante' =>'string|nullable',
        ]);

        $return = $this->service->store($request->all());
        if ($return['situacao']){
            $fornecedor = $return['objectOrError'];
            unset($return['objectOrError']);
            return redirect()->route('fornecedor.show', $fornecedor->uuid)->with($return);
        } else {
            unset($return['objectOrError']);
            return redirect()->back()->withInput()->with($return);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor)
    {
        $parameters = [ 
            'fornecedor.show' => ['parameters' => ['fornecedor' => $fornecedor->uuid,]],
        ]; 
        $return  = $this->breadcrumbService->generateWithParam('fornecedor.show', $parameters);
        return view('agenteContratacao.fornecedor.show', ['breadcrumbs'=> $return['data']])
            ->with('estados', Estado::select('sigla as badega', 'nome')->orderBy('nome', 'asc')->get())
            ->with('fornecedor', $fornecedor);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fornecedor $fornecedor)
    {
        $parameters = [ 
            'fornecedor.edit' => ['parameters' => ['fornecedor' => $fornecedor->uuid,]],
        ]; 
        $return  = $this->breadcrumbService->generateWithParam('fornecedor.edit', $parameters);
        return view('agenteContratacao.fornecedor.edit', ['breadcrumbs'=> $return['data']])
            ->with('estados', Estado::select(['sigla', 'nome'])->orderBy('nome', 'asc')->get()->toArray())
            ->with('fornecedor', $fornecedor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $this->validate($request, [
            'cpf_cnpj'      =>'required|string|between:11,18', // se 11 cpf ou 14 cnpj max 18 pois pode incluir pontos 
            'razao_social'  =>'required|string',
            'endereco'      =>'required|string',
            'cidade'        =>'required|string',
            'estado'        =>'required|string|size:2',
            'cep'           =>'string|nullable|max:9',
            'representante' =>'string|nullable',
        ]);

        $return = $this->service->update($request->all(), $fornecedor);
        if ($return['situacao']){
            unset($return['objectOrError']);
            return redirect()->route('fornecedor.show', $fornecedor->uuid)->with($return);
        } else {
            unset($return['objectOrError']);
            return redirect()->back()->withInput()->with($return);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $return = $this->service->destroy( $fornecedor);
        if ($return['situacao']){
            return redirect()->route('fornecedor.index')->with($return);
        } else {
            unset($return['objectOrError']);
            return redirect()->back()->withInput()->with($return);
        }
    }
    
    /**
    * Retorno uma razão social ou nome do fornecedo e o UUId da entidade Fornecedor, usando como parâmetro de busca o cpf_cnpj
    *
    * @param  Request  $request
    * @return \Illuminate\Http\Response
    */
   public function getFornecedor(Request $request)
   {
       $cpf_cnpj = preg_replace("/[^0-9]/", "", $request->cpf_cnpj);
       if (strlen($cpf_cnpj) === 11) {
           $fornecedor = PessoaFisica::where('cpf', '=', $request->cpf_cnpj)->first();
           if ($fornecedor) 
               return response()->json(['fornecedor' => $fornecedor->nome, 'uuid' => $fornecedor->fornecedor->uuid]); // retorna o uuid de Fornecedor
       } elseif (strlen($cpf_cnpj) === 14) {
           $fornecedor = PessoaJuridica::where('cnpj', '=', $request->cpf_cnpj)->first();
           if ($fornecedor)
               return response()->json(['fornecedor' => $fornecedor->razao_social, 'uuid' => $fornecedor->fornecedor->uuid]); // retorna o uuid de Fornecedor
       }
       return response()->json(['fornecedor' => true]);
   }
}
