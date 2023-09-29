<?php 

	if(is_file('config/database.php')){
		require_once'config/database.php';
	}
	if(is_file('../config/database.php')){
		require_once'../config/database.php';
	}
	class TSubida extends Conexion{
		private $id;
		private $idUser;
		private $idDominio;
		private $cantM;
		private $cantF;
		private $cantTotal;
		private $fecha;
		private $hora;

		public function setId($val){ $this->id = $val; }
		public function setIdUser($val){ $this->idUser = $val; }
		public function setIdDominio($val){ $this->idDominio = $val; }
		public function setCantM($val){ $this->cantM = $val; }
		public function setCantF($val){ $this->cantF = $val; }
		public function setCantTotal($val){ $this->cantTotal = $val; }
		public function setFecha($val){ $this->fecha = $val; }
		public function setHora($val){ $this->hora = $val; }

		public function getId(){ return $this->id; }
		public function getIdUser(){ return $this->idUser; }
		public function getIdDominio(){ return $this->idDominio; }
		public function getCantM(){ return $this->cantM; }
		public function getCantF(){ return $this->cantF; }
		public function getCantTotal(){ return $this->cantTotal; }
		public function getFecha(){ return $this->fecha; }
		public function getHora(){ return $this->hora; }

		public function __construct(){Conexion::realizarConexion();}

		public function Registrar(){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "INSERT INTO tcontador(id, id_users, id_dominio, cantM, cantF, cantG, fecha, hora, estatus)VALUES(DEFAULT, :id_users, :id_dominio, :cantM, :cantF, :cantG, :fecha, :hora, 1)";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":id_users",$this->idUser);
					$strExe->bindValue(":id_dominio",$this->idDominio);
					$strExe->bindValue(":cantM",$this->cantM);
					$strExe->bindValue(":cantF",$this->cantF);
					$strExe->bindValue(":cantG",$this->cantTotal);
					$strExe->bindValue(":fecha",$this->fecha);
					$strExe->bindValue(":hora",$this->hora);
					$strExe->execute();
					$this->id = Conexion::getLastId("tcontador","id");
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

		public function Consultar(){
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

		public function ConsultarSubidas($dominio){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT tusers.id as id_users, tusers.cedula, tcontador.id as id_contador, tcontador.fecha, tcontador.hora, tdominios.id as id_dominio, tdominios.dominio  FROM tusers, tcontador, tdominios WHERE tusers.id = tcontador.id_users and tcontador.id_dominio = tdominios.id and tdominios.dominio = :dominio";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":dominio", $dominio);
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

		public function ConsultarBajadas($dominio){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT SUM(tcontador.cantM) as cantM, SUM(tcontador.cantF) as cantF, SUM(tcontador.cantG) as cantG FROM tcontador, tdominios WHERE tcontador.id_dominio = tdominios.id and tdominios.dominio = :dominio";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":dominio", $dominio);
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

		public function ConsultarListaIglesias(){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT DISTINCT tcontador_iglesias.nombre_iglesia FROM tcontador_iglesias";
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

		public function ConsultarBajadasIglesias($dominio, $iglesia){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT  SUM(tcontador_iglesias.cantIgM) as cantM, SUM(tcontador_iglesias.cantIgF) as cantF, SUM(tcontador_iglesias.cantIgG) as cantG  FROM tdominios, tcontador_iglesias WHERE tcontador_iglesias.id_dominio=tdominios.id and tdominios.dominio = :dominio and tcontador_iglesias.nombre_iglesia = :iglesia";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":dominio", $dominio);
					$strExe->bindValue(":iglesia", $iglesia);
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
						$query = "SELECT id, id_users, id_dominio, cantM, cantF, cantG, fecha, hora, estatus FROM tcontador WHERE estatus = 1 and id=:id ORDER BY dominio ASC";
						$strExe = Conexion::prepare($query);
						$strExe->bindValue(":id",$this->id);
					}
					if($opcion=="idUserDomain"){
						$query = "SELECT id, id_users, id_dominio, cantM, cantF, cantG, fecha, hora, estatus FROM tcontador WHERE estatus = 1 and id_users=:id_users and id_dominio=:id_dominio";
						$strExe = Conexion::prepare($query);
						$strExe->bindValue(":id_users",$this->idUser);
						$strExe->bindValue(":id_dominio",$this->idDominio);
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
					$query = "UPDATE tcontador SET id_users=:id_users, id_dominio=:id_dominio, cantM=:cantM, cantF=:cantF, cantG=:cantG, fecha=:fecha, hora=:hora, estatus=1 WHERE id = :id";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":id_users",$this->idUser);
					$strExe->bindValue(":id_dominio",$this->idDominio);
					$strExe->bindValue(":cantM",$this->cantM);
					$strExe->bindValue(":cantF",$this->cantF);
					$strExe->bindValue(":cantG",$this->cantTotal);
					$strExe->bindValue(":fecha",$this->fecha);
					$strExe->bindValue(":hora",$this->hora);
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

		// public function Eliminar(){
		// 	if(Conexion::getEstatusConexion()) {
		// 		// $query = "DELETE FROM tdominios WHERE id = :id";
		// 		$query = "UPDATE tdominios SET estatus=0 WHERE id = :id";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":id",$this->id);
		// 			$strExe->execute();
		// 			$result['msj'] = "Good";
		// 			return $result;
		// 		}catch(PDOException $e){
		// 			$result['msj'] = "Error";
		// 			$result['message'] = "Error en la ejecucion de sentencia SQL";
		// 			$result['detalle'] = "Error: ".$e;
		// 			return $result;
		// 		}
		// 	}else{
		// 		$result['msj'] = "Error";
		// 		$result['message'] = "Error en la Conexion a la DB, Contacte el Soporte";
		// 		$result['detalle'] = "Error: ".$e;
		// 		return $result;
		// 	}
		// }

		public function RegistrarIglesia($data){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "INSERT INTO tcontador_iglesias(id, id_contador, id_users, id_dominio, nombre_iglesia, cantIgM, cantIgF, cantIgG, estatus)VALUES(DEFAULT, :id_contador, :id_users, :id_dominio, :nombre_iglesia, :cantIgM, :cantIgF, :cantIgG, 1)";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":id_contador",$data['id_contador']);
					$strExe->bindValue(":id_users",$data['id_users']);
					$strExe->bindValue(":id_dominio",$data['id_dominio']);
					$strExe->bindValue(":nombre_iglesia",$data['nombre_iglesia']);
					$strExe->bindValue(":cantIgM",$data['cantIgM']);
					$strExe->bindValue(":cantIgF",$data['cantIgF']);
					$strExe->bindValue(":cantIgG",$data['cantIgG']);
					$strExe->execute();
					$this->id = Conexion::getLastId("tcontador_iglesias","id");
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

		public function EliminarIglesias($data){
			if(Conexion::getEstatusConexion()) {
				// $query = "DELETE FROM tdominios WHERE id = :id";
				$query = "DELETE FROM tcontador_iglesias WHERE id_contador = :id";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":id",$data['id_contador']);
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