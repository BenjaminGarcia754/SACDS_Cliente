<?php

require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class CitaAPI
{
    private Client $client;
    private string $baseUrl = 'https://benja.ag-dev.com.mx/SACDS/api/Cita/';
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://benja.ag-dev.com.mx/SACDS/api/Cita/',
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

    public function obtenerCitasDiaActual() : mixed {
        try {
            $url = $this->baseUrl . 'GetCitasCurrentDay';
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

    public function toArray(Cita $cita):array{
        return [
            'id' => $cita->id,
            'idDonador' => $cita->idDonador,
            'idTipoDonacion' => $cita->idTipoDonacion,
            'idDonacionUrgente' => $cita->idDonacionUrgente,
            'fechaDonacion' => $cita->fechaDonacion->format(DateTime::ATOM),
            'diasReposo' => $cita->diasReposo
        ];
    }

    public function crearCita(Cita $cita) {
        try {
            $cita->id = 0;
            $cit = $this->toArray($cita);
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
            $cit = $this->toArray($cita);
            $url = $this->baseUrl . 'UpdateCita';
            
            $response = $this->client->put($url, [
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
