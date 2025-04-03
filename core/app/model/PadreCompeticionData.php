<?php
class PadreCompeticionData {
    public static $tablename = "padre_competicion";
        public $id;
        public $tipoascenso;
        public $liga;
        public $cantidad;
        public $fecha;
        public $count;
        public $total;
        public $max_id;
        public $nombreliga;
        public function registro(){
            $sql = "insert into ".self::$tablename." (tipoascenso,liga,cantidad,fecha) ";
            $sql .= "value (\"$this->tipoascenso\",\"$this->liga\",\"$this->cantidad\",NOW())";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set tipoascenso=\"$this->tipoascenso\", liga=\"$this->liga\", cantidad=\"$this->cantidad\" where id=$this->id";
            Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select c.*, l.nombre as nombreliga from ".self::$tablename." c JOIN liga l ON l.id=c.liga where c.id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new PadreCompeticionData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new PadreCompeticionData());
        }
        public static function vertotal($liga){
            $sql = "select * from ".self::$tablename." where liga=$liga ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new PadreCompeticionData());
        }
        public static function vertotalmax($liga) {
		    $sql = "SELECT MAX(id) as max_id FROM " . self::$tablename . " WHERE liga=$liga";
		    $query = Executor::doit($sql);
		    $result = Model::one($query[0], new PadreCompeticionData());
		    return $result ? $result->max_id : null;
		}
        public static function duplicidadd($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new PadreCompeticionData();
            $array[$cnt]->duplicidad = $r['duplicidad'];
            $cnt++;
            }
            return $array;
        }
        public static function evitarladuplicidad($duplicidad, $id){
            $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\" AND id!=\"$id\"";
            $query = Executor::doit($sql);
            $result = $query[0]->fetch_array();
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, s.nombre as sucursales FROM ".self::$tablename;
            $sql .= " c LEFT JOIN sucursal s ON s.id=c.sucursal";
            if ($search) {
                $sql .= " WHERE c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new PadreCompeticionData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new PadreCompeticionData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new PadreCompeticionData());
            return $result->total;
        }
    }
?>