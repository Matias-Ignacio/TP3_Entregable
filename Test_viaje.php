<?php
include_once 'Viaje.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'PasajeroEsp.php';
include_once 'PasajeroVip.php';
include_once 'Persona.php';

// Arreglo para contener todos las instancias Viaje
$arrListaViajes = array();
$objPersonaUno = new Persona("Armando Esteban", "Quito", 33333333, 2993333333);
$objPersonaDos = new Persona("Leo", "Perez", 11123123, 2993000000);
$objPersonaTres = new Persona("Ana", "Frank", 9000444, 1123232323);

$unResponsable = new ResponsableV(345,"B356F", $objPersonaUno);

$unViaje = new Viaje(10, "Lejos", $unResponsable, 7, [], 1000);
$arrListaViajes[]= $unViaje;


/*************************************************************************************/
/**
 * Pide al objeto mediante el metodo .... el array de pasajeros y muestra una lista
 * de los datos de los pasajeros
 */
function mostrarListaPasajeros($objViaje){ 
    //int $indice
    //int $valor
    $arrListaPasajeros = $objViaje->getColPasajeros();
    echo "Lista de Pasajeros.............. \n";
    foreach ($arrListaPasajeros as $i => $valor){
        $costo = ((($arrListaPasajeros[$i]->darPorcentajeIncremento())/100)+1)* $objViaje->getCostoPasaje();
        echo $arrListaPasajeros[$i]."Costo Pasaje: ". $costo ."\n";
    } 
    echo "\nQuedan ". $objViaje->getMaxCantPasajeros() - $objViaje->cantPasajeros()." lugares.\n " ;    
}
//******************************************************************

/**
 * Muestra los datos del viaje, Codigo, destino y cantidad maxima de pasajeros
 * @param $objViaje
 */
function mostrarDatosViaje($objViaje){
    echo "\n----------------- Datos del viaje ----------------\n";
    echo "Código: ". $objViaje->getCodigoViaje() . "\t";
    echo "Cantidad máxima de pasaje: ". $objViaje->getMaxCantPasajeros() . "\t";
    echo "Destino: ". $objViaje->getDestino() . "\n";
    echo $objViaje->getResponsableViaje();
    echo "\nCosto Pasaje Standar: ". $objViaje->getCostoPasaje();
    echo "\nCosto Total: " . $objViaje->getCostoTotal();
    echo "\nQuedan ". $objViaje->getMaxCantPasajeros() - $objViaje->cantPasajeros()." lugares.\n " ;
    echo "--------------------------------------------------\n";
}
/**
 * Mostrar todos los viajes
 * @param $arrListaViajes objeto con la lista de viajes
 */
function mostrarListaViajes($arrListaViajes){
    if(count($arrListaViajes)!=0){
        foreach ($arrListaViajes as $i => $objetoViaje){
           mostrarDatosViaje($arrListaViajes[$i]);
        }      
    }else{
        echo "No hay datos para mostrar";
    }
}

/**
 * Agregar pasajeros al array del objeto
 * @param $objViaje objeto
 */
function agregarPasajero($objViaje)
{
    //$unPasajero instancia de clase Pasajero
    //string $nom,  $ape
    //int $dni, $tel
    $flag = "";
    mostrarDatosViaje($objViaje);
    echo "\n--- Ingrese los PASAJEROS del Viaje ---\n";
    do{    
        if(($objViaje->getMaxCantPasajeros() - $objViaje->cantPasajeros()) >= 1){
            $objPersona = crearPersona();
            $nroTicket = $objViaje->getUltimoTicket() + 1;
            $nroAsiento = $objViaje->getUltimoAsiento() + 1;
            echo "Informacion sobre el pasajero: \nEs pasajero estandar? (SI=ENTER)(NO = Cualquier tecla) ";
            $config = trim(fgets(STDIN));
            if ($config == ""){
                $unPasajero = new Pasajero($objPersona, $nroAsiento, $nroTicket);
            }else{
                echo "Es pasajero VIP? (SI=ENTER)(NO = Cualquier tecla) ";
                $config = trim(fgets(STDIN));
                if ($config == ""){
                    echo "Numero de viajero Frecuente: ";
                    $nroViajero = trim(fgets(STDIN));
                    echo "Cuantas millas tiene acumuladas? ";
                    $millas = trim(fgets(STDIN));
                    $unPasajero = new PasajeroVip($objPersona, $nroAsiento, $nroTicket, $nroViajero, $millas);
                }else{
                    $opcion1 = false;
                    $opcion2 = false;
                    $opcion3 = false;
                    echo "\nEs pasajero Especial.\nNecesita Silla de ruedas? (SI=ENTER)(NO = Cualquier tecla) ";
                    $config = trim(fgets(STDIN));
                    if($config == ""){
                        $opcion1 = true;
                    }
                    echo "\nNecesita asistencia? (SI=ENTER)(NO = Cualquier tecla) ";
                    $config = trim(fgets(STDIN));
                    if($config == ""){
                        $opcion2 = true;
                    }
                    echo "\nNecesita comida especial? (SI=ENTER)(NO = Cualquier tecla) ";
                    $config = trim(fgets(STDIN));
                    if($config == ""){
                        $opcion3 = true;
                    }
                    $unPasajero = new PasajeroEsp($objPersona, $nroAsiento, $nroTicket, $opcion1, $opcion2, $opcion3);
                }
            }
            if (!$objViaje->existePasajero($unPasajero)){
                $importeViaje = $objViaje->venderPasaje($unPasajero);
                $objViaje->setUltimoTicket($nroTicket);
                $objViaje->setUltimoAsiento($nroAsiento);
                echo "\nCosto del Pasaje: " . $importeViaje ;
                echo "\nDesea agregar otro pasajero? (SI=ENTER)(NO = Cualquier tecla) ";
                $flag = trim(fgets(STDIN));
            }else{
                echo "Ese DNI ya esta cargado en el viaje, NO se cargo nada.\n";
            }
        }else{
            echo "No hay mas lugar en este viaje. \n";
            $flag = "s";
        }    
    }while ($flag == "");

}

/**
 * Pide los datos del viaje nuevo, los guarda en un array 
 * que retorna para crear la instancia nueva
 * @return Viaje
 */
function crearViaje(){
    echo "\n--- Ingrese los datos del viaje ---\n";
    echo "Codigo: ";
    $cod = trim(fgets(STDIN));
    echo "Destino: ";
    $des = trim(fgets(STDIN));
    echo "Responsable: ";
    $res = crearResponsable();
    echo "Capacidad maxima de pasajeros: ";
    $max = trim(fgets(STDIN));
    echo "Costo Pasaje: ";
    $costo = trim(fgets(STDIN));
    $unViaje = new Viaje($cod, $des, $res, $max, [], $costo);
    return $unViaje;
}

/**
 * Crea y retorna un objeto Persona
 * @return Persona
 */
function crearPersona(){
    echo "Nombre: ";
    $nom = trim(fgets(STDIN));
    echo "Apellido: ";
    $ape = trim(fgets(STDIN));
    echo "DNI: ";
    $dni = trim(fgets(STDIN));
    echo "Telefono: ";
    $tel = trim(fgets(STDIN));
    $objPersona = new Persona($nom, $ape, $dni, $tel);
    return $objPersona;
}

/**
 * Pide los datos de la persona responsable de viaje,
 * crea el objeto $elResponsable y lo retorna
 * @return ResponsableV
 */
function crearResponsable(){
    echo "Numero de Empleado: ";
    $num = trim(fgets(STDIN));
    echo "Licencia: ";
    $lic = trim(fgets(STDIN));
    $objPer = crearPersona();
    $elResponsable = new ResponsableV($num, $lic, $objPer);
    return $elResponsable;
}

/**
 * Pide los datos de la persona responsable de viaje,
 * crea el objeto $elResponsable y lo retorna
 * @param ResponsableV
 * @return ResponsableV
 */
function modificarResponsable($objResp){
    echo "Numero de Empleado: " . $objResp->getIdEmpleado(). "\tNuevo Nro: (ENTER no modifica)";
    $num = trim(fgets(STDIN));
    if ($num != ""){
        $objResp->setIdEmpleado($num);
    }
    echo "Licencia: ". $objResp->getLicencia(). "\tNueva Licencia: (ENTER no modifica)";
    $lic = trim(fgets(STDIN));
    if ($lic != ""){
        $objResp->setLicencia($lic);
    }
    return $objResp;
}

/**
 * Buscar y retornar el indice del array de viajes a partir del codigo de viaje
 * retorna -1 si no existe el codigo de viaje
 */
function buscarViaje($cod,$obj){
    $bandera = false;
    $i = 0;
    do{
        if ($cod == $obj[$i]->getCodigoViaje()){
            $bandera = true;}
        $i++;    
    }while(($bandera == false) && ($i < count($obj))) ;
    if ($bandera == true){
        $i = $i-1; //resta 1 para ajustar el indice al array
    }else{
        $i = -1;
    }
    return $i;
}

/**
 * 
 */
function indiceViajes($objViajes){
    mostrarListaViajes($objViajes);
    echo "Seleccione el codigo del viaje: ";
    $cod = trim(fgets(STDIN));
    $ind = buscarViaje($cod, $objViajes);
    return $ind;
}

/**
 * Ingresar una tecla para volver al menu
 */
function volver(){
    $op = "";
    echo "\nPresione ENTER para ir al menu...";
    $op = trim(fgets(STDIN));
    return;
}
/**
 * Visualiza el menu de opciones en la pantalla, le solicita al usuario una opcion
 * valida, si la opcion no es valida vuelve a pedirla. Retorna el numero de la opcion
 * No tiene parametros formales
 * @return string
 */
function seleccionarOpcion(){
    //int $opcionMenu

    echo "\n\t*********MENU DE OPCIONES*********\n";
    echo "- Opciones Viajes              -----> (1) Nuevo           (2) Mostrar     (3) Modificar\n\n";
    echo "- Opciones Pasajeros           -----> (4) Mostrar lista   (5) Agregar     (6) Modificar ó Eliminar\n\n";
    echo "- Opciones Persona Responsable -----> (7) Agregar         (8) Modificar\n";
    echo "(0) Salir\n";
    echo "***********************************************\n";
    echo "    Ingrese una opción del menú: ";
    //$opcionMenu = solicitarNumeroEntre(1,8);
    $opcionMenu = trim(fgets(STDIN));
    return $opcionMenu;
}

/**
 * Menu de opciones para el viaje
 */
    $opcion = "";
    $indice = 0;
    $existePasajero = false;
    do{
        $opcion = seleccionarOpcion();
         switch ($opcion){
            case 1:
                echo "Opcion 1   *** Elaborar nuevo Viaje ***\n";
                $ViajeNuevo = crearViaje();
                array_push ($arrListaViajes, $ViajeNuevo);
                echo "Viaje ingresado con exito...\n";
                break; 
            case 2:
                echo "Opcion 2   *** Mostrar Viaje ***\n";
                mostrarListaViajes($arrListaViajes);
                volver();
                break;  
            case 3:
                echo "Opcion 3   *** Modificar Viaje ***\n";
                $indice = indiceViajes($arrListaViajes);
                if ($indice >= 0){
                    echo "Codigo: ";
                    $teclado = trim(fgets(STDIN));
                    $arrListaViajes[$indice]->setCodigoViaje($teclado);
                    echo "Destino: ";
                    $teclado = trim(fgets(STDIN));
                    $arrListaViajes[$indice]->setDestino($teclado);
                    echo "Pasajeros Maximos: ";
                    $teclado = trim(fgets(STDIN));
                    $arrListaViajes[$indice]->setMaxCantPasajeros($teclado);
                    mostrarDatosViaje($arrListaViajes[$indice]);
                }else{
                    echo "No existe el codigo de viaje ...\n";
                }
                volver();
                break;     
            case 4:
                echo "Opcion 4   *** Mostrar lista de pasajeros ***\n";
                $indice = indiceViajes($arrListaViajes);
                if ($indice >= 0){
                    mostrarListaPasajeros($arrListaViajes[$indice]);
                    echo "\n........................";
                }else{
                    echo "No existe el codigo de viaje ...\n";
                }
                volver();
                break;                            
            case 5:
                echo "Opcion 5   *** Agregar pasajero ***\n";
                $indice = indiceViajes($arrListaViajes);
                if ($indice >= 0){
                    agregarPasajero($arrListaViajes[$indice]);
                }else{
                    echo "No existe el codigo de viaje ...\n";
                }
                volver();
                break;   
            case 6:
                echo "Opcion 6   *** Modificar ó Eliminar Pasajero ***\n";
                do{
                    echo "Para (M)odificar ó (E)liminar\n";
                    $opcModEli = trim(fgets(STDIN));
                }while(!($opcModEli == "m" || $opcModEli == "e"));
                $indice = indiceViajes($arrListaViajes);
                $existePasajero = $arrListaViajes[$indice]->hayPasajeros();
                if (($indice >= 0) && ($existePasajero)){
                    mostrarListaPasajeros($arrListaViajes[$indice]);
                    echo "Seleccione el dni del pasajero: ";
                    $codDni = trim(fgets(STDIN));
                    $arrayPasajeros = $arrListaViajes[$indice]->getColPasajeros();
                    if ($opcModEli == "m" || $opcModEli == "M"){
                        $n = 0;
                        $bandera = false;
                        do{
                            if ($arrayPasajeros[$n]->getObjPersona()->getDni() == $codDni){
                                echo "Nombre: ".$arrayPasajeros[$n]->getObjPersona()->getNombre().
                                    "  Desea Modificar? (SI=ENTER)(NO = Cualquier tecla)";
                                $teclado = trim(fgets(STDIN));    
                                if ($teclado == ""){
                                    echo "Nombre: ";
                                    $teclado = trim(fgets(STDIN));
                                    $arrayPasajeros[$n]->getObjPersona()->setNombre($teclado);
                                }    
                                echo "Apellido: ".$arrayPasajeros[$n]->getObjPersona()->getApellido().
                                "  Desea Modificar? (SI=ENTER)(NO = Cualquier tecla)";
                                $teclado = trim(fgets(STDIN));    
                                if ($teclado == ""){
                                    echo "Apellido: ";
                                    $teclado = trim(fgets(STDIN));
                                    $arrayPasajeros[$n]->getObjPersona()->setApellido($teclado);
                                } 
                                echo "Telefono: ".$arrayPasajeros[$n]->getObjPersona()->getTelefono().
                                "  Desea Modificar? (SI=ENTER)(NO = Cualquier tecla)";
                                $teclado = trim(fgets(STDIN));    
                                if ($teclado == ""){
                                    echo "Telefono: ";
                                    $teclado = trim(fgets(STDIN));
                                    $arrayPasajeros[$n]->getObjPersona()->setTelefono($teclado);
                                } 
                                $bandera = true;
                            }
                            $n++;
                        }while($bandera == false && $n < count($arrayPasajeros));   
                        if ($bandera == false){
                            echo "No se encontro el pasajero...\n";
                        }else{ 
                        $arrListaViajes[$indice]->setColPasajeros($arrayPasajeros);
                        }
                    }else{
                        $arrListaViajes[$indice]->borrarPasajero($codDni);
                    }
                }else if ($indice < 0){
                    echo "No existe el codigo de viaje ...\n";
                }else{
                    echo "No hay pasajeros en este viaje...\n";
                }
                volver();
                break;
            case 7:
                echo "Opcion 7: ***Agregar Responsable de Viaje***\n";
                $indice = indiceViajes($arrListaViajes);
                if ($indice >= 0){
                    $otroResponsable = crearResponsable();
                    $arrListaViajes[$indice]->setResponsableViaje($otroResponsable);
                }else{
                    echo "No existe el codigo de viaje ...\n";
                } 
                volver();  
                break;    
            case 8:
                echo "Opcion 7: ***Modificar el Responsable de Viaje***\n";
                $indice = indiceViajes($arrListaViajes);
                if ($indice >= 0){
                    $objResp = $arrListaViajes[$indice]->getResponsableViaje();
                    $otroResponsable = modificarResponsable($objResp);
                    $arrListaViajes[$indice]->setResponsableViaje($otroResponsable);
                }else{
                    echo "No existe el codigo de viaje ...\n";
                } 
                volver();
                break;    
            case 0:
                echo "\nGracias...\n";
                break;                
        }                                              
    } while ($opcion != 0);


