<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class EnderecoController extends Controller
{
    /**
     * Retorna o endereço tendo como parâmetro de busca o CEP. 
     *
     * @param mixed $cep
     * 
     * @return [type]
     * 
     */
    public function show($cep)
    {
        $cep = preg_replace("/[^0-9]/", "", $cep);
        // composer require guzzlehttp/guzzle
        if (strlen($cep) === 8) {
            $client = new Client();
            $response = $client->request('GET', 'viacep.com.br/ws/'.$cep.'/json/');
            return response($response->getBody());
        } else{
            return response(true);
        } 
    }
}
