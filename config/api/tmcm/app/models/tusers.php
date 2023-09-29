<?php 

	if(is_file('config/database.php')){
		require_once'config/database.php';
	}
	if(is_file('../config/database.php')){
		require_once'../config/database.php';
	}
	class TUsers extends Conexion{
		private $id;
		private $rol;
		private $cedula;
		private $nombre;
		private $apellido;
		private $telefono;
		private $iglesia;
		private $password;

		public function setId($val){$this->id = $val;}
		public function setRol($val){$this->rol = $val;}
		public function setCedula($val){$this->cedula = $val;}
		public function setNombre($val){$this->nombre = $val;}
		public function setApellido($val){$this->apellido = $val;}
		public function setTelefono($val){$this->telefono = $val;}
		public function setIglesia($val){$this->iglesia = $val;}
		public function setPassword($val){$this->password = $val;}

		public function getId(){ return $this->id;}
		public function getRol(){ return $this->rol;}
		public function getCedula(){ return $this->cedula;}
		public function getNombre(){ return $this->nombre;}
		public function getApellido(){ return $this->apellido;}
		public function getTelefono(){ return $this->telefono;}
		public function getIglesia(){ return $this->iglesia;}
		public function getPassword(){ return $this->password;}

		public function __construct(){Conexion::realizarConexion();}

		public function Registrar(){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "INSERT INTO tusers(id, rol, cedula, nombre, apellido, telefono, iglesia, passw, estatus)VALUES(DEFAULT, :rol, :ced, :nom, :ape, :tlf, :iglesia, :passw, 1)";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":ced",$this->cedula);
					$strExe->bindValue(":rol",$this->rol);
					$strExe->bindValue(":nom",$this->nombre);
					$strExe->bindValue(":ape",$this->apellido);
					$strExe->bindValue(":tlf",$this->telefono);
					$strExe->bindValue(":iglesia",$this->iglesia);
					$strExe->bindValue(":passw",$this->password);
					$strExe->execute();
					$this->id = Conexion::getLastId("tusers","id");
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
				$query = "SELECT id, rol, cedula, nombre, apellido, telefono, iglesia, passw, estatus FROM tusers WHERE estatus = 1 ORDER BY nombre ASC";
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

		
		public function ConsultarSesion(){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "SELECT id, rol, cedula, nombre, apellido, telefono, iglesia, passw, estatus FROM tusers WHERE estatus = 1 and cedula=:cedula and passw=:pass ORDER BY nombre ASC";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":cedula",$this->cedula);
					$strExe->bindValue(":pass",$this->password);
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
						$query = "SELECT id, rol, cedula, nombre, apellido, telefono, iglesia, passw, estatus FROM tusers WHERE estatus = 1 and id=:id ORDER BY nombre ASC";
						$strExe = Conexion::prepare($query);
						$strExe->bindValue(":id",$this->id);
					}
					if($opcion=="cedula"){
						$query = "SELECT id, rol, cedula, nombre, apellido, telefono, iglesia, passw, estatus FROM tusers WHERE estatus = 1 and cedula=:cedula ORDER BY nombre ASC";
						$strExe = Conexion::prepare($query);
						$strExe->bindValue(":cedula",$this->cedula);
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
					$query = "UPDATE tusers SET rol=:rol, cedula=:ced, nombre=:nom, apellido=:ape, telefono=:tlf, iglesia=:iglesia, passw=:passw, estatus=1 WHERE id = :id";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":ced",$this->cedula);
					$strExe->bindValue(":rol",$this->rol);
					$strExe->bindValue(":nom",$this->nombre);
					$strExe->bindValue(":ape",$this->apellido);
					$strExe->bindValue(":tlf",$this->telefono);
					$strExe->bindValue(":iglesia",$this->iglesia);
					$strExe->bindValue(":passw",$this->password);
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

		public function eliminarPersona(){
			if(Conexion::getEstatusConexion()) {
				// $query = "DELETE FROM tusers WHERE id = :id";
				$query = "UPDATE tusers SET estatus=0 WHERE id = :id";
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