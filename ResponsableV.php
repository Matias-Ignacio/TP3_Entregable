<?php

class ResponsableV{

    private $idEmpleado;
    private $licencia;
    private $objPersona;

    //Metodo constructor de la clase
    public function __construct($id, $lic, $obj){
        $this->idEmpleado = $id;
        $this->licencia = $lic;
        $this->objPersona = $obj;
    }
    //Metodos de acceso a los datos de la clase
    public function getIdEmpleado(){
        return $this->idEmpleado;
    }
    public function getLicencia(){
        return $this->licencia;
    }
    public function getObjPersona(){
        return $this->objPersona;
    }

    //Metodos de escritura de los atributos de la clase
    public function setIdEmpleado($id){
        $this->idEmpleado = $id;
    }
    public function setLicencia($lic){
        $this->licencia = $lic;
    }
    public function setObjPersona($obj){
        $this->objPersona = $obj;
    }

    /**
     * Metodo toString de la clase
     * @return string
     */
    public function __toString(){
        $cadena = "";
        $cadena = "Responsable del viaje: \n". $this->getObjPersona().
        "\tNro Empleado: ".$this->getIdEmpleado().
        "\t Licencia: ".$this->getLicencia();
        return $cadena;
    }
}