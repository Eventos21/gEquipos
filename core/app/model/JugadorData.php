<?php
    class JugadorData {
        public static $tablename = "jugador";
        public $id;
        public $equipo;
        public $apellido1;
        public $apellido2;
        public $nombre;
        public $nacimiento;
        public $numlicencia;
        public $club;
        public $codigofide;
        public $elo;
        public $telefono;
        public $duplicidad;
        public $usuario;
        public $estado;
        public $fecha;
        public $count;
        public $total;
        public $codigo;
        public $edad_completa;
        public $numeroqueparticipa;
        public $cargo;
        public $users;
        public $password;
        public $imagen;

        public $club_id;
        public $club_nombre;
        public $correo;
        public $direccion;
        public $responsable;
        public $cantidadequipo;
        public $estado_juego ;
        public $nombreequipo;
        public $nombreliga;
        public $nombretemporada;

        public function registro(){
            $sql = "insert into ".self::$tablename." (apellido1,apellido2,nombre,nacimiento,numlicencia,club,telefono,codigofide,elo,usuario,estado,fecha,duplicidad,users,password) ";
            $sql .= "value (\"$this->apellido1\",\"$this->apellido2\",\"$this->nombre\",\"$this->nacimiento\",\"$this->numlicencia\",\"$this->club\",\"$this->telefono\",\"$this->codigofide\",\"$this->elo\",\"$this->usuario\",1,NOW(),\"$this->duplicidad\",\"$this->users\",\"$this->password\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set apellido1=\"$this->apellido1\",apellido2=\"$this->apellido2\",nombre=\"$this->nombre\",nacimiento=\"$this->nacimiento\",numlicencia=\"$this->numlicencia\",telefono=\"$this->telefono\",estado=\"$this->estado\",club=\"$this->club\",codigofide=\"$this->codigofide\",elo=\"$this->elo\",duplicidad=\"$this->duplicidad\" where id=$this->id";
           return Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select * from ".self::$tablename." where id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new JugadorData());
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
            $array[$cnt] = new JugadorData();
            $array[$cnt]->duplicidad = $r['duplicidad'];
            $cnt++;
            }
            return $array;
        }
        public static function verPorDuplicidad($duplicidad) {
            $sql = "SELECT * FROM " . self::$tablename . " WHERE duplicidad=\"$duplicidad\"";
            $query = Executor::doit($sql);
            return Model::one($query[0], new JugadorData());
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
            return Model::many($query[0],new JugadorData());
        }
        public static function vercontenidos($compra){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new JugadorData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, TIMESTAMPDIFF(YEAR, c.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(c.nacimiento, '%m%d')) AS edad_completa FROM ".self::$tablename;
            $sql .= " c ";
            if ($search) {
                $sql .= "  WHERE c.nombre LIKE '%$search%' 
                            OR c.apellido1 LIKE '%$search%'
                            OR c.apellido2 LIKE '%$search%' ";
            }
            $sql.=" order by c.nombre asc ";
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new JugadorData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }
        public static function cantidadvecesparticipa($jugador, $liga){
            $sql = "SELECT count(c.jugador) as numeroqueparticipa 
                    FROM equipo_jugador c 
                    JOIN jugador j ON j.id=c.jugador 
                    JOIN equipo e ON e.id=c.equipo 
                    JOIN liga l ON l.id=e.liga 
                    JOIN temporada t ON t.id = l.temporada 
                    WHERE c.estado=1 AND t.archivado1 =0 AND c.jugador =$jugador AND e.liga=$liga";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->numeroqueparticipa;
        }

        public static function vercontenidoPaginado1($club, $start, $length, $search = ''){
            $sql = "SELECT c.*, TIMESTAMPDIFF(YEAR, c.nacimiento, CURDATE()) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(c.nacimiento, '%m%d')) AS edad_completa FROM ".self::$tablename;
            $sql .= " c WHERE c.club='$club' ";
            if ($search) {
                $sql .= "  AND c.nombre LIKE '%$search%' 
                            OR c.apellido1 LIKE '%$search%'
                            OR c.apellido2 LIKE '%$search%' ";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new JugadorData());
        }
        public static function totalRegistro1($club){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE club='$club' ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados1($club, $search){
            $sql = "select COUNT(*) as total from ".self::$tablename." WHERE club='$club' ";
            if ($search) {
                $sql .= " AND nombre LIKE '%$search%' 
                        OR apellido1 LIKE '%$search%'
                        OR apellido2 LIKE '%$search%' ";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

        public static function vercontenidoPaginado2($club, $start, $length, $search = '') {
            $sql = "SELECT c.*, 
                    TIMESTAMPDIFF(YEAR, c.nacimiento, CURDATE()) - 
                        (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(c.nacimiento, '%m%d')) AS edad_completa 
                    FROM ".self::$tablename." c 
                    WHERE c.club = '$club'";

            // Agregar búsqueda si existe
            if ($search) {
                $sql .= " AND (c.nombre LIKE '%$search%' 
                            OR c.apellido1 LIKE '%$search%' 
                            OR c.apellido2 LIKE '%$search%')";
            }

            // Agregar límite de paginación
            $sql .= " LIMIT $start, $length";
            
            $query = Executor::doit($sql);
            return Model::many($query[0], new JugadorData());
        }

        public static function totalRegistro2($club) {
            $sql = "SELECT COUNT(*) as total FROM ".self::$tablename." WHERE club = '$club'";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

        public static function totalRegistrosFiltrados2($club, $search) {
            $sql = "SELECT COUNT(*) as total FROM ".self::$tablename." WHERE club = '$club'";

            // Agregar búsqueda si existe
            if ($search) {
                $sql .= " AND (nombre LIKE '%$search%' 
                            OR apellido1 LIKE '%$search%' 
                            OR apellido2 LIKE '%$search%')";
            }

            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }


        public static function listajugado($apellido1, $apellido2, $nombre){
            $sql = "SELECT *
                    FROM jugador
                    WHERE apellido1 LIKE '%$apellido1%' 
                       OR apellido2 LIKE '%$apellido2%'
                       OR nombre LIKE '$nombre%' ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new JugadorData());
        }
         public static function vercontenidoPaginado3($start, $length, $search = '') {
            $sql = "SELECT * FROM jugador WHERE 1=1";
            
            if ($search) {
                $sql .= " AND (apellido1 LIKE '%$search%' 
                          OR apellido2 LIKE '%$search%' 
                          OR nombre LIKE '%$search%'
                        OR codigofide LIKE '%$search%')";
            }
            
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new JugadorData());
        }

        public static function totalRegistro3() {
            $sql = "SELECT COUNT(*) as total FROM jugador";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

        public static function totalRegistrosFiltrados3($search) {
            $sql = "SELECT COUNT(*) as total FROM jugador WHERE 1=1";
            
            if ($search) {
                $sql .= " AND (apellido1 LIKE '%$search%' 
                          OR apellido2 LIKE '%$search%' 
                          OR nombre LIKE '%$search%')";
            }
            
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

         public function actualizarusuario(){
            $sql = "update ".self::$tablename." set users=\"$this->users\"  where id=$this->id";
           return Executor::doit($sql);
        }
        public function actualizarpassword(){
            $sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
           return Executor::doit($sql);
        }


        

        public static function vercontenidoPaginado4($jugador, $start, $length, $search = ''){
            $sql = "SELECT DISTINCT 
                        c.id AS club_id, 
                        c.nombre AS club_nombre, 
                        c.telefono, 
                        c.correo, 
                        c.direccion, 
                        c.responsable, 
                        c.estado, 
                        c.codigo, 
                        c.cantidadequipo, 
                        c.usuario, 
                        c.fecha,
                        e.nombre as nombreequipo,
                        l.nombre as nombreliga,
                        t.nombre as nombretemporada,
                        CASE 
                            WHEN a.id IS NOT NULL THEN 'Ya ha jugado' 
                            ELSE 'Todavía no ha jugado' 
                        END AS estado_juego
                    FROM club AS c
                    JOIN equipo AS e ON c.id = e.club
                    JOIN equipo_jugador AS ej ON e.id = ej.equipo
                    JOIN jugador AS j ON ej.jugador = j.id
                    JOIN liga AS l ON l.id=e.liga
                    JOIN temporada AS t ON t.id=l.temporada
                    LEFT JOIN acta AS a ON a.jugador = j.id AND a.equipo = e.id
                    WHERE j.id = $jugador ";

            if ($search) {
                $sql .= " AND (c.nombre LIKE '%$search%' 
                            OR c.telefono LIKE '%$search%'
                            OR c.correo LIKE '%$search%' 
                            OR c.direccion LIKE '%$search%') ";
            }
             $sql .= " ORDER BY ej.fecha desc ";
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new JugadorData());
        }

        public static function totalRegistro4($jugador) {
            $sql = "SELECT COUNT(DISTINCT c.id) AS total
                    FROM club AS c
                    JOIN equipo AS e ON c.id = e.club
                    JOIN equipo_jugador AS ej ON e.id = ej.equipo
                    JOIN jugador AS j ON ej.jugador = j.id
                    WHERE j.id = $jugador";
            
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

        public static function totalRegistrosFiltrados4($jugador, $search) {
            $sql = "SELECT COUNT(DISTINCT c.id) AS total
                    FROM club AS c
                    JOIN equipo AS e ON c.id = e.club
                    JOIN equipo_jugador AS ej ON e.id = ej.equipo
                    JOIN jugador AS j ON ej.jugador = j.id
                    WHERE j.id = $jugador ";
            
            if ($search) {
                $sql .= " AND (c.nombre LIKE '%$search%' 
                            OR c.telefono LIKE '%$search%' 
                            OR c.correo LIKE '%$search%' 
                            OR c.direccion LIKE '%$search%') ";
            }

            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

        public static function verJugadoresPorClub($club, $start, $length, $search = '') {
            // Filtra jugadores cuyo campo club (texto) coincida con el valor de $club.
            $sql = "SELECT * FROM " . self::$tablename . " WHERE club = '" . addslashes($club) . "'";
            if ($search) {
                $sql .= " AND (nombre LIKE '%" . addslashes($search) . "%' 
                            OR apellido1 LIKE '%" . addslashes($search) . "%' 
                            OR apellido2 LIKE '%" . addslashes($search) . "%')";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new JugadorData());
        }

        public static function totalJugadoresPorClub($club) {
            $sql = "SELECT COUNT(*) as total FROM " . self::$tablename . " WHERE club = '" . addslashes($club) . "'";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

        public static function totalJugadoresPorClubFiltered($club, $search) {
            $sql = "SELECT COUNT(*) as total FROM " . self::$tablename . " WHERE club = '" . addslashes($club) . "'";
            if ($search) {
                $sql .= " AND (nombre LIKE '%" . addslashes($search) . "%' 
                            OR apellido1 LIKE '%" . addslashes($search) . "%' 
                            OR apellido2 LIKE '%" . addslashes($search) . "%')";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new JugadorData());
            return $result->total;
        }

}
?>