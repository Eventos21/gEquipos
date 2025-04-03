<?php
    class TemporadaData {
        public static $tablename = "temporada";
        public $id;
        public $nombre;
        public $inicio;
        public $limite;
        public $fin;
        public $usuario;
        public $estado;
        public $archivado;
        public $archivado1;
        public $duplicidad;
        public $fecha;
        public $actualizacion;
        public $count;
        public $total;
        public function registro(){
            $sql = "insert into ".self::$tablename." (nombre,inicio,fin,limite,usuario,estado,fecha,archivado,duplicidad) ";
            $sql .= "value (\"$this->nombre\",\"$this->inicio\",\"$this->fin\",\"$this->limite\",\"$this->usuario\",1,NOW(),1,\"$this->duplicidad\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set nombre=\"$this->nombre\",inicio=\"$this->inicio\",fin=\"$this->fin\",limite=\"$this->limite\",usuario=\"$this->usuario\",archivado=\"$this->archivado\" where id=$this->id";
           return Executor::doit($sql);
        }
        public function archivar(){
            $sql = "update ".self::$tablename." set estado=\"$this->estado\",archivado=\"$this->archivado\", archivado1=\"$this->archivado1\" where id=$this->id";
           return Executor::doit($sql);
        }
        public function desarchivar(){
            $sql = "update ".self::$tablename." set estado=\"$this->estado\",archivado=\"$this->archivado\" where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new TemporadaData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function duplicidad($nombre){
        $sql = "select * from ".self::$tablename." where nombre=\"$nombre\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new TemporadaData();
            $array[$cnt]->nombre = $r['nombre'];
            $cnt++;
            }
            return $array;
        }
        public static function evitarladuplicidad($nombre, $id){
            $sql = "select * from ".self::$tablename." where nombre=\"$nombre\" AND id!=\"$id\"";
            $query = Executor::doit($sql);
            $result = $query[0]->fetch_array();
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new TemporadaData());
        }
        public static function vercontenidos(){
            $sql = "select * from ".self::$tablename." where estado=1 AND archivado=1 ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new TemporadaData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.* FROM ".self::$tablename;
            $sql .= " c WHERE c.estado=1 ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new TemporadaData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE estado=1 " ;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new TemporadaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE estado=1 " ;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new TemporadaData());
            return $result->total;
        }
        public static function vercontenidoPaginado1($start, $length, $search = ''){
            $sql = "SELECT c.* FROM ".self::$tablename;
            $sql .= " c WHERE c.archivado1=1 ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new TemporadaData());
        }
        public static function totalRegistro1(){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE archivado1=1 " ;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new TemporadaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados1($search){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE archivado1=1 " ;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new TemporadaData());
            return $result->total;
        }
    }
?>