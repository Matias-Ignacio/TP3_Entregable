<?php

class Persona{
    //
    private $nombre;
    private $apellido;
    private $dni;
    private $telefono;

    public function __construct ($nom, $ape, $dni, $tel){
        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->dni = $dni;
        $this->telefono = $tel;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getDni(){
        return $this->dni;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function setNombre($nom){
        $this->nombre = $nom;
    }
    public function setApellido($ape){
        $this->apellido = $ape;
    }
    public function setDni($dni){
        $this->dni = $dni;
    }
    public function setTelefono($tel){
        $this->telefono = $tel;
    }

    /**
     * Metodo toString de la clase
     * @return string
     */
    public function __toString(){
        $cadena = "";
        $cadena = "Nombre: ".$this->getNombre()." ".$this->getApellido().
        "\t DNI: ".$this->getDni()."\n" . "Telefono: " . $this->getTelefono() . "\n";
        return $cadena;
    }
}