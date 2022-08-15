<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Exception;
use GuzzleHttp\Client;
use Guzzle\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

Class MercadoTokenAction{

    public function execute(array $params)
    {
        // dd($params);
            try {
                /* Criação do objeto cliente */
                $guzzle = new Client([
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    /* Desativar SSL*/
                    'verify' => false
                ]);
                /* Requisição POST*/
                $response = $guzzle->request('POST', config('mercadoUrl.token'),
                    array(
                        'form_params' => array(
                            'grant_type' => 'authorization_code',
                            'client_id' =>  $params['client_id'],
                            'client_secret' =>  $params['client_secret'],
                            'code' => $params['authorization'],
                            'redirect_uri' => $params['url']
                        )
                    )
                );

                /* Recuperar o corpo da resposta da requisição */
                $body = $response->getBody();

                /* Acessar as dados da resposta - JSON */
                $contents = $body->getContents();

                // dd($token->access_token);
                return $contents;

            } catch (GuzzleException $e) {
            }
    }
}
