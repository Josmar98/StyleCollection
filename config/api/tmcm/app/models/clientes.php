<?php 

	if(is_file('config/database.php')){
		require_once'config/database.php';
	}
	if(is_file('../config/database.php')){
		require_once'../config/database.php';
	}
	class Clientes extends Conexion{
		private $id_cliente;
		private $id_liderazgo;
		private $primerNombre;
		private $segundoNombre;
		private $primerApellido;
		private $segundoApellido;
		private $cedula;
		private $sexo;
		private $fechaNacimiento;
		private $telefono;
		private $correo;
		private $codRif;
		private $rif;
		private $direccion;

		public function setIdCliente($val){$this->id_cliente = $val;}
		public function setIdLiderazgo($val){$this->id_liderazgo = $val;}
		public function setPrimerNombre($val){$this->primerNombre = $val;}
		public function setSegundoNombre($val){$this->segundoNombre = $val;}
		public function setPrimerApellido($val){$this->primerapellido = $val;}
		public function setSegundoApellido($val){$this->segundoapellido = $val;}
		public function setCedula($val){$this->cedula = $val;}
		public function setSexo($val){$this->sexo = $val;}
		public function setFechaNacimiento($val){$this->fechanacimiento = $val;}
		public function setTelefono($val){$this->telefono = $val;}
		public function setCorreo($val){$this->correo = $val;}
		public function setCodRif($val){$this->codRif = $val;}
		public function setRif($val){$this->rif = $val;}
		public function setDireccion($val){$this->direccion = $val;}

		public function getIdCliente(){ return $this->id_cliente;}
		public function getIdLiderazgo(){ return $this->id_liderazgo;}
		public function getPrimerNombre(){ return $this->primerNombre;}
		public function getSegundoNombre(){ return $this->segundoNombre;}
		public function getPrimerApellido(){ return $this->primerapellido;}
		public function getSegundoApellido(){ return $this->segundoapellido;}
		public function getCedula(){ return $this->cedula;}
		public function getSexo(){ return $this->sexo;}
		public function getFechaNacimiento(){ return $this->fechanacimiento;}
		public function getTelefono(){ return $this->telefono;}
		public function getCorreo(){ return $this->correo;}
		public function getCodRif(){ return $this->codRif;}
		public function getRif(){ return $this->rif;}
		public function getDireccion(){ return $this->direccion;}

		public function __construct(){Conexion::realizarConexion();}

		public function registrarCliente($query){
			if(Conexion::getEstatusConexion()){
				try{
					// $query = "INSERT INTO personas( nombre, apellido, cedula, sexo, fechanacimiento, altura, peso, enfermedades, alergias, direccion, estatus)
					// VALUES( :nom, :ape, :ced, :sex, :fecha, :alt, :peso, :enf, :alerg, :dir, 1)";
					$strExe = Conexion::prepare($query);
					// $strExe->bindValue(":nom",$data['nombre']);
					// $strExe->bindValue(":ape",$data['apellido']);
					// $strExe->bindValue(":ced",$data['cedula']);
					// $strExe->bindValue(":sex",$data['sexo']);
					// $strExe->bindValue(":fecha",$data['fechaNacimiento']);
					// $strExe->bindValue(":alt",$data['altura']);
					// $strExe->bindValue(":peso",$data['peso']);
					// $strExe->bindValue(":enf",$data['enfermedades']);
					// $strExe->bindValue(":alerg",$data['alergias']);
					// $strExe->bindValue(":dir",$data['direccion']);
					$strExe->execute();
					$this->id_cliente = Conexion::getLastId("clientes","id_cliente");
					return ['ejecucion' => true, 'id_cliente'=>$this->id_cliente];
				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}

		public function registrarGruposPersonas($id_persona, $id_grupo, $nombre_rol){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "INSERT INTO grupos_personas( id_persona, id_grupo, nombre_rol, estatus)
					VALUES( :id_persona, :id_grupo, :nombre_rol, 1)";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":id_persona",$id_persona);
					$strExe->bindValue(":id_grupo",$id_grupo);
					$strExe->bindValue(":nombre_rol",$nombre_rol);
					$strExe->execute();
					$id_grupo = Conexion::getLastId("grupos_personas","id_grupos_personas");
					return ['ejecucion' => true, 'id_grupos_personas'=>$id_grupo];
				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}


		public function consultarPersonas(){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT id_persona, nombre, apellido, cedula, sexo, fechanacimiento, altura, peso, enfermedades, alergias, direccion, estatus FROM personas WHERE estatus = 1 ORDER BY personas.nombre ASC";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->execute();
					$todo = $strExe->fetchAll();
					$todo += ['ejecucion'=>true];
					if(!empty($todo[0])){
						return $todo;
					}else{
						return ['ejecucion'=>true];
					}

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}


		public function consultarPersonasRoles(){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT DISTINCT personas.id_persona, personas.nombre, personas.apellido, personas.cedula, personas.estatus, grupos_personas.nombre_rol 
						FROM personas, grupos_personas 
						WHERE personas.id_persona=grupos_personas.id_persona and personas.estatus = 1 ORDER BY personas.nombre ASC";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->execute();
					$todo = $strExe->fetchAll();
					$todo += ['ejecucion'=>true];
					if(!empty($todo[0])){
						return $todo;
					}else{
						return ['ejecucion'=>true];
					}

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}


		public function consultarPersonasGrupos(){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT personas.id_persona, personas.nombre, personas.apellido, personas.cedula, personas.sexo, personas.fechanacimiento, personas.altura, personas.peso, personas.enfermedades, personas.alergias, personas.direccion, personas.estatus, grupos_personas.nombre_rol, grupos.id_grupo, grupos.nombre_grupo, grupos.descripcion_grupo 
					FROM personas, grupos_personas, grupos 
					WHERE personas.id_persona=grupos_personas.id_persona and grupos_personas.id_grupo=grupos.id_grupo and personas.estatus = 1 ORDER BY personas.nombre ASC";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->execute();
					$todo = $strExe->fetchAll();
					$todo += ['ejecucion'=>true];
					if(!empty($todo[0])){
						return $todo;
					}else{
						return ['ejecucion'=>true];
					}

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}
		
		public function consultarPersona($data){
			if(Conexion::getEstatusConexion()){
				$query = "SELECT id_persona, nombre, apellido, cedula, sexo, fechanacimiento, estatus FROM personas WHERE cedula = :ced";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":ced",$data['cedula']);
					$strExe->execute();
					$todo = $strExe->fetchAll();
					$todo += ['ejecucion'=>true];
					if(!empty($todo[0])){
						return $todo;
					}else{
						return ['ejecucion'=>true];
					}

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}

		// public function consultarPersona(){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "SELECT * FROM personas,roles,grupos,usuarios WHERE personas.cedula = usuarios.fk_cedula  and personas.rol = roles.id_rol and personas.grupo = grupos.id_grupo and personas.cedula = :ced";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":ced",$this->cedula);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function consultarPersonasGrup(){//creando aun la condicion para saber como se hara
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "SELECT * FROM personas,roles_personas,roles WHERE personas.cedula = roles_personas.fk_cedula and roles_personas.id_rol = roles.id_rol ORDER BY personas.nombre ASC";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function consultarPersonasGrupComp($col, $val){//creando aun la condicion para saber como se hara
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "SELECT * FROM personas,roles_personas,roles WHERE personas.cedula = roles_personas.fk_cedula and roles_personas.id_rol = roles.id_rol and ".$col." = :val ORDER BY personas.nombre ASC";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":val",$val);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function verificarPersonas($cedula){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "SELECT * FROM personas WHERE cedula = :cedula";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":cedula",$cedula);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function detallesPersonas($cedula){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "SELECT * FROM personas NATURAL JOIN roles_personas WHERE cedula = :cedula";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":cedula",$cedula);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function consultarAllPersonas(){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "SELECT * FROM personas,roles_personas,roles,grupo_rp,grupos WHERE roles_personas.fk_cedula = personas.cedula and roles_personas.id_rol = roles.id_rol and roles_personas.id_rp = grupo_rp.id_rp and grupo_rp.id_grupo = grupos.id_grupo ORDER BY personas.nombre ASC";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function consultarEdades(){
		// 	if(Conexion::getEstatusConexion()){
		// 	$query="SELECT * FROM personas";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->execute();
		// 			$todo = $strExe->fetchAll();
		// 			if(!empty($todo[0])){
		// 				return $todo;
		// 			}else{
		// 				return false;
		// 			}

		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function actualizarEdades($edad,$cedula){
		// 	if(Conexion::getEstatusConexion()){
		// 		try{
		// 			$query="UPDATE personas SET edad = :edad WHERE cedula = :ced";
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":edad",$edad);
		// 			$strExe->bindValue(":ced",$cedula);
		// 			$strExe->execute();

		// 			$query="UPDATE respaldosp SET edad = :edad WHERE cedula = :ced";
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":edad",$edad);
		// 			$strExe->bindValue(":ced",$cedula);
		// 			$strExe->execute();
		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function rolAsignado($cedulti){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "UPDATE personas SET rol_stage = :asig WHERE cedula = :ced2";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":asig","asignado");
		// 			$strExe->bindValue(":ced2",$cedulti);

		// 			$strExe->execute();
		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function rolNoAsignado($cedulti){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "UPDATE personas SET rol_stage = :asig WHERE cedula = :ced2";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":asig","");
		// 			$strExe->bindValue(":ced2",$cedulti);

		// 			$strExe->execute();
		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		// public function grupoAsignado($id_rp){
		// 	if(Conexion::getEstatusConexion()){
		// 		$query = "UPDATE roles_personas SET grupo_stage = :asig WHERE id_rp = :id";
		// 		try{
		// 			$strExe = Conexion::prepare($query);
		// 			$strExe->bindValue(":asig","asignado");
		// 			$strExe->bindValue(":id",$id_rp);

		// 			$strExe->execute();
		// 		}catch(PDOException $e){
		// 			return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '$e];
		// 			// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 			// echo "El Error es: ".$e;
		// 		}
		// 	}else{
		// 			return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '$e];
		// 		// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
		// 	}
		// }
		public function modificarPersona($cedulti){
			if(Conexion::getEstatusConexion()){
				try{
					$query = "UPDATE personas SET nombre = :nom, apellido = :ape, nacionalidad = :nac, cedula = :ced, fechanacimiento = :fecha, edad = :edad, sexo = :sex, talla = :talla, peso = :peso, direccion = :dir, enfermedades = :enf, alergias = :alerg WHERE cedula = :ced2";
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":nom",$this->nombre);
					$strExe->bindValue(":ape",$this->apellido);
					$strExe->bindValue(":nac",$this->nacionalidad);
					$strExe->bindValue(":ced",$this->cedula);
					$strExe->bindValue(":fecha",$this->fechanacimiento);
					$strExe->bindValue(":edad",$this->edad);
					$strExe->bindValue(":sex",$this->sexo);
					$strExe->bindValue(":talla",$this->talla);
					$strExe->bindValue(":peso",$this->peso);
					$strExe->bindValue(":dir",$this->direccion);
					$strExe->bindValue(":enf",$this->enfermedades);
					$strExe->bindValue(":alerg",$this->alergias);
					$strExe->bindValue(":ced2",$cedulti);
					$strExe->execute();

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}

		public function eliminarPersona(){
			if(Conexion::getEstatusConexion()) {
				$query = "DELETE FROM personas WHERE cedula = :ci";
				try{
					$strExe = Conexion::prepare($query);
					$strExe->bindValue(":ci",$this->cedula);
					$strExe->execute();
				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}
	}

?>