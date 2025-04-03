<?php
class CompeticionData {
    public static $tablename = "competicion";
        public $id;
		public $padre_competicion;
		public $tipocompeticion;
		public $nombregrupo;
		public $tipoascenso;
		public $rondas;
		public $jornadas;
		public $cantidajugadores;
		public $grupo;
        public $count;
        public $total;
        public $liganombre;
        public $tipocompinombre;
        public $padreliga;
        public $codigo;
        public function registro(){
            $sql = "insert into ".self::$tablename." (padre_competicion,tipocompeticion,nombregrupo,tipoascenso,rondas,jornadas,cantidajugadores,grupo) ";
            $sql .= "value (\"$this->padre_competicion\",\"$this->tipocompeticion\",\"$this->nombregrupo\",\"$this->tipoascenso\",\"$this->rondas\",\"$this->jornadas\",\"$this->cantidajugadores\",\"$this->grupo\")";
            return Executor::doit($sql);
        }
        public function actualizar1(){
            $sql = "update ".self::$tablename." set tipocompeticion=\"$this->tipocompeticion\", tipoascenso=\"$this->tipoascenso\", rondas=\"$this->rondas\", jornadas=\"$this->jornadas\", cantidajugadores=\"$this->cantidajugadores\", grupo=\"$this->grupo\" where id=$this->id";
            Executor::doit($sql);
        }
        public function actualizar2(){
            $sql = "update ".self::$tablename." set tipocompeticion=\"$this->tipocompeticion\", tipoascenso=\"$this->tipoascenso\", rondas=\"$this->rondas\", nombregrupo=\"$this->nombregrupo\", cantidajugadores=\"$this->cantidajugadores\", grupo=\"$this->grupo\" where id=$this->id";
            Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new CompeticionData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select  c.*, l.nombre as liganombre, t.nombre as tipocompinombre, p.liga as padreliga, l.codigo from ".self::$tablename." c JOIN padre_competicion p ON p.id=c.padre_competicion JOIN liga l ON l.id=p.liga JOIN tipocompeticiones t ON t.id=c.tipocompeticion ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompeticionData());
        }
        public static function vercontenidos($padre_competicion){
            $sql = "select  c.*, l.nombre as liganombre, t.nombre as tipocompinombre, p.liga as padreliga, l.codigo from ".self::$tablename." c JOIN padre_competicion p ON p.id=c.padre_competicion JOIN liga l ON l.id=p.liga JOIN tipocompeticiones t ON t.id=c.tipocompeticion where c.padre_competicion=$padre_competicion ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompeticionData());
        }
        public static function vercontenidos_lista($liga){
            $sql = "select  c.*, l.nombre as liganombre, t.nombre as tipocompinombre, p.liga as padreliga, l.codigo from ".self::$tablename." c JOIN padre_competicion p ON p.id=c.padre_competicion JOIN liga l ON l.id=p.liga JOIN tipocompeticiones t ON t.id=c.tipocompeticion where p.liga=$liga ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompeticionData());
        }
        public static function duplicidadd($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new CompeticionData();
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
            $sql = "SELECT c.*, l.nombre as liganombre, t.nombre as tipocompinombre, p.liga as padreliga, l.codigo FROM ".self::$tablename;
            $sql .= " c JOIN padre_competicion p ON p.id=c.padre_competicion JOIN liga l ON l.id=p.liga JOIN tipocompeticiones t ON t.id=c.tipocompeticion";
            if ($search) {
                $sql .= " WHERE c.nombregrupo LIKE '%$search%'";
            }
            $sql .= " order by c.id desc ";
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new CompeticionData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new CompeticionData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombregrupo LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new CompeticionData());
            return $result->total;
        }
    }
?>