<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DonadorAPI
{
    private Client $client;
    private string $baseUrl = 'https://api.chesseguro.com';
    public function __construct(){
        $this->client = new Client();
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