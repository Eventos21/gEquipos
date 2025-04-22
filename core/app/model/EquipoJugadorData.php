<?php
class EquipoJugadorData {
    public static $tablename = "equipo_jugador";
        public $id;
        public $jugador;
        public $equipo;
        public $estado;
        public $fecha;
        public $duplicidad;
        public $count;
        public $total;
        public $id1;
        public $id2;
        public $ordenn;
        public $apellido1;
        public $apellido2;
        public $nombre;
        public $nacimiento;
        public $numlicencia;
        public $club;
        public $codigofide;
        public $elo;
        public $telefono;
        public $usuario;
        public $edad_completa;
        public $nuevo;
        public $estadoe;
        public $id_jugador;
        public $numeroqueparticipa;
        public $cargo;
        public $users;
        public $password;
        public $imagen;
        public $estadoee;
        public $duplicidadee;
        public $fechaee;
        public $orden;
        public $elos ;
        public $validado;
        public function registro(){
            $sql = "insert into ".self::$tablename." (jugador,equipo,duplicidad,estado, elo,fecha,validado) ";
            $sql .= "value (\"$this->jugador\",\"$this->equipo\",\"$this->duplicidad\",1,\"$this->elo\",NOW(),\"$this->validado\")";
            return Executor::doit($sql);
        }

        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new EquipoJugadorData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoJugadorData());
        }
        public static function vercontenidos($equipo){
            $sql = "select j.*, c.id as id1 from ".self::$tablename." c JOIN jugador j ON j.id=c.jugador JOIN equipo e ON e.id=c.equipo
                    JOIN liga l ON l.id=e.liga
             where c.equipo=$equipo  ";
            $sql .= " ORDER BY 
              IF(l.orden = 'desc', j.elo, NULL) DESC, 
              IF(l.orden = 'libre' or l.orden = '', c.orden, c.orden) ASC";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoJugadorData());
        }
        public static function vercontenidos1($equipo){
            $sql = "select * from ".self::$tablename." where equipo=$equipo ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoJugadorData());
        }
        
        public static function vercontenido_fecha_rango($equipo, $minEdad, $maxEdad){
            $sql = "SELECT j.*, c.nuevo, c.id as id1, e.id as id2, e.estado as estadoe, TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa FROM ".self::$tablename;
            $sql .= " c JOIN jugador j ON j.id=c.jugador JOIN equipo e ON e.id=c.equipo WHERE c.equipo=$equipo AND c.estado=1 AND TIMESTAMPDIFF(YEAR, nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(nacimiento, '%m%d')) BETWEEN '$minEdad' AND '$maxEdad'";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoJugadorData());
        }
        
        public static function vercontenido_fecha_especifica($equipo, $edadEspecifica){
            $sql = "SELECT j.*, c.nuevo, c.id as id1, e.id as id2, e.estado as estadoe, TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa FROM ".self::$tablename;
            $sql .= " c JOIN jugador j ON j.id=c.jugador JOIN equipo e ON e.id=c.equipo WHERE c.equipo=$equipo AND c.estado=1 AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) =  '$edadEspecifica'";
            $query = Executor::doit($sql);
            return Model::many($query[0],new EquipoJugadorData());
        }
        public static function vercontenido_fecha_rango1($equipo, $minEdad, $maxEdad){
            $sql = "SELECT j.*, c.nuevo, c.id as id1, e.id as id2, e.estado as estadoe, TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa FROM ".self::$tablename;
            $sql .= " c JOIN jugador j ON j.id=c.jugador JOIN equipo e ON e.id=c.equipo JOIN liga l ON l.id=e.liga WHERE c.equipo=$equipo AND c.estado=1 AND TIMESTAMPDIFF(YEAR, nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(nacimiento, '%m%d')) BETWEEN '$minEdad' AND '$maxEdad'";
            
            // Ordenar por j.elo de forma descendente si el orden de la liga es "desc"
            
            $sql .= " ORDER BY 
              IF(l.orden = 'desc', j.elo, NULL) DESC, 
              IF(l.orden = 'libre' or l.orden = '', c.orden, c.orden) ASC";
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoJugadorData());
        }

        public static function vercontenido_fecha_especifica1($equipo, $edadEspecifica){
    // Consulta base
    $sql = "SELECT j.*, 
                   c.id as id1, 
                   e.id as id2, 
                   e.estado as estadoe, 
                   c.nuevo,
                   TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - 
                       (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa 
            FROM ".self::$tablename." c 
            JOIN jugador j ON j.id = c.jugador 
            JOIN equipo e ON e.id = c.equipo 
            JOIN liga l ON l.id = e.liga 
            WHERE c.equipo = $equipo 
            AND c.estado = 1";

    // Si se especifica la edad, se aplica el filtro
    if (!is_null($edadEspecifica) && $edadEspecifica !== '' && $edadEspecifica !== 0) {
        $sql .= " AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - 
                      (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) = '$edadEspecifica'";
    }

    $sql .= " ORDER BY 
              IF(l.orden = 'desc', j.elo, NULL) DESC, 
              IF(l.orden = 'libre' or l.orden = '', c.orden, c.orden) ASC";

    // Ejecutar la consulta
    $query = Executor::doit($sql);
    return Model::many($query[0], new EquipoJugadorData());
}

        public static function duplicidad($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new EquipoJugadorData();
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
        public static function vercontenidoPaginado($equipo, $start, $length, $search = ''){
            $sql = "SELECT j.*, c.elo as elos, c.id as id1, e.id as id2, e.estado as estadoe FROM ".self::$tablename;
            $sql .= " c JOIN jugador j ON j.id=c.jugador JOIN equipo e ON e.id=c.equipo WHERE c.equipo=$equipo AND c.estado=1 AND DATEDIFF(CURDATE(), j.nacimiento) / 365.25 BETWEEN 5 AND 25";
            if ($search) {
                $sql .= " AND j.nombre LIKE '%$search%' OR j.apellido1 LIKE '%$search%' OR j.apellido2 LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoJugadorData());
        }
        public static function totalRegistro($equipo){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoJugadorData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($equipo, $search){
            $sql = "select COUNT(*) as total from ".self::$tablename."  WHERE equipo=$equipo ";
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoJugadorData());
            return $result->total;
        }
        public static function vercontenidoPaginado1($equipo, $minEdad, $maxEdad, $start, $length, $search = ''){
                    $sql = "SELECT j.*,
                                   c.id           AS id1,
                                   e.id           AS id2,
                                   e.estado       AS estadoe,
                                   c.estado       AS estadoee,
                                   c.duplicidad   AS duplicidadee,
                                   c.fecha        AS fechaee,
                                   c.orden,
                                   c.nuevo,
                                   c.validado     AS validado,    /* ← LO AÑADIMOS */
                                   c.elo          AS elos,
                    TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa 
                    FROM ".self::$tablename." c 
                    JOIN jugador j ON j.id=c.jugador 
                    JOIN equipo e ON e.id=c.equipo 
                    JOIN liga l ON l.id=e.liga
                    WHERE c.equipo=$equipo 

                    AND c.estado=1 
                    AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) BETWEEN '$minEdad' AND '$maxEdad'";
            
            if ($search) {
                $sql .= " AND (j.nombre LIKE '%$search%' 
                          OR j.apellido1 LIKE '%$search%' 
                          OR j.apellido2 LIKE '%$search%' 
                          OR e.nombre LIKE '%$search%' 
                          OR e.estado LIKE '%$search%')";
            }

            $sql .= " ORDER BY 
              IF(l.orden = 'desc', j.elo, NULL) DESC, 
              IF(l.orden = 'libre' or l.orden = '', c.orden, c.orden) ASC";

            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoJugadorData());
        }
        public static function totalRegistro1($equipo, $minEdad, $maxEdad){
            $sql = "SELECT COUNT(*) as total 
                    FROM ".self::$tablename." c 
                    JOIN jugador j ON j.id=c.jugador 
                    JOIN equipo e ON e.id=c.equipo 
                    WHERE c.equipo=$equipo 
                    AND c.estado=1 
                    AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) BETWEEN '$minEdad' AND '$maxEdad'";
            
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoJugadorData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados1($equipo, $minEdad, $maxEdad, $search){
            $sql = "SELECT COUNT(*) as total 
                    FROM ".self::$tablename." c 
                    JOIN jugador j ON j.id=c.jugador 
                    JOIN equipo e ON e.id=c.equipo 
                    WHERE c.equipo=$equipo 
                    AND c.estado=1 
                    AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) BETWEEN '$minEdad' AND '$maxEdad'";
            
            if ($search) {
                $sql .= " AND (j.nombre LIKE '%$search%' 
                          OR j.apellido1 LIKE '%$search%' 
                          OR j.apellido2 LIKE '%$search%' 
                          OR e.nombre LIKE '%$search%' 
                          OR e.estado LIKE '%$search%')";
            }
            
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoJugadorData());
            return $result->total;
        }
        public static function vercontenidoPaginado2($equipo, $edadEspecifica, $start, $length, $search = ''){
            // Consulta base
            $sql = "SELECT j.*, 
                           c.id as id1, 
                           e.id as id2, 
                           e.estado as estadoe, 
                           c.estado as estadoee, 
                           c.duplicidad as duplicidadee, 
                           c.fecha as fechaee,   
                           c.orden,
                           c.nuevo, 
                           c.validado     AS validado,    /* ← LO AÑADIMOS */
                           c.elo as elos, 
                           TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - 
                               (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa 
                    FROM ".self::$tablename." c 
                    JOIN jugador j ON j.id = c.jugador 
                    JOIN equipo e ON e.id = c.equipo 
                    JOIN liga l ON l.id = e.liga
                    WHERE c.equipo = $equipo 
                    AND c.estado = 1";

            // Si se especifica la edad, se aplica el filtro
            if (!is_null($edadEspecifica) && $edadEspecifica !== '' && $edadEspecifica !== 0) {
                $sql .= " AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - 
                              (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) = '$edadEspecifica'";
            }

            // Agregar búsqueda en nombre y apellidos si existe un término de búsqueda
            if ($search) {
                $sql .= " AND (j.nombre LIKE '%$search%' 
                         OR j.apellido1 LIKE '%$search%' 
                         OR j.apellido2 LIKE '%$search%')";
            }

            $sql .= " ORDER BY 
              IF(l.orden = 'desc', j.elo, NULL) DESC, 
              IF(l.orden = 'libre' or l.orden = '', c.orden, c.orden) ASC";

            // Paginación
            $sql .= " LIMIT $start, $length";
            
            // Ejecutar la consulta
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoJugadorData());
        }

        public static function totalRegistro2($equipo, $edadEspecifica){
            $sql = "SELECT COUNT(*) as total 
                    FROM ".self::$tablename." c 
                    JOIN jugador j ON j.id=c.jugador 
                    WHERE c.equipo=$equipo 
                    AND c.estado=1";

            // Si se especifica la edad, se aplica el filtro
            if (!is_null($edadEspecifica) && $edadEspecifica !== '' && $edadEspecifica !== 0) {
                $sql .= " AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - 
                              (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) = '$edadEspecifica'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoJugadorData());
            return $result->total;
        }

        public static function totalRegistrosFiltrados2($equipo, $edadEspecifica, $search){
            $sql = "SELECT COUNT(*) as total 
                    FROM ".self::$tablename." c 
                    JOIN jugador j ON j.id=c.jugador 
                    WHERE c.equipo=$equipo 
                    AND c.estado=1";

            // Si se especifica la edad, se aplica el filtro
            if (!is_null($edadEspecifica) && $edadEspecifica !== '' && $edadEspecifica !== 0) {
                $sql .= " AND TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - 
                              (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) = '$edadEspecifica'";
            }

            // Agregar búsqueda en nombre y apellidos
            if ($search) {
                $sql .= " AND (j.nombre LIKE '%$search%' 
                         OR j.apellido1 LIKE '%$search%' 
                         OR j.apellido2 LIKE '%$search%')";
            }

            $query = Executor::doit($sql);
            $result = Model::one($query[0], new EquipoJugadorData());
            return $result->total;
        }

        public static function holamundillo($equipo){
            $sql = "SELECT j.*, 
                           c.id as id1, 
                           e.id as id2, 
                           e.estado as estadoe, 
                           c.estado as estadoee, 
                           c.duplicidad as duplicidadee, 
                           c.fecha as fechaee,   
                           c.orden,  -- Seleccionar la columna 'orden'
                           c.nuevo,
                           c.elo as elos, 
                           TIMESTAMPDIFF(YEAR, j.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(j.nacimiento, '%m%d')) AS edad_completa 
                    FROM equipo_jugador c 
                    JOIN jugador j ON j.id=c.jugador 
                    JOIN equipo e ON e.id=c.equipo 
                    WHERE c.equipo=$equipo 
                    AND c.estado=1 
                    ORDER BY c.orden";
            
            $query = Executor::doit($sql);
            return Model::many($query[0], new EquipoJugadorData());
        }

        public function updatePlayerInfo(){
            $sql = "update ".self::$tablename." set orden=\"$this->orden\" where id=$this->id";
            Executor::doit($sql);
        }

        public function cambiodenuevo(){
            $sql = "update ".self::$tablename." set nuevo=\"$this->nuevo\" where id=$this->id";
            Executor::doit($sql);
        }

        public function cambiodevalidado(){
            $sql = "update ".self::$tablename." set validado=\"$this->validado\" where id=$this->id";
            Executor::doit($sql);
        }

        public static function vercontenidoPaginado3($responsable, $start, $length, $search = ''){
            $sql = "SELECT c.*, CONCAT(u.nombre, ' ', u.apellido) as responsables FROM ".self::$tablename;
            $sql .= " c JOIN usuario u ON u.id=c.responsable WHERE c.id=$responsable ";
            if ($search) {
                $sql .= " AND c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new ClubData());
        }
        public static function totalRegistro3($responsable){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE id=$responsable ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ClubData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados3($responsable, $search){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE id=$responsable ";
            if ($search) {
                $sql .= " AND nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new ClubData());
            return $result->total;
        }
    }
?>