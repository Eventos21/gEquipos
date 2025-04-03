<?php
class ValorEquipoData {
    public static $tablename = "valor_equipo";
        public $id;
        public $liga;
        public $equipo;
        public $valor;
        public $count;
        public $total;
        public $nombre;
        public $sala;
        public $competicion;
        public $nombregrupo;
        public function registro(){
            $sql = "insert into ".self::$tablename." (liga,equipo,valor,sala,competicion) ";
            $sql .= "value (\"$this->liga\",\"$this->equipo\",\"$this->valor\",\"$this->sala\",\"$this->competicion\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set sucursal=\"$this->sucursal\", nombre=\"$this->nombre\", duplicidad=\"$this->duplicidad\" where id=$this->id";
            Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new ValorEquipoData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido($liga){
            $sql = "select c.*, e.nombre from ".self::$tablename." c JOIN equipo e ON e.id=c.equipo  WHERE c.liga=$liga ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ValorEquipoData());
        }
        public static function vercontenido_sala($sala){
            $sql = "select c.*, e.nombre, co.nombregrupo from ".self::$tablename." c JOIN equipo e ON e.id=c.equipo JOIN competicion co ON co.id=c.competicion  WHERE c.sala=$sala ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ValorEquipoData());
        }
        public static function duplicidadd($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new ValorEquipoData();
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
            return Model::many($query[0], new ValorEquipoData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ValorEquipoData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ValorEquipoData());
            return $result->total;
        }
    }
?>