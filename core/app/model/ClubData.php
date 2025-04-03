<?php
    class ClubData {
        public static $tablename = "club";
        public $id;
        public $nombre;
        public $telefono;
        public $correo;
        public $direccion;
        public $responsable;
        public $estado;
        public $codigo;
        public $fecha;
        public $usuario;
        public $responsables;
        public $cantidadequipo;
        public $count;
        public $total;
        public function registro(){
            $sql = "insert into ".self::$tablename." (codigo,nombre,telefono,correo,direccion,responsable,usuario,estado,fecha,cantidadequipo) ";
            $sql .= "value (\"$this->codigo\",\"$this->nombre\",\"$this->telefono\",\"$this->correo\",\"$this->direccion\",\"$this->responsable\",\"$this->usuario\",1,NOW(),\"$this->cantidadequipo\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set nombre=\"$this->nombre\",telefono=\"$this->telefono\",correo=\"$this->correo\",direccion=\"$this->direccion\",responsable=\"$this->responsable\",estado=\"$this->estado\",cantidadequipo=\"$this->cantidadequipo\" where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new ClubData());
        }
        public static function verid1($codigo){
            $sql = "select * from ".self::$tablename." where codigo='$codigo' ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new ClubData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function duplicidad($codigo){
        $sql = "select * from ".self::$tablename." where codigo=\"$codigo\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new ClubData();
            $array[$cnt]->codigo = $r['codigo'];
            $cnt++;
            }
            return $array;
        }
        public static function evitarladuplicidad($codigo, $id){
            $sql = "select * from ".self::$tablename." where codigo=\"$codigo\" AND id!=\"$id\"";
            $query = Executor::doit($sql);
            $result = $query[0]->fetch_array();
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename." where estado=1 order by nombre asc ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ClubData());
        }
        public static function vercontenidos(){
            $sql = "select * from ".self::$tablename." WHERE estado=1";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ClubData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, CONCAT(u.nombre, ' ', u.apellido) as responsables FROM ".self::$tablename;
            $sql .= " c LEFT JOIN usuario u ON u.id=c.responsable ";
            if ($search) {
                $sql .= " WHERE c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new ClubData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ClubData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ClubData());
            return $result->total;
        }
        public static function vercontenidoPaginado1($responsable, $start, $length, $search = ''){
            $sql = "SELECT c.*, CONCAT(u.nombre, ' ', u.apellido) as responsables FROM ".self::$tablename;
            $sql .= " c LEFT JOIN usuario u ON u.id=c.responsable WHERE c.id=$responsable ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new ClubData());
        }
        public static function totalRegistro1($responsable){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE id=$responsable ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ClubData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados1($responsable, $search){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE id=$responsable ";
            if ($search) {
                $sql .= " AND nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ClubData());
            return $result->total;
        }
    }
?>