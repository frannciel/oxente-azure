<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BreadcrumbService;

class LicitacaoController extends Controller
{

    protected $breadcrumbService;

    /**
     * method constructor .   
     */
    public function __construct(BreadcrumbService $breadcrumbService)
    {
        $this->breadcrumbService = $breadcrumbService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( )
    {
   /*      $parameters = [
            'requisicao.import' => ['parameters' => ['licitacao' => $licitacao->uuid ], 'title' =>  $licitacao->ordem],
        ]; */
        $parameters = [
            'requisicao.show' => ['parameters' => ['id' => 1, ], 'title' =>  '001/2023'],
            'requisicao.import' => ['parameters' => ['id' => 10, ],],
        ]; 

        $return  = $this->breadcrumbService->generateWithParam('requisicao.import', $parameters);
        $breadcrumbs =  $return['data'];

        return view('agenteContratacao.dashboard', compact('breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
