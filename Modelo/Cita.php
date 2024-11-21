<?php
class Cita {
    public int $id;
    public int $idDonador;
    public int $idTipoDonacion;
    public int $idDonacionUrgente;
    public DateTime $fechaDonacion;
    public int $diasReposo;
    public bool $atendida;

    public function __construct(
        int $id = 0,
        int $idDonador = 0,
        int $idTipoDonacion = 0,
        int $idDonacionUrgente = 0,
        ?DateTime $fechaDonacion = null,
        int $diasReposo = 0,
        bool $atendida
    ) {
        $this->id = $id;
        $this->idDonador = $idDonador;
        $this->idTipoDonacion = $idTipoDonacion;
        $this->idDonacionUrgente = $idDonacionUrgente;
        $this->fechaDonacion = $fechaDonacion ?? new DateTime();
        $this->diasReposo = $diasReposo;
        $this->atendida = $atendida;
    }

    // Método para convertir el objeto a un arreglo antes de codificarlo en JSON
    public function toArray(): array {
        return [
            'id' => $this->id,
            'idDonador' => $this->idDonador,
            'idTipoDonacion' => $this->idTipoDonacion,
            'idDonacionUrgente' => $this->idDonacionUrgente,
            'fechaDonacion' => $this->fechaDonacion->format(DateTime::ATOM),
            'diasReposo' => $this->diasReposo
        ];
    }
}
