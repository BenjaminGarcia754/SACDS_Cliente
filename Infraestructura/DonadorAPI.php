<?php

require_once __DIR__ . '/../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DonadorAPI
{
    private Client $client;
    private string $baseUrl = 'https://benja.ag-dev.com.mx/SACDS/api/Donador/';
    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://benja.ag-dev.com.mx/SACDS/api/Donador',
            'verify' => false, // Desactiva la verificación de SSL
        ]);
        
    }

    public function obtenerDonadores(){
        try {
            $url = $this->baseUrl .'GetDonadores';
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
    public function obtenerDonador(int $id){
        try {
            $url = $this->baseUrl.'GetDonador/'.$id;
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function registrarDonador(Donador $donador) {
        try {
            $url = $this->baseUrl . 'AddDonador';
            $response = $this->client->post($url, ['json' => $donador]);
            $status = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());

            return [
                'result' => $result,
                'status' => $status,
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

    public function IniciarSesion(Donador $donador)
    {
        try {
            $url = $this->baseUrl . 'login';
            
            $response = $this->client->post($url, [
                'json' => (array) $donador,
                'verify' => false,
            ]);
    
            $statusCode = $response->getStatusCode();  // Captura el código de estado
            $data = json_decode($response->getBody()->getContents(), true);  // Decodifica el cuerpo JSON
            if($statusCode === 200){
                $donadorTemporal = new Donador();
                $donadorTemporal->id = $data['id'];
                $donadorTemporal->nombre = $data['nombre'];
                $donadorTemporal->apellidoPaterno = $data['apellidoPaterno'];
                $donadorTemporal->apellidoMaterno = $data['apellidoMaterno'];
                $donadorTemporal->correo = $data['correo'];
                $donadorTemporal->telefono = $data['telefono'];
                $donadorTemporal->direccion = $data['direccion'];
                $donadorTemporal->contrasena = $data['contrasena'];
                $donadorTemporal->grupoSanguineo = $data['grupoSanguineo'];
                $donadorTemporal->esDonador = $data['esDonador'];
                return [
                    'status' => $statusCode,
                    'donador' => $donadorTemporal
                ];

            }else{
                return [
                    'status'=> $statusCode,
                    'donador'=> null
                ];
            }
    
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
    
    
    public function actualizarDonador($id, Donador $donador){
        try {
            $url = $this->baseUrl . 'UpdateDonador/' . $id;
            $response = $this->client->put($url, ['json' => $donador]);
            return [
                'status' => $response->getStatusCode(),
                'error' => null,
            ];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $status = $e->getResponse()->getStatusCode();
                $errorMessage = $e->getResponse()->getBody()->getContents();
                return [
                    'status' => $status,
                    'error' => $errorMessage,
                ];
            }
        }
    }

    public function eliminarDonador(int $id){
        try {
            $url = $this->baseUrl.'DeleteDonador'.$id;
            $response = $this->client->delete( $url );
            return json_decode($response->getBody()->getContents());
        }catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}