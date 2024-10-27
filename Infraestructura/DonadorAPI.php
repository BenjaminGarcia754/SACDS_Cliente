<?php

require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DonadorAPI
{
    private Client $client;
    private string $baseUrl = 'http://localhost:5220/api/';
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://localhost:7290/api/',
            'verify' => false, // Desactiva la verificación de SSL
        ]);
        
    }

    public function obtenerDonadores(){
        try {
            $url = $this->baseUrl .'/donadores';
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
    public function obtenerDonador(int $id){
        try {
            $url = $this->baseUrl.'/donadores/'.$id;
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function registrarDonador(Donador $donador){
        try {
            $url = $this->baseUrl.'/donadores/';
            $response = $this->client->post( $url, ['json' => $donador]);
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function IniciarSesion(Donador $donador)
    {
        try {
            $url = $this->baseUrl . 'Donador/login';
            
            $response = $this->client->post($url, [
                'json' => (array) $donador,
                'verify' => false,
            ]);
    
            $statusCode = $response->getStatusCode();  // Captura el código de estado
            $data = json_decode($response->getBody()->getContents(), true);  // Decodifica el cuerpo JSON
            
            return [
                'status' => $statusCode,
                'data' => $data
            ];
    
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return [
                    'status' => $e->getResponse()->getStatusCode(),
                    'data' => $e->getResponse()->getReasonPhrase()
                ];
            } else {
                return [
                    'status' => 500,
                    'data' => 'Error interno del servidor'
                ];
            }
        }
    }

    public function actualizarDonador(Donador $donador){
        try {
            $url = $this->baseUrl.'/donadores/';
            $response = $this->client->put( $url, ['json' => $donador]);
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function eliminarDonador(int $id){
        try {
            $url = $this->baseUrl.'/donadores/'.$id;
            $response = $this->client->delete( $url );
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}