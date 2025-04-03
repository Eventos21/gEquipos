<?php
class UserData {
    public static $tablename = "usuario";
    public $id;
    public $nombre;
    public $apellido;
    public $ci;
    public $telefono;
    public $fecha_nacimiento;
    public $imagen;
    public $sexo;
    public $email;
    public $usuario;
    public $password;
    public $fecha;
    public $fecha_modificacion;
    public $estado;
    public $cargo;
    public $token;
    public $club;
    public $clubs;
    

    public $count;
    public $total;
    public $cargos;

        public function registro(){
            $carguito = ($this->cargo == null || $this->cargo == 0) ? 'NULL' : '"' . $this->cargo . '"';
            $clubcito = ($this->club == null || $this->club == 0) ? 'NULL' : '"' . $this->club . '"';
                $sql = "insert into ".self::$tablename." (cargo, club, nombre, apellido, ci, telefono, email, imagen, fecha_nacimiento, fecha, estado, usuario, password) ";
                $sql .= "value ($carguito,$clubcito,\"$this->nombre\",\"$this->apellido\",\"$this->ci\",\"$this->telefono\",\"$this->email\",\"$this->imagen\",\"$this->fecha_nacimiento\",NOW(),0,\"$this->usuario\",\"$this->password\")";
                return Executor::doit($sql);
            }
        public function actualizar(){
            $carguito = ($this->cargo == null || $this->cargo == 0) ? 'NULL' : '"' . $this->cargo . '"';
            $clubcito = ($this->club == null || $this->club == 0) ? 'NULL' : '"' . $this->club . '"';
            $sql = "update ".self::$tablename." set nombre=\"$this->nombre\",apellido=\"$this->apellido\",ci=\"$this->ci\",telefono=\"$this->telefono\",email=\"$this->email\",club=$clubcito,cargo=$carguito,fecha_nacimiento=\"$this->fecha_nacimiento\",imagen=\"$this->imagen\",estado=\"$this->estado\",fecha_modificacion=NOW()  where id=$this->id";
           return Executor::doit($sql);
        }
        public function actualizarusuario(){
            $sql = "update ".self::$tablename." set usuario=\"$this->usuario\",fecha_modificacion=NOW()  where id=$this->id";
           return Executor::doit($sql);
        }
        public function actualizarpassword(){
            $sql = "update ".self::$tablename." set password=\"$this->password\",fecha_modificacion=NOW()  where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
                $sql = "select * from ".self::$tablename." where id=$id";
                $query = Executor::doit($sql);
                return Model::one($query[0],new UserData());
            }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function duplicidad($ci){
            $sql = "select * from ".self::$tablename." where ci=\"$ci\"";
            $query = Executor::doit($sql);
            $array = array();
            $cnt = 0;
            while($r = $query[0]->fetch_array()){
                $array[$cnt] = new UserData();
                $array[$cnt]->ci = $r['ci'];
                $cnt++;
                }
                return $array;
        }
        public static function getDNI($rut, $excludeId = null) {
            $sql = "SELECT * FROM ".self::$tablename." WHERE rut = ?";  
            $params = [$rut];
            if ($excludeId !== null) {
                $sql .= " AND id != ?"; 
                $params[] = $excludeId;
            }
            $query = Executor::doit($sql, $params);
            $numRows = $query->num_rows;
            return $numRows > 0;
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename." where estado=1 ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new UserData());
        }
        public static function vercontenido1($id){
            $sql = "select * from ".self::$tablename." where id=$id and estado=1 ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new UserData());
        }
        public static function vercontenido_x_club($club){
            $sql = "select * from ".self::$tablename." where estado=1 AND club=$club ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new UserData());
        }
        public static function vercontenidos(){
            $sql = "select * from ".self::$tablename." WHERE estado=1";
            $query = Executor::doit($sql);
            return Model::many($query[0],new UserData());
        }
        public static function evitarladuplicidad($ci, $id){
            $sql = "select * from ".self::$tablename." where ci=\"$ci\" AND id!=\"$id\"";
            $query = Executor::doit($sql);
            $result = $query[0]->fetch_array();
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT u.*, c.nombre as cargos, cl.nombre as clubs FROM ".self::$tablename;
            $sql .= " u LEFT JOIN cargo c ON c.id=u.cargo LEFT JOIN club cl ON cl.id=u.club ";
            if ($search) {
                $sql .= " WHERE u.nombre LIKE '%$search%' OR u.ci LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new UserData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new UserData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%' OR ci LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new UserData());
            return $result->total;
        }
    }
?>