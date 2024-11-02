<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DonacionUrgenteAPI
{
    private Client $client;
    private string $baseUrl = 'http://localhost:5220/api/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://localhost:7290/api/',
            'verify' => false, // Desactiva la verificación de SSL
        ]);
    }

    public function obtenerDonacionesUrgentes(){
        try {
            $url = $this->baseUrl . 'DonacionUrgente/GetDonacionesUrgentes'; //Cambiar la ruta del api
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
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