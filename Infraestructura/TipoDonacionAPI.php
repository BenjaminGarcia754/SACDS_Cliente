<?php

require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TipoDonacionAPI
{
    private Client $client;
    private string $baseUrl = 'https://benja.ag-dev.com.mx/SACDS/api/TipoDonacion/';
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://benja.ag-dev.com.mx/SACDS/api/',
            'verify' => false, // Desactiva la verificación de SSL
        ]);
        
    }

    public function obtenerTipoDonaciones()
    {
        try {
            $url = $this->baseUrl . 'GetTipoDonaciones';
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function obtenerTipoDonacion(int $idTipoDonacion): mixed{
        try {
            $url = $this->baseUrl . 'tipodonacion/' . $idTipoDonacion;
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
