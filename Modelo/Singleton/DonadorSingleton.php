<?php

class DonadorSingleton
{
    private static $instance = null;

    private int $id;
    private string $nombre;
    private string $apellidoPaterno;
    private string $apellidoMaterno;
    private string $correo;
    private string $telefono;
    private string $direccion;
    private string $contrasena;
    private string $grupoSanguineo;

    private function __construct() {
        // Constructor privado para el patrón Singleton
    }

    public static function getInstance(): DonadorSingleton {
        if (self::$instance === null) {
            self::$instance = new DonadorSingleton();
        }
        return self::$instance;
    }

    public function fromDonador(Donador $donador): void {
        $this->id = $donador->id;
        $this->nombre = $donador->nombre;
        $this->apellidoPaterno = $donador->apellidoPaterno;
        $this->apellidoMaterno = $donador->apellidoMaterno;
        $this->correo = $donador->correo;
        $this->telefono = $donador->telefono;
        $this->direccion = $donador->direccion;
        $this->contrasena = $donador->contrasena;
        $this->grupoSanguineo = $donador->grupoSanguineo;
    }

    public function toDonador(): Donador {
        $donador = new Donador();
        $donador->id = $this->id;
        $donador->nombre = $this->nombre;
        $donador->apellidoPaterno = $this->apellidoPaterno;
        $donador->apellidoMaterno = $this->apellidoMaterno;
        $donador->correo = $this->correo;
        $donador->telefono = $this->telefono;
        $donador->direccion = $this->direccion;
        $donador->contrasena = $this->contrasena;
        $donador->grupoSanguineo = $this->grupoSanguineo;
        return $donador;
    }

    public function isEmpty(): bool {
        return empty($this->nombre) && empty($this->correo);
    }

    // Setters and Getters

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getApellidoPaterno(): string {
        return $this->apellidoPaterno;
    }

    public function setApellidoPaterno(string $apellidoPaterno): void {
        $this->apellidoPaterno = $apellidoPaterno;
    }

    public function getApellidoMaterno(): string {
        return $this->apellidoMaterno;
    }

    public function setApellidoMaterno(string $apellidoMaterno): void {
        $this->apellidoMaterno = $apellidoMaterno;
    }

    public function getCorreo(): string {
        return $this->correo;
    }

    public function setCorreo(string $correo): void {
        $this->correo = $correo;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function getContrasena(): string {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): void {
        $this->contrasena = $contrasena;
    }

    public function getGrupoSanguineo(): string {
        return $this->grupoSanguineo;
    }

    public function setGrupoSanguineo(string $grupoSanguineo): void {
        $this->grupoSanguineo = $grupoSanguineo;
    }
}
