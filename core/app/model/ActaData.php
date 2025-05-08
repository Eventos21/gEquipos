<?php
#[\AllowDynamicProperties]
class ActaData {
    public static $tablename = "acta";
        public $id;
        public $competencias;
        public $equipo;
        public $jugador;
        public $resultado;
        public $total;
        public $jugadores;
        public $orden;
        public $codigofide;
        public $sala_personalizada;
        public function registro(){
            $jugador = ($this->jugador == null || $this->jugador == 0) ? 'NULL' : '"' . $this->jugador . '"';
            $sql = "insert into ".self::$tablename." (competencias,equipo,jugador) ";
            $sql .= "value (\"$this->competencias\",\"$this->equipo\",$jugador)";
            return Executor::doit($sql);
        }
        public function registro1(){
            $jugador = ($this->jugador == null || $this->jugador == 0) ? 'NULL' : '"' . $this->jugador . '"';
            $sql = "insert into ".self::$tablename." (sala_personalizada,equipo,jugador) ";
            $sql .= "value (\"$this->sala_personalizada\",\"$this->equipo\",$jugador)";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set sucursal=\"$this->sucursal\", nombre=\"$this->nombre\", duplicidad=\"$this->duplicidad\" where id=$this->id";
            Executor::doit($sql);
        }
        public function actualizar_resultado() {
            $sql = "UPDATE " . self::$tablename . " SET resultado=\"$this->resultado\" WHERE id=$this->id";
            Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new ActaData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new ActaData());
        }
        public static function vercontenidos($competencias,$equipo){
            $sql = "select c.*, CONCAT(j.nombre, ' ',j.apellido1, ' ',j.apellido2) as jugadores, j.codigofide from ".self::$tablename." c LEFT JOIN jugador j ON j.id=c.jugador where c.competencias=$competencias and c.equipo=$equipo ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ActaData());
        }
        public static function vercontenidos1($sala_personalizada, $equipo) {
            $sql = "SELECT c.*, 
                           CONCAT(j.apellido1, ' ', j.apellido2, ', ', j.nombre) AS jugadores, 
                           j.codigofide, 
                           ej.orden 
                    FROM " . self::$tablename . " c 
                    LEFT JOIN jugador j ON j.id = c.jugador 
                    LEFT JOIN equipo_jugador ej ON ej.jugador = c.jugador AND ej.equipo = c.equipo 
                    WHERE c.sala_personalizada = $sala_personalizada 
                      AND c.equipo = $equipo 
                    ORDER BY c.id ASC";
            $query = Executor::doit($sql);
            return Model::many($query[0], new ActaData());
        }
        public static function duplicidadd($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new ActaData();
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
            return Model::many($query[0], new ActaData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ActaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ActaData());
            return $result->total;
        }
    }
?>