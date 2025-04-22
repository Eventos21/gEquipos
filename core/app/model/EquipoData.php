<?php
#[\AllowDynamicProperties]
    class EquipoData {
        public static $tablename = "equipo";
        public $id;
        public $liga;
        public $categoria;
        public $club;
        public $nombre;
        public $capitan;
        public $nacimiento1;
        public $subcapitan;
        public $nacimiento2;
        public $descripcion;
        public $duplicidad;
        public $usuario;
        public $estado;
        public $condicion;
        public $fecha;
        public $capitanes;
        public $subcapitanes;
        public $clubes;
        public $mensajefederacion;
        public $ligas;
        public $minimo;
        public $maximo;
        public $count;
        public $total;
        public $competicion;
        public $cantidad_jugadores;
        public $fechafinalmodificacion;
        public $orden;
        public $total_equipos;
        public $competiciones;
        public $validado;
        public function registro(){
            $sql = "insert into ".self::$tablename." (club,nombre,capitan,nacimiento1,subcapitan,nacimiento2,descripcion,usuario,estado,fecha,duplicidad,liga,competicion,validado) ";
            $sql .= "value (\"$this->club\",\"$this->nombre\",\"$this->capitan\",\"$this->nacimiento1\",\"$this->subcapitan\",\"$this->nacimiento2\",\"$this->descripcion\",\"$this->usuario\",1,NOW(),\"$this->duplicidad\",\"$this->liga\",\"$this->competicion\",\"$this->validado\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set club=\"$this->club\",condicion=\"$this->condicion\",nombre=\"$this->nombre\",capitan=\"$this->capitan\",nacimiento1=\"$this->nacimiento1\",subcapitan=\"$this->subcapitan\",nacimiento2=\"$this->nacimiento2\",descripcion=\"$this->descripcion\",liga=\"$this->liga\",competicion=\"$this->competicion\",\"$this->validado\") where id=$this->id";
           return Executor::doit($sql);
        }
        public function actualizar_mequipo(){
            $sql = "update ".self::$tablename." set club=\"$this->club\",capitan=\"$this->capitan\",nacimiento1=\"$this->nacimiento1\",subcapitan=\"$this->subcapitan\",nacimiento2=\"$this->nacimiento2\",descripcion=\"$this->descripcion\" where id=$this->id";
           return Executor::doit($sql);
        }
        public function cambioestado(){
            $sql = "update ".self::$tablename." set estado=\"$this->estado\" where id=$this->id";
           return Executor::doit($sql);
        }
        public function calificacion_federacion(){
            $sql = "update ".self::$tablename." set estado=\"$this->estado\", mensajefederacion=\"$this->mensajefederacion\" where id=$this->id";
           return Executor::doit($sql);
        }
        public function enviar_federacion(){
            $sql = "update ".self::$tablename." set estado=\"$this->estado\" where id=$this->id";
           return Executor::doit($sql);
        }
        // public function actualizar() {
        //     $subcapitanValue = ($this->subcapitan === "" || $this->subcapitan === "0") ? "NULL" : "\"$this->subcapitan\"";
        //     $sql = "update ".self::$tablename." set club=\"$this->club\",estado=\"$this->estado\",nombre=\"$this->nombre\",categoria=\"$this->categoria\",capitan=\"$this->capitan\",subcapitan=$subcapitanValue,descripcion=\"$this->descripcion\" where id=$this->id";
        //     return Executor::doit($sql);
        // }
        public static function verid($id){
            $sql = "SELECT c.*, comp.nombregrupo as competiciones,  ";
            $sql .= "CASE WHEN c.capitan REGEXP '^[0-9]+$' THEN CONCAT(u.nombre, ' ', u.apellido) ELSE c.capitan END as capitanes, ";
            $sql .= "CASE WHEN c.subcapitan REGEXP '^[0-9]+$' THEN CONCAT(us.nombre, ' ', us.apellido) ELSE c.subcapitan END as subcapitanes, ";
            $sql .= "cl.nombre as clubes ";
            $sql .= "FROM ".self::$tablename." c ";
            $sql .= "JOIN club cl ON cl.id=c.club ";
            $sql .= "LEFT JOIN usuario u ON u.id=c.capitan ";
            $sql .= "LEFT JOIN usuario us ON us.id=c.subcapitan
                    LEFT JOIN competicion AS comp ON comp.id=c.competicion WHERE c.id=$id ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new EquipoData());
        }
        public static function verid_orden($id,$club){
            $sql = " WITH OrdenEquipos AS (
                SELECT 
                    id,
                    nombre,
                    capitan,
                    subcapitan,
                    fecha,
                    ROW_NUMBER() OVER (PARTITION BY club ORDER BY id) AS orden,
                    COUNT(*) OVER (PARTITION BY club) AS total_equipos
                FROM equipo
                WHERE club = $club  
            )
            SELECT 
                id,
                nombre,
                capitan,
                subcapitan,
                fecha,
                orden,
                CASE 
                    WHEN orden = total_equipos THEN 'Último equipo'
                    ELSE CONCAT('Equipo ', orden)
                END AS estado
            FROM OrdenEquipos
            WHERE id = $id ";
            $query = Executor::doit($sql);
            return Model::one($query[0],new EquipoData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function duplicidad($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new EquipoData();
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
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoData());
        }
        public static function vercontenidos($club){
            $sql = "select * from ".self::$tablename." where club=$club";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoData());
        }
        public static function vercontenidos_por_liga($liga){
            $sql = "select * from ".self::$tablename." where liga=$liga";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoData());
        }
        public static function vercontenidos_por_liga_club($liga,$club){
            $sql = "select * from ".self::$tablename." where liga=$liga and club=$club ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoData());
        }
        public static function vercontenidos_por_competicion($competicion){
            $sql = "select * from ".self::$tablename." where competicion=$competicion";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, ";
            $sql .= "(SELECT COUNT(ej.id) FROM equipo_jugador ej WHERE ej.equipo = c.id) AS cantidad_jugadores, "; 
            $sql .= "CASE WHEN c.capitan REGEXP '^[0-9]+$' THEN CONCAT(u.nombre, ' ', u.apellido) ELSE c.capitan END as capitanes, ";
            $sql .= "CASE WHEN c.subcapitan REGEXP '^[0-9]+$' THEN CONCAT(us.nombre, ' ', us.apellido) ELSE c.subcapitan END as subcapitanes, ";
            $sql .= "cl.nombre as clubes, l.nombre as ligas, l.minimo, l.maximo ";
            $sql .= "FROM ".self::$tablename." c ";
            $sql .= "JOIN club cl ON cl.id=c.club ";
            $sql .= "LEFT JOIN usuario u ON u.id=c.capitan ";
            $sql .= "LEFT JOIN usuario us ON us.id=c.subcapitan ";
            $sql .= "LEFT JOIN liga l ON l.id=c.liga ";
            $sql .= "LEFT JOIN temporada t ON t.id=l.temporada ";
            $sql .= " WHERE t.estado=1 ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " ORDER BY c.id desc  ";
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }
        public static function vercontenidoPaginado1($club, $start, $length, $search = '') {
            // Convertir $club a entero para evitar problemas si es pasado como cadena
            $club = intval($club);

            $sql = "SELECT c.*, ";
            $sql .= "(SELECT COUNT(ej.id) FROM equipo_jugador ej WHERE ej.equipo = c.id) AS cantidad_jugadores, "; 
            $sql .= "CASE WHEN c.capitan REGEXP '^[0-9]+$' THEN CONCAT(u.nombre, ' ', u.apellido) ELSE c.capitan END AS capitanes, ";
            $sql .= "CASE WHEN c.subcapitan REGEXP '^[0-9]+$' THEN CONCAT(us.nombre, ' ', us.apellido) ELSE c.subcapitan END AS subcapitanes, ";
            $sql .= "cl.nombre AS clubes, l.nombre AS ligas, l.minimo, l.maximo, l.fechafinalmodificacion, ";
            $sql .= "cmp.nombregrupo AS categoria ";  // Se agrega la nueva columna
            $sql .= "FROM " . self::$tablename . " c ";
            $sql .= "JOIN club cl ON cl.id = c.club ";
            $sql .= "LEFT JOIN usuario u ON u.id = c.capitan ";
            $sql .= "LEFT JOIN usuario us ON us.id = c.subcapitan ";
            $sql .= "LEFT JOIN liga l ON l.id = c.liga ";
            $sql .= "LEFT JOIN temporada t ON t.id = l.temporada ";
            $sql .= "LEFT JOIN competicion cmp ON cmp.id = c.competicion ";  // Asegúrate de que 'competicion_id' es el nombre correcto
            $sql .= "WHERE c.club = $club AND t.estado = 1 ";

            if ($search) {
                // Se emplea addslashes para evitar problemas de comillas
                $sql .= "AND c.nombre LIKE '%" . addslashes($search) . "%' ";
            }

            $sql .= "ORDER BY c.id DESC ";
            $sql .= "LIMIT $start, $length";
            
            // Para depuración, registramos la consulta SQL
            error_log("SQL Query (vercontenidoPaginado1): " . $sql);
            
            $query = Executor::doit($sql);

            // Si hay error en la consulta, lo registramos
            if(!$query) {
                $error = mysqli_error(Database::getInstance()->getConnection());
                error_log("SQL Error: " . $error);
                // Retornamos un array vacío para evitar que se rompa el JSON
                return array();
            }
            
            return Model::many($query[0], new EquipoData());
        }



        public static function totalRegistro1($club){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE club=$club ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados1($club, $search){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE club=$club ";
            if ($search) {
                $sql .= " AND nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }
        public static function vercontenidoPaginado2($start, $length, $search = '') {
            $sql = "SELECT c.*, ";
            $sql .= "CASE WHEN c.capitan REGEXP '^[0-9]+$' THEN CONCAT(u.nombre, ' ', u.apellido) ELSE c.capitan END as capitanes, ";
            $sql .= "CASE WHEN c.subcapitan REGEXP '^[0-9]+$' THEN CONCAT(us.nombre, ' ', us.apellido) ELSE c.subcapitan END as subcapitanes, ";
            $sql .= "cl.nombre as clubes, l.nombre as ligas ";
            $sql .= "FROM " . self::$tablename . " c ";
            $sql .= "JOIN club cl ON cl.id = c.club ";
            $sql .= "LEFT JOIN usuario u ON u.id = c.capitan ";
            $sql .= "LEFT JOIN usuario us ON us.id = c.subcapitan ";
            $sql .= "LEFT JOIN liga l ON l.id = c.liga ";
            $sql .= "WHERE c.estado IN (2, 3, 4) ";
            if ($search) {
                $sql .= "AND c.nombre LIKE '%$search%' ";
            }
            $sql .= "ORDER BY (c.estado = 2) DESC, c.id DESC ";
            $sql .= "LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoData());
        }

        public static function totalRegistro2(){
            $sql = "select COUNT(*) as total from ".self::$tablename." where estado IN (2, 3, 4) ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados2($search){
            $sql = "select COUNT(*) as total from ".self::$tablename." where estado IN (2, 3, 4)";
            if ($search) {
                $sql .= " AND nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }
        public static function vercontenidoPaginado3($club, $start, $length, $search = ''){
            $sql = "SELECT c.*, ";
            $sql .= "CASE WHEN c.capitan REGEXP '^[0-9]+$' THEN CONCAT(u.nombre, ' ', u.apellido) ELSE c.capitan END as capitanes, ";
            $sql .= "CASE WHEN c.subcapitan REGEXP '^[0-9]+$' THEN CONCAT(us.nombre, ' ', us.apellido) ELSE c.subcapitan END as subcapitanes, ";
            $sql .= "cl.nombre as clubes, l.nombre as ligas, l.minimo, l.maximo  ";
            $sql .= "FROM ".self::$tablename." c ";
            $sql .= "JOIN club cl ON cl.id=c.club ";
            $sql .= "LEFT JOIN usuario u ON u.id=c.capitan ";
            $sql .= "LEFT JOIN usuario us ON us.id=c.subcapitan ";
            $sql .= "LEFT JOIN liga l ON l.id=c.liga ";
            $sql .= "LEFT JOIN temporada t ON t.id=l.temporada ";
            $sql .= " WHERE c.club=$club and t.archivado1=1  ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoData());
        }
        public static function totalRegistro3($club){
            $sql = "SELECT COUNT(*) as total 
                    FROM ".self::$tablename." c 
                    JOIN liga l ON l.id=c.liga 
                    JOIN temporada t ON t.id=l.temporada 
                    WHERE c.club=$club AND t.archivado1=1";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }

        public static function totalRegistrosFiltrados3($club, $search){
            $sql = "SELECT COUNT(*) as total 
                    FROM ".self::$tablename." c 
                    JOIN liga l ON l.id=c.liga 
                    JOIN temporada t ON t.id=l.temporada 
                    WHERE c.club=$club AND t.archivado1=1";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }

        public static function totalRegistroFederacion(){
            $sql = "SELECT COUNT(*) AS total 
                    FROM equipo 
                    JOIN liga l ON l.id = equipo.liga
                    JOIN temporada t ON t.id = l.temporada
                    WHERE t.estado=1
                      AND equipo.estado IN (2,4)";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }

        public static function totalRegistrosFiltradosFederacion($search){
            $sql = "SELECT COUNT(*) AS total 
                    FROM equipo 
                    JOIN liga l ON l.id = equipo.liga
                    JOIN temporada t ON t.id = l.temporada
                    WHERE t.estado=1
                      AND equipo.estado IN (2,4)";
            if(!empty($search)){
               $sql .= " AND ( equipo.nombre LIKE '%$search%' )";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoData());
            return $result->total;
        }

    }
?>