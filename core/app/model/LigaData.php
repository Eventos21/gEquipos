<?php
    class LigaData {
        public static $tablename = "liga";
        public $id;
        public $temporada;
        public $nombre;
        public $fechainicio;
        public $fechafinal;
        public $fechafinalmodificacion;
        public $responsable;
        public $minimo;
        public $maximo;
        public $categoria;
        public $grupo;
        public $edad;
        public $orden;
        public $estado;
        public $usuario;
        public $fecha;
        public $count;
        public $total;
        public $temporadas;
        public $codigo;
        public function registro(){
            $sql = "insert into ".self::$tablename." (temporada,nombre,fechainicio,fechafinal,fechafinalmodificacion,minimo,maximo,edad,categoria,orden,grupo,usuario,estado,fecha) ";
            $sql .= "value (\"$this->temporada\",\"$this->nombre\",\"$this->fechainicio\",\"$this->fechafinal\",\"$this->fechafinalmodificacion\",\"$this->minimo\",\"$this->maximo\",\"$this->edad\",\"$this->categoria\",\"$this->orden\",\"$this->grupo\",\"$this->usuario\",1,NOW())";
            return Executor::doit($sql);
        }
        public function registro_liga(){
            $sql = "insert into ".self::$tablename." (temporada,nombre,usuario,estado,fecha,codigo) ";
            $sql .= "value (\"$this->temporada\",\"$this->nombre\",\"$this->usuario\",1,NOW(),\"$this->codigo\")";
            return Executor::doit($sql);
        }

        public function actualizar(){
            $sql = "update ".self::$tablename." set temporada=\"$this->temporada\",nombre=\"$this->nombre\",fechainicio=\"$this->fechainicio\",fechafinal=\"$this->fechafinal\",fechafinalmodificacion=\"$this->fechafinalmodificacion\",minimo=\"$this->minimo\",maximo=\"$this->maximo\",edad=\"$this->edad\",categoria=\"$this->categoria\",orden=\"$this->orden\",grupo=\"$this->grupo\",estado=\"$this->estado\" where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select c.*, t.nombre as temporadas from ".self::$tablename." c JOIN temporada as t ON t.id=c.temporada where c.id=$id ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new LigaData());
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
            $array[$cnt] = new LigaData();
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
            return Model::many($query[0],new LigaData());
        }
        public static function vercontenidos(){
            $sql = "select l.* from ".self::$tablename." l JOIN temporada t ON t.id=l.temporada where t.estado=1 and t.archivado=1 ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new LigaData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, t.nombre as temporadas FROM ".self::$tablename;
            $sql .= " c JOIN temporada t ON t.id =c.temporada  ";
            $sql .= " WHERE t.estado=1  ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new LigaData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new LigaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new LigaData());
            return $result->total;
        }
    }
?>