<?php
include_once 'Pasajero.php';
class PasajeroVip extends Pasajero{
    private $nroViajeroFrec;
    private $cantMillas;

    public function __construct($nombre, $nroAsiento, $nroTicket, $nroViajeroFrec, $cantMillas){
        parent::__construct($nombre, $nroAsiento, $nroTicket);
        $this->nroViajeroFrec = $nroViajeroFrec;
        $this->cantMillas = $cantMillas;
    }

    public function getNroViajeroFrec(){
        return $this->nroViajeroFrec;
    }

    public function getCantMillas(){
        return $this->cantMillas;
    }

    public function setNroViajeroFrec($nro){
        $this->nroViajeroFrec = $nro;
    }

    public function setCantMillas($cant){
        $this->cantMillas = $cant;
    }

    /**
     * Metodo toString de la clase
     * @return string
     */
    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Nro Viajero Frecuente: " . $this->getNroViajeroFrec() .
        "\nCantidad de Millas: " . $this->getCantMillas()."\n";
        return $cadena;
    }
    
    /**
    * Retorna el porcentaje de incremento que debe aplicarse
    * @return int
    */
    public function darPorcentajeIncremento(){
        $incremento = parent::darPorcentajeIncremento();
        $incremento += 25;
        if ($this->getCantMillas() > 300){
            $incremento -= 5;
        }
        return $incremento;
    }
    
}