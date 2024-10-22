<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TipoDonacionAPI
{
    private Client $client;
    private string $baseUrl = 'https://api.tipodonacion.com';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function obtenerTipoDonaciones()
    {
        try {
            $url = $this->baseUrl . '/api/tipodonacion';
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function obtenerTipoDonacion(int $idTipoDonacion){
        try {
            $url = $this->baseUrl . '/api/tipodonacion/' . $idTipoDonacion;
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function crearTipoDonacion(TipoDonacion $tipoDonacion){
        try {
            $url = $this->baseUrl . '/api/tipodonacion';
            $response = $this->client->post($url, []);
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function editarTipoDonacion(TipoDonacion $tipoDonacion){
        try {
            $url = $this->baseUrl . 'api/TipoDonacion';
            $response = $this->client->put($url, ['json' => $tipoDonacion]);
            return json_decode($response->getBody());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function eliminarTipoDonacion(int $idTipoDonacion){
        try {
            $url = $this->baseUrl . '/api/tipodonacion/' . $idTipoDonacion;
            $response = $this->client->delete($url);
            return json_decode($response->getBody());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}
