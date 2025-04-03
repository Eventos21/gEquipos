<?php
    class ResultadoData {
        public static $tablename = "resultado";
        public $id;
        public $fecha;
        public $tipo;
        public $count;
        public $total;
        public $resultado;
        public $numero;
        public $equipo;
        public $puntos;
        public $progresivo;
        public $buchholz_1;
        public $buchholz;
        public $mediano_buchholz;
        public $olimpico;
        public function registro(){
            $sql = "insert into ".self::$tablename." (fecha,tipo) ";
            $sql .= "value (\"$this->fecha\",\"$this->tipo\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set duplicidad=\"$this->duplicidad\",nombre=\"$this->nombre\" where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select c.* from ".self::$tablename." c where c.id=$id ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new ResultadoData());
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
            $array[$cnt] = new ResultadoData();
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
            return Model::many($query[0],new ResultadoData());
        }
        public static function vercontenidos1(){
            $sql = " SELECT dr.*
                    FROM detalleresultado dr
                    WHERE dr.resultado = (
                        SELECT MAX(r.id)
                        FROM resultado r
                        WHERE r.tipo = 'RA'
                    )";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ResultadoData());
        }
        public static function vercontenidos2(){
            $sql = " SELECT dr.*
                    FROM detalleresultado dr
                    WHERE dr.resultado = (
                        SELECT MAX(r.id)
                        FROM resultado r
                        WHERE r.tipo = 'RB'
                    )";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ResultadoData());
        }
        public static function vercontenidos3(){
            $sql = " SELECT dr.*
                    FROM detalleresultado dr
                    WHERE dr.resultado = (
                        SELECT MAX(r.id)
                        FROM resultado r
                        WHERE r.tipo = 'SB16'
                    )";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ResultadoData());
        }
        public static function vercontenidos4(){
            $sql = " SELECT dr.*
                    FROM detalleresultado dr
                    WHERE dr.resultado = (
                        SELECT MAX(r.id)
                        FROM resultado r
                        WHERE r.tipo = 'SB12'
                    )";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ResultadoData());
        }
        public static function vercontenidos5(){
            $sql = " SELECT dr.*
                    FROM detalleresultado dr
                    WHERE dr.resultado = (
                        SELECT MAX(r.id)
                        FROM resultado r
                        WHERE r.tipo = 'S'
                    )";
            $query = Executor::doit($sql);
            return Model::many($query[0],new ResultadoData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.* FROM ".self::$tablename;
            $sql .= " c  ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new ResultadoData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ResultadoData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ResultadoData());
            return $result->total;
        }
    }
?>