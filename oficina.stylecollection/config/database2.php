<?php

abstract class Conexion2 extends PDO
{
	// private $host = 'stylecollection.org'; //servidor
	// private $bd = 'stylecollection_pages';  //base de datos
	// private $user = 'stylecollection'; //usuario
	// private $password = 'Dinero@2023'; // clave
	private $host = 'localhost'; //servidor
	private $bd = 'stylecollection_pages';  //base de datos
	private $user = 'supersu'; //usuario
	private $password = '12345678'; // clave
	private $port = 3306; // puerto
	private $respuestaConexion = false;


	private $errorMensaje = "";
	private $options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // mostrar los errores por los try-cath
		PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING, //cambiar los valores null a una cadena vacia
		PDO::ATTR_CASE => PDO::CASE_NATURAL, // escribir el nombre de las tablas como estan definidas
	];

	protected function realizarConexion()
	{
		try {
			parent::__construct("mysql:host={$this->host};dbname={$this->bd};port={$this->port}", $this->user, $this->password, $this->options);//ejecutamos la conexion
			//parent::__construct("mysql:host={$this->host};dbname={$this->bd};port={$this->port}", $this->user, $this->password, $this->options);//ejecutamos la conexion
			$this->respuestaConexion = true; //asignamos true al atributo
			$this->errorMensaje = "";
		} catch (PDOException $e) { //entramos si se encuentra un error o exeption
			$this->respuestaConexion = false; //asignamos el valor a false
			$this->errorMensaje = "error en:".$e; // asignamos el mensaje del error al atributo
		}
	}

	protected function getEstatusConexion()
	{//metodo que retorna el estatus de la conexion, lo implementamos en cada metodo que opera con la conexion con la base de datos (INSERT, SELECT, UPDATE, DELETE)
		return $this->respuestaConexion;
	}

	protected function getErrorConexion()
	{ //metodo que nos devuelve el mensaje de error si no llega a darse la conexion
		return $this->errorMensaje;
	}

	protected function cerrarConexion()
	{//metodo implementado para simular el cierre de conexion
		$this->respuestaConexion = false;
	}
	public function getLastId($tabla,$id)
	{
		//$sql='SELECT '.$id.' FROM '.$tabla.' ORDER BY '.$id.' desc';
		$sql='SELECT MAX('.$id.') FROM '.$tabla;
		try{
			$exe = Conexion::prepare($sql);
			$exe->execute();
			$result = $exe->fetchAll();
			return $result[0][0];
		}catch(PDOException $e){
			echo "Error al consultar el Id de la tabla $tabla <br>";
			echo $e;
		}
	} 
}

?>