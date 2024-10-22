<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class CitaAPI
{
    private Client $client;
    private string $baseUrl = 'https://api.chesseguro.com';
    public function __construct(){
        $this->client = new Client();
    }

    public function obtenerCitas(){
        try {
            $url = $this->baseUrl . '/api/Citas'; //Cambiar la ruta del api
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function obtenerCita(int $id){
        try {
            $url = $this->baseUrl . '/api/Citas/' . $id;
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function crearCita(Cita $cita){
        try {
            $url = $this->baseUrl . '/api/Citas';//modificar
            $response = $this->client->post($url, ['json' => $cita]);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function editarCita(Cita $cita){
        try {
            $url = $this->baseUrl . '/api/Citas'; //modificar
            $response = $this->client->put($url, ['json' => $cita]);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function eliminarCita(int $id){
        try {
            $url = $this->baseUrl . '/api/Citas/' . $id;
            $response = $this->client->delete($url);
            if($response->getStatusCode() == 204){
                return true;
            }else{
                return false;
            }
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

}
