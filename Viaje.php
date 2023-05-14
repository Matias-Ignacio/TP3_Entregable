<?php
class Viaje{
    //Informacion de viajes
    //Los atributos son el codigo del viaje, el destino, persona responsable del viaje
    // la cantidad maxima de pasajeros y un array de objetos clase Pasajero
    private $codigo;
    private $destino;
    private $responsableViaje;  //objeto clase ResponsableV
    private $maxCPas;
    private $colPasajeros ;     //arraay de objetos clase Pasajero
    private $costoPasaje;       //Costo de cada pasaje
    private $costoTotal;        //Suma de todos los pasajes ocupados
    private $ultimoTicket;
    private $ultimoAsiento;

    public function __construct($cod,$dest,$resp,$max,$colPa, $costo){   
        //Metodo constructor de la clase Viaje
        $this->codigo = $cod;
        $this->destino = $dest;
        $this->responsableViaje = $resp;
        $this->maxCPas = $max;
        $this->colPasajeros = $colPa;
        $this->costoPasaje = $costo;
        $this->costoTotal = 0;
        $this->ultimoTicket = 0;
        $this->ultimoAsiento = 0;
    }

    //Metodo para obtener los datos del viaje
    public function getCodigoViaje(){
        return $this->codigo;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getResponsableViaje(){
        return $this->responsableViaje;
    }
    public function getMaxCantPasajeros(){
        return $this->maxCPas;
    }
    public function getColPasajeros(){
        return $this->colPasajeros;
    } 
    public function getCostoPasaje(){
        return $this->costoPasaje;
    }
    public function getCostoTotal(){
        return $this->costoTotal;
    }
    public function getUltimoTicket(){
        return $this->ultimoTicket;
    }
    public function getUltimoAsiento(){
        return $this->ultimoAsiento;
    }
    //Metodos para modificar los datos del viaje
    public function setCodigoViaje($cod){
        $this->codigo = $cod;
    }
    public function setDestino($dest){
        $this->destino = $dest;
    }
    public function setResponsableViaje($resp){
        $this->responsableViaje = $resp;
    }
    public function setMaxCantPasajeros($max){
        $this->maxCPas = $max;
    }
    public function setColPasajeros($colPasajeros){
        $this->colPasajeros = $colPasajeros;
    }
    public function setCostoPasaje($costo){
        $this->costoPasaje = $costo;
    }
    public function setCostoTotal($costo){
        $this->costoTotal = $costo;
    }
    public function setUltimoTicket($ticket){
        $this->ultimoTicket = $ticket;
    }
    public function setUltimoAsiento($asiento){
        $this->ultimoAsiento = $asiento;
    }
    //Metodos especiales de la clase
    /**
     * Metodo que agrega un pasajero al arreglo de pasajeros
     * @param array
     */
    public function agregarPasajero($pasajeroNuevo){
        $coleccion = $this->getColPasajeros();
        $coleccion[] = $pasajeroNuevo;
        $this->setColPasajeros($coleccion);

    }
    /**
     * Metodo que devuelve la cantidad actual de pasajeros
     * cargados en el viaje
     * @return int
     */
    public function cantPasajeros(){
        return count($this->colPasajeros);
    }
    /**
     * Metodo que modifica los datos del viaje, no la lista de pasajeros
     * @param $cod
     * @param $dest
     * @param $resp
     * @param $max
     * @param $costo
     */
    public function modificarViaje($cod, $dest, $resp, $max, $costo){
        $this->setCodigoViaje($cod);
        $this->setDestino($dest);
        $this->setResponsableViaje($resp);
        $this->setMaxCantPasajeros($max);
        $this->setCostoPasaje($costo);
    }
    /**
     * Metodo para saber si hay cargado algun pasajero en el viaje
     * devuelve false si el viaje esta vacio
     * @return boolean
     */
    public function hayPasajeros(){
        $hay = true;
        if (count($this->colPasajeros) == 0){
            $hay = false;
        }
        return $hay;
    }
    /**
     * Metodo recibe por parametros los datos de un pasajero,
     * recorrre el arreglo de pasajeros buscando si ya esta cargado
     * devuelve falso si no esta cargado el pasajero
     * @param $pasajero
     * @return boolean
     */
    public function existePasajero($pasajero){
        $existe = false;
        $i = 0;
        if ($this->hayPasajeros()){
            do{
               $existe = ($pasajero->compararPasajero($this->getColPasajeros()[$i]));
               $i++;
            }while (($existe == false) && ($this->cantPasajeros() > $i));
        }
        return $existe;
    }

    /**
     * Metodo para borrar un pasajero mediante el DNI
     * retorna true si se borro un pasajero
     * @param $dni
     * @return boolean
     */
    public function borrarPasajero($dni){
        $exito = false;
        $i = 0;
        $arregloPasajeros = [];
        $arregloPasajeros = $this->getColPasajeros();
        do{
            if ($arregloPasajeros[$i]->getDni() == $dni){
                unset($arregloPasajeros[$i]);
                $this->setColPasajeros($arregloPasajeros);
                $exito = true;
            }
            $i++;
        }while(($exito == false) && ($this->cantPasajeros() > $i));
        return $exito;
    }

    /**
     * retorna true si hay lugar disponible en el viaje, false caso contrario
     * @return boolean
     */
    public function hayPasajeDisponible(){
        $exito = false;
        $coleccion = $this->getColPasajeros();
        $cMax = $this->getMaxCantPasajeros();
        if (count($coleccion) < $cMax){
            $exito = true;
        }
        return $exito;
    }

    /**
     * Incorpora un pasajero a la coleccion del viaje si hay lugar disponible
     * Actualiza el costo total del viaje
     * retorna el costo del pasaje para el pasajero engresado
     * @param $objPasajero
     * @return int
     */
    public function venderPasaje($objPasajero){
        $costoPasaje = 0;
        $porcentajeInc = $objPasajero->darPorcentajeIncremento();
        $costoTotal = $this->getCostoTotal();
        if ($this->hayPasajeDisponible()){
            $costoPasaje = $this->getCostoPasaje() * (1 + ($porcentajeInc / 100));
            $costoTotal += $costoPasaje;
            $this->setCostoTotal($costoTotal);
            $this->agregarPasajero($objPasajero);
        }
        return $costoPasaje;
    }


    /**
     * Metodo toString de la clase
     * @return string
     */
	public function __toString(){
        $cadena = "";
        $cadena = "Codigo : ". $this->getCodigoViaje(). "\n".
                "Destino: ". $this->getDestino(). "\n".
                $this->getResponsableViaje()."\n".
                "Costo del Pasaje: " . $this->getCostoPasaje() ."\n".
                "Cant Maxima Pasajeros: ". $this->getMaxCantPasajeros(). "\n".
                "Costo Total: " . $this->getCostoTotal()."\n";
		return $cadena;
	}
    
}