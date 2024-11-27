<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DonacionUrgenteAPI
{
    private Client $client;
    private string $baseUrl = 'https://benja.ag-dev.com.mx/SACDS/api/DonacionUrgente/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://benja.ag-dev.com.mx/SACDS/api/DonacionUrgente/',
            'verify' => false, // Desactiva la verificación de SSL
        ]);
    }

    public function obtenerDonacionesUrgentes(){
        try {
            $url = $this->baseUrl . 'GetDonacionesUrgentes';
            
            $response = $this->client->request('GET', $url);
            $status = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            
            return [
                'result' => $result,
                'status' => $status
            ];

        }catch (RequestException $e){
            if ($e->hasResponse()) {
                $status = $e->getResponse()->getStatusCode();
                $errorMessage = $e->getResponse()->getBody()->getContents();
                return [
                    'result' => json_decode($errorMessage),
                    'status' => $status,
                ];
            }
            return [
                'result' => null,
                'status' => 500,
            ];
        }
    }

    public function obtenerDonacionUrgente(int $id){
        try {
            $url = $this->baseUrl . 'DonacionUrgente/' . $id;
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function registrarDonacionUrgente(DonacionUrgente $donacion){
        try {
            $url = $this->baseUrl . '/api/DonacionUrgente';//modificar
            $response = $this->client->post($url, ['json' => $donacion]);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function actualizarDonacionUrgente(DonacionUrgente $donacion){
        try {
            $url = $this->baseUrl . '/api/DonacionUrgente';
            $response = $this->client->put($url, ['json' => $donacion]);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function eliminarDonacionUrgente(int $id){
        try {
            $url = $this->baseUrl . '/api/DonacionUrgente/' . $id;
            $response = $this->client->delete($url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }
}