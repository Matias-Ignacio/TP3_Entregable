<?php
include_once 'Pasajero.php';
class PasajeroEsp extends Pasajero{
    private $opcUno;
    private $opcDos;
    private $opcTres;
    
    public function __construct($objPersona, $nroAsiento, $nroTicket, $n1, $n2, $n3){
        parent::__construct($objPersona, $nroAsiento, $nroTicket);
        $this->opcUno = $n1;
        $this->opcDos = $n2;
        $this->opcTres = $n3;
    }
    public function getOpcUno(){
        return $this->opcUno;
    }
    public function getOpcDos(){
        return $this->opcDos;
    }
    public function getOpcTres(){
        return $this->opcTres;
    }
    
    //Metodos de escritura 
    
    public function setOpcUno($n1){
        $this->opcUno = $n1;
    }
    public function setOpcDos($n2){
        $this->opcDos = $n2;
    }
    public function setOpcTres($n3){
        $this->opcTres = $n3;
    }
    
    //-------- toString -------
    /**
     * @return string
     */
    public function __toString(){
        $cadena = "";
        $cadena = parent::__toString().
        "Silla de ruedas: ". ($this->getOpcUno() ? "SI" : "NO") .
        "\nAsistencia: ". ($this->getOpcDos() ? "SI" : "NO") .
        "\nComida Especial: ". ($this->getOpcTres() ? "SI" : "NO") . "\n";
        return $cadena;
    }
    
    /**
     * Retorna el porcentaje de incremento que debe aplicarse
     * @return int
     */
    public function darPorcentajeIncremento(){
        $incremento = parent::darPorcentajeIncremento(); //Retorna 10
        $config = 0;
        if ($this->getOpcUno()){
            $config = 1;
        }
        if ($this->getOpcDos()){
            $config += 2;
        }
        if ($this->getOpcTres()){
            $config += 4;
        }
        switch ($config){
            case (1):
                $incremento += 5;
                break;
            case (2):
                $incremento += 5;   
                break; 
            case (4):
                $incremento += 5;   
                break;    
         /*   case  (3 || 5 || 6):
                $incremento += 10;
                break;*/
            default:
                $incremento += 20;    
                break;
        }
        return $incremento;
    }
    
    }
  