<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$usuario = 'fpadilla';
//$clave   = 'fpadilla0';
$usuario = 'INT_5S_T';
$clave   = '3nt5st';

//$servidor = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.23.50.49)(PORT=1521))(CONNECT_DATA=(SID=BDSAL)))";
$servidor = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST=172.23.50.93) (PORT=1521))(CONNECT_DATA =(SERVER=DEDICATED)(SERVICE_NAME=MUNI)))";
$charset = "utf8";   

//Crear conexión con Oracle
$conecta = oci_connect($usuario,$clave,$servidor,$charset);

    if (!$conecta){
        $e = oci_error();
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
        exit;	   
    }
    else{
        //echo "Conexion con exito a Oracle";
        echo "";
    }

?>