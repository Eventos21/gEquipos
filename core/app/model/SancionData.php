<?php
class SancionData {
    public static $tablename = "sancion";
        public $id;
        public $sala;
        public $equipo;
        public $sancion;
        public $count;
        public $total;
        public function registro(){
            $sql = "insert into ".self::$tablename." (sala,equipo,sancion) ";
            $sql .= "value (\"$this->sala\",\"$this->equipo\",\"$this->sancion\")";
            return Executor::doit($sql);
        }
        public static function duplicidad($sala,$equipo){
        $sql = "select * from ".self::$tablename." where sala=\"$sala\" AND equipo=\"$equipo\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new SancionData();
            $array[$cnt]->sala = $r['sala'];
            $array[$cnt]->equipo = $r['equipo'];
            $cnt++;
            }
            return $array;
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set sancion=\"$this->sancion\" where sala=$this->sala AND equipo=$this->equipo";
            Executor::doit($sql);
        }
        public static function evitarladuplicidad($sala,$equipo, $id){
            $sql = "select * from ".self::$tablename." where sala=\"$sala\" AND equipo=\"$equipo\" AND id!=\"$id\"";
            $query = Executor::doit($sql);
            $result = $query[0]->fetch_array();
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new SancionData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new SancionData());
        }
        public static function vercontenidos($sala,$equipo){
            $sql = "select * from ".self::$tablename." WHERE sala = $sala AND equipo=$equipo ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SancionData());
        }
        public static function verid1($sala,$equipo){
            $sql = "select * from ".self::$tablename." where sala = $sala AND equipo=$equipo";
            $query = Executor::doit($sql);
            return Model::one($query[0],new SancionData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, s.nombre as sucursales FROM ".self::$tablename;
            $sql .= " c LEFT JOIN sucursal s ON s.id=c.sucursal";
            if ($search) {
                $sql .= " WHERE c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SancionData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SancionData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SancionData());
            return $result->total;
        }
    }
?>