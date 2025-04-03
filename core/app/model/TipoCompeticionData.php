<?php
    class TipoCompeticionData {
        public static $tablename = "tipocompeticiones";
        public $id;
        public $duplicidad;
        public $nombre;
        public $count;
        public $total;
        public function registro(){
            $sql = "insert into ".self::$tablename." (duplicidad,nombre) ";
            $sql .= "value (\"$this->duplicidad\",\"$this->nombre\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set duplicidad=\"$this->duplicidad\",nombre=\"$this->nombre\" where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select c.* from ".self::$tablename." c where c.id=$id ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new TipoCompeticionData());
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
            $array[$cnt] = new TipoCompeticionData();
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
            return Model::many($query[0],new TipoCompeticionData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.* FROM ".self::$tablename;
            $sql .= " c  ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new TipoCompeticionData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new TipoCompeticionData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new TipoCompeticionData());
            return $result->total;
        }
    }
?>