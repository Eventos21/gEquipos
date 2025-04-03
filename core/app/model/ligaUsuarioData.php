<?php
class ligaUsuarioData {
    public static $tablename = "liga_club";
        public $id;
        public $liga;
        public $club;
        public $cantidad;

        public $count;
        public $total;
        public $nombre;


        public $id1;
        public $id2;
        public $telefono;
        public $correo;
        public $clubes;
        public $estado;
        public $cantidades;
        public $direccion ;
        public $responsable ;
        public $codigo ;
        public $cantidadequipo ;
        public function registro(){
            $sql = "insert into ".self::$tablename." (liga,club,cantidad) ";
            $sql .= "value (\"$this->liga\",\"$this->club\",\"$this->cantidad\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set cantidad=\"$this->cantidad\" where id=$this->id ";
            return Executor::doit($sql);
        }
        public function actualizar_cantidad(){
            $sql = "update ".self::$tablename." set cantidad=\"$this->cantidad\" where id=$this->id ";
            return Executor::doit($sql);
        }
        public static function verid_lista($liga, $club){
            $sql = "SELECT *, IFNULL(cantidad, 0) AS cantidad FROM " . self::$tablename . " WHERE liga = $liga AND club = $club";
            $query = Executor::doit($sql);
            return Model::one($query[0], new ligaUsuarioData());
        }
        public static function id($id){
            $sql = "select * from ".self::$tablename." where id=$id ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new ligaUsuarioData());
        }
        // public static function verid_lista($liga, $club){
        //     $sql = "select * from ".self::$tablename." where liga=$liga AND club=$club";
        //     $query = Executor::doit($sql);
        //     return Model::many($query[0],new ligaUsuarioData());
        // }
        public static function duplicidad($liga, $club){
        $sql = "select * from ".self::$tablename." where liga=\"$liga\" AND club=\"$club\" ";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new ligaUsuarioData();
            $array[$cnt]->liga = $r['liga'];
            $array[$cnt]->club = $r['club'];
            $cnt++;
            }
            return $array;
        }
        public static function evitarladuplicidad($liga, $club, $id){
            $sql = "select * from ".self::$tablename." where liga=\"$liga\" AND club=\"$club\" AND id!=\"$id\"";
            $query = Executor::doit($sql);
            $result = $query[0]->fetch_array();
            if($result){
                return true;
            }else{
                return false;
            }
        }     
        public static function vercontenidoPaginado1($liga, $start, $length, $search = ''){
            $sql = "SELECT c.id, c.nombre, c.telefono, c.correo, c.direccion, c.responsable, c.codigo, c.cantidadequipo, ";
            $sql .= " lc.cantidad as cantidades, lc.liga as id1, lc.id as id2 ";
            $sql .= " FROM club c ";
            $sql .= " LEFT JOIN liga_club lc ON lc.club = c.id AND lc.liga = $liga ";  // LEFT JOIN para traer todos los clubes
            $sql .= " WHERE c.estado = 1 ";  // Filtrar solo los clubes activos

            // Filtro de búsqueda opcional
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%' ";
            }

            // Ordenar por nombre y limitar los resultados para paginación
            $sql .= " ORDER BY c.nombre ";
            $sql .= " LIMIT $start, $length";

            // Ejecutar la consulta
            $query = Executor::doit($sql);
            return Model::many($query[0], new ligaUsuarioData());
        }


        public static function totalRegistro1($liga){
            $sql = "SELECT COUNT(*) as total FROM club WHERE estado = 1";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ligaUsuarioData());
            return $result->total;
        }

        public static function totalRegistrosFiltrados1($liga, $search){
            $sql = "SELECT COUNT(*) as total FROM club c ";
            $sql .= " LEFT JOIN liga_club lc ON lc.club = c.id AND lc.liga = $liga ";
            $sql .= " WHERE c.estado = 1";

            // Filtro de búsqueda opcional
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }

            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ligaUsuarioData());
            return $result->total;
        }



    }
?>