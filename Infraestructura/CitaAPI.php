<?php

require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class CitaAPI
{
    private Client $client;
    private string $baseUrl = 'https://localhost:7290/api/Cita/';
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://localhost:7290/api/Cita/',
            'verify' => false, // Desactiva la verificación de SSL
        ]);
        
    }

    public function obtenerCitas(){
        try {
            $url = $this->baseUrl . 'GetCitas';
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function obtenerCita(int $id){
        try {
            $url = $this->baseUrl . 'GetCita/' . $id;
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public  function obtenerCitaPorDonador(int $id): mixed{
        try {
            $url = $this->baseUrl . 'GetCitasDonador/' . $id;
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
    public function crearCita(Cita $cita) {
        try {
            $cit = $cita->toArray(); // Verifica que esto devuelva un arreglo asociativo con los datos de la cita
            $url = $this->baseUrl . 'AddCita';
            
            $response = $this->client->post($url, [
                'json' => $cit, // Envía todo el arreglo como JSON
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);
    
            $status = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return [
                'result' => $result,
                'status' => $status
            ];
        } catch (RequestException $e) {
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
    

    public function editarCita(Cita $cita){
        try {
            $url = $this->baseUrl . 'UpdateCita'; //modificar
            $response = $this->client->put($url, ['json' => $cita]);
            return json_decode($response->getBody());
        }catch (RequestException $e){
            return $e->getMessage();
        }
    }

    public function eliminarCita(int $id){
        try {
            $url = $this->baseUrl . 'DeleteCita' . $id;
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
