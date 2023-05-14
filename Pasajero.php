<?php
class Pasajero{
    private $objPersona;
    private $nroAsiento;
    private $nroTicket;

    public function __construct($objPersona, $nroAsiento, $nroTicket){
        $this->objPersona = $objPersona;
        $this->nroAsiento = $nroAsiento;
        $this->nroTicket = $nroTicket;
    }
    public function getObjPersona(){
        return $this->objPersona;
    }
    public function getNroAsiento(){
        return $this->nroAsiento;
    }
    public function getNroTicket(){
        return $this->nroTicket;
    }

    //Metodos de escritura 
  
    public function setObjPersona($objPersona){
        $this->objPersona = $objPersona;
    }
    public function setNroAsiento($nroAsiento){
        $this->nroAsiento = $nroAsiento;
    }
    public function setNroTicket($nroTicket){
        $this->nroTicket = $nroTicket;
    }

    //-------- toString--------
    public function __toString(){
        $cadena = "";
        $cadena = 
        "\nPasajero:\n".$this->getObjPersona().
        "NroAsiento: ".$this->getNroAsiento().
        "\nNroTicket: ".$this->getNroTicket()."\n";
        return $cadena;
    }
    
    /**
     * Retorna el porcentaje de incremento que debe aplicarse
     * @return int
     */
    public function darPorcentajeIncremento(){
        $incremento = 10;
        return $incremento;
    }
 
            /**
         * Metodo que compara dos pasajeros a traves del numero de DNI
         * Devuelve True si son iguales
         * @param $pasNuevo objeto
         * @return boolean
         */
        public function compararPasajero($pasNuevo){
            $igual = false;
            if ($pasNuevo->getObjPersona()->getDni() == $this->getObjPersona()->getDni()){
                $igual = true;
            }
            return $igual;
        }

}