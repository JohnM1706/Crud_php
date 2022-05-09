<?php
//Aprendiendo conexion base de datos Lenguaje PHP
$pdo=null;
$server='127.0.0.1';
$username='user';
$password='';
$bd='crud_php'; 
//$conexion=mysqli_connect($server,$username,$password,$bd);
//conecion con LIBRERIA PDO 

function conectar(){
    try{//conexion utilizando PDO
      $GLOBALS['pdo']=new PDO("mysql:host=".$GLOBALS['server'].";dbname=".$GLOBALS['bd']."", $GLOBALS['username'], $GLOBALS['password']);
      $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
    }catch (PDOExeption $e){
      print "Error!: No se pudo conectar a la Base de datos ".$bd."<br/>";
      print "\nError!: ".$e."<br/>";
      die();
    }
   
}
function desconectar() {
   $GLOBALS['pdo']=null;
}

function metodoGet($query){
   try{
       conectar();
       $sentencia=$GLOBALS['pdo']->prepare($query);
       $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       $sentencia->execute();
       desconectar();
       return $sentencia;
   }catch(Exception $e){
       die("Error: ".$e);
   }
}

function metodoPost($query, $queryAutoIncrement){
   try{
       conectar();
       $sentencia=$GLOBALS['pdo']->prepare($query);
       $sentencia->execute();
       $idAutoIncrement=metodoGet($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC); //convrtir  un array asociativo 
       $resultado=array_merge($idAutoIncrement, $_POST);
       $sentencia->closeCursor();
       desconectar();
       return $resultado;
   }catch(Exception $e){
       die("Error: ".$e);
   }
}


function metodoPut($query){
   try{
       conectar();
       $sentencia=$GLOBALS['pdo']->prepare($query);
       $sentencia->execute();
       $resultado=array_merge($_GET, $_POST);
       $sentencia->closeCursor();
       desconectar();
       return $resultado;
   }catch(Exception $e){
       die("Error: ".$e);
   }
}

function metodoDelete($query){
   try{
       conectar();
       $sentencia=$GLOBALS['pdo']->prepare($query);
       $sentencia->execute();
       $sentencia->closeCursor();
       desconectar();
       return $_GET['id'];
   }catch(Exception $e){
       die("Error: ".$e);
   }
}



?>