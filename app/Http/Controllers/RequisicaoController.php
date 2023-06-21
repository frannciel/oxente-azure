<?php

namespace App\Http\Controllers;

use App\Models\Requisicao;
use Illuminate\Http\Request;
use App\Services\BreadcrumbService;
use App\Services\RequisicaoService;

class RequisicaoController extends Controller
{

    protected $breadcrumbService, $service;
    /**
     * method constructor .   
     */
    public function __construct(BreadcrumbService $breadcrumbService, RequisicaoService $service)
    {
        $this->service = $service;
        $this->breadcrumbService = $breadcrumbService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $return  = $this->breadcrumbService->generate('requisicao.index');
        return view('requisitante.requisicao.index', ['breadcrumbs'=> $return['data']])
            ->with('requisicoes', Requisicao::orderBy('updated_at', 'desc')->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $return  = $this->breadcrumbService->generate('requisicao.create');
        return view('requisitante.requisicao.create',  ['breadcrumbs'=> $return['data']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'classificacao' => 'required|integer',
            'prioridade'    => 'required|integer',
            'renovacao'     => 'required|integer',
            'capacitacao'   => 'required|integer',
            'previsao'      => 'required|date_format:d/m/Y',
            'descricao'     => 'required|string',
            'justificativa' => 'nullable|string',
        ]);

        $return = $this->service->store($request->all());
        if ($return['situacao']){
            $requisicao = $return['objectOrError'];
            unset($return['objectOrError']);
            return redirect()->route('requisicao.show', $requisicao->uuid)->with($return);
        } else {
            return redirect()->back()->withInput()->with($return); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Requisicao $requisicao)
    {
        $return  = $this->breadcrumbService->generate('requisicao.show');
        return view('requisitante.requisicao.show', ['breadcrumbs'=> $return['data']])
            ->with('requisicao', $requisicao);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requisicao $requisicao)
    {
        $return  = $this->breadcrumbService->generate('requisicao.show');
        return view('requisitante.requisicao.edit', ['breadcrumbs'=> $return['data']])
            ->with('requisicao', $requisicao);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requisicao $requisicao)
    {
        $this->validate($request, [
            'classificacao' => 'required|integer',
            'prioridade'    => 'required|integer',
            'renovacao'     => 'required|integer',
            'capacitacao'   => 'required|integer',
            'previsao'      => 'nullable|date_format:d/m/Y',
            'descricao'     => 'required|string',
            'justificativa' => 'nullable|string',
            'requisitante'  => 'required|exists:requisitantes,uuid',
            'unidade'       => 'required|exists:unidades_administrativas,uuid',
        ]);

        $return = $this->service->update($request->all(), $requisicao);
        if ($return['situacao']){
            unset($return['objectOrError']);
            return redirect()->route('requisicao.show', $requisicao->uuid)->with($return);
        } else {
            return redirect()->back()->withInput()->with($return); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requisicao $requisicao)
    {
        $return = $this->service->destroy($requisicao);
        if ($return['situacao']){
            return redirect()->route('requisicao.index')->with($return); 
        } else {
            return redirect()->back()->withInput()->with($return);
        }
    }
}
