<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Exception;
use GuzzleHttp\Client;
use Guzzle\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;

Class MercadoCategoryAction{

    public function execute(array $params)
    {
        $access = json_decode($params['access_token']);

            try {
                /* Criação do objeto cliente */
                $guzzle = new Client([
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Authorization' => 'Bearer ' . $access->access_token
                    ],
                    /* Desativar SSL*/
                    'verify' => false
                ]);
                /* Requisição POST*/
                $response = $guzzle->request('GET', config('mercadoUrl.categories'));

                /* Recuperar o corpo da resposta da requisição */
                $body = $response->getBody();

                /* Acessar as dados da resposta - JSON */
                $contents = $body->getContents();

                /* Converte o JSON em array associativo PHP */
                $token = json_decode($contents);
                // dd($token->access_token);
                return $token;

            } catch (GuzzleException $e) {
            }
    }
}
