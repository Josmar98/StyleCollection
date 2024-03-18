<?php 

	if(is_file('config/database.php')){
		require_once'config/database.php';
	}
	if(is_file('../config/database.php')){
		require_once'../config/database.php';
	}
	class TCortes extends Conexion{
		private $id;
		private $dominio;

		public function setId($val){$this->id = $val;}
		public function setDominio($val){$this->dominio = $val;}

		public function getId(){ return $this->id;}
		public function getDominio(){ return $this->dominio;}

		public function __construct(){Conexion::realizarConexion();}

		public function Registrar(){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "INSERT INTO tdominios(id, dominio, estatus)VALUES(DEFAULT, :dominio, 1)";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":dominio",$this->dominio);
					$strExe->execute();
					$this->id = Conexion::getLastId("tdominios","id");
					$result['msj'] = "Good";
					$result['id'] = $this->id;
					return $result;
				}catch(PDOException $e){
					$result['msj'] = "Error";
					$result['message'] = "Error en la ejecucion de sentencia SQL";
					$result['detalle'] = "Error: ".$e;
					return $result;
				}
			}else{
				$result['msj'] = "Error";
				$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
				$result['detalle'] = "Error: ".$e;
				return $result;
			}
		}


		public function ConsultarDominios(){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT id, dominio, estatus FROM tdominios WHERE estatus = 1 ORDER BY id ASC";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->execute();
					$data = $strExe->fetchAll();
					$result['msj'] = "Good";
					if(Count($data)>0){
						$result['data'] = $data;
					}else{
						$result['data'] = [];
					}
					return $result;
				}catch(PDOException $e){
					$result['msj'] = "Error";
					$result['message'] = "Error en la ejecucion de sentencia SQL";
					$result['detalle'] = "Error: ".$e;
					return $result;
				}
			}else{
				$result['msj'] = "Error";
				$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
				$result['detalle'] = "Error: ".$e;
				return $result;
			}
		}

		public function ConsultarPastores(){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT id, nombre_pastor FROM listPastores WHERE estatus = 1 ORDER BY id ASC";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->execute();
					$data = $strExe->fetchAll();
					$result['msj'] = "Good";
					if(Count($data)>0){
						$result['data'] = $data;
					}else{
						$result['data'] = [];
					}
					return $result;
				}catch(PDOException $e){
					$result['msj'] = "Error";
					$result['message'] = "Error en la ejecucion de sentencia SQL";
					$result['detalle'] = "Error: ".$e;
					return $result;
				}
			}else{
				$result['msj'] = "Error";
				$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
				$result['detalle'] = "Error: ".$e;
				return $result;
			}
		}

		public function ConsultarOne($opcion){
			if(Conexion::getEstatusConexion()){
				try{
					if($opcion=="id"){
						$query = "SELECT id, dominio, estatus FROM tdominios WHERE estatus = 1 and id=:id ORDER BY dominio ASC";
						$strExe = Conexion::prepare($query);
						$strExe->bindValue(":id",$this->id);
					}
					if($opcion=="dominio"){
						$query = "SELECT id, dominio, estatus FROM tdominios WHERE estatus = 1 and dominio=:dominio ORDER BY dominio ASC";
						$strExe = Conexion::prepare($query);
						$strExe->bindValue(":dominio",$this->dominio);
					}
					$strExe->execute();
					$data = $strExe->fetchAll();
					$result['msj'] = "Good";
					if(Count($data)>0){
						$result['data'] = $data;
					}else{
						$result['data'] = [];
					}
					return $result;
				}catch(PDOException $e){
					$result['msj'] = "Error";
					$result['message'] = "Error en la ejecucion de sentencia SQL";
					$result['detalle'] = "Error: ".$e;
					return $result;
				}
			}else{
				$result['msj'] = "Error";
				$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
				$result['detalle'] = "Error: ".$e;
				return $result;
			}
		}

		public function Modificar(){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "UPDATE tdominios SET dominio=:dominio, estatus=1 WHERE id = :id";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":dominio",$this->dominio);
					$strExe->bindValue(":id",$this->id);
					$strExe->execute();
					$result['msj'] = "Good";
					return $result;
				}catch(PDOException $e){
					$result['msj'] = "Error";
					$result['message'] = "Error en la ejecucion de sentencia SQL";
					$result['detalle'] = "Error: ".$e;
					return $result;
				}
			}else{
				$result['msj'] = "Error";
				$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
				$result['detalle'] = "Error: ".$e;
				return $result;
			}
		}

		public function Eliminar(){
			if(Conexion::getEstatusConexion()) {
				// $query = "DELETE FROM tdominios WHERE id = :id";
				$query = "UPDATE tdominios SET estatus=0 WHERE id = :id";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":id",$this->id);
					$strExe->execute();
					$result['msj'] = "Good";
					return $result;
				}catch(PDOException $e){
					$result['msj'] = "Error";
					$result['message'] = "Error en la ejecucion de sentencia SQL";
					$result['detalle'] = "Error: ".$e;
					return $result;
				}
			}else{
				$result['msj'] = "Error";
				$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
				$result['detalle'] = "Error: ".$e;
				return $result;
			}
		}
	}

?>