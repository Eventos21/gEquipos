
<?php
class SalaPersonalizadaData {
    public static $tablename = "sala_personalizada";
        public $id;
        public $sala;
        public $ronda;
        public $encuentro;
        public $equipo_competidor;
        public $equipo_rival;
        public $id_competidor;
        public $id_rival;
        public $fecha;
        public $count;
        public $total;
        public $Competidor1 ;
        public $Rival1 ;
        public $idregistro1  ;
        public $Rival2 ;
        public $idregistro2 ;
        public $Competidor3 ;
        public $Rival3 ;
        public $idregistro3 ;
        public $Competidor2 ;
        public $Competidor4;
        public $Rival4;
        public $idregistro4;
        public $Competidor5;
        public $Rival5;
        public $idregistro5;
        public $Competidor6;
        public $Rival6;
        public $idregistro6;
        public $Competidor7;
        public $Rival7;
        public $idregistro7;
        public $Competidor8;
        public $Rival8;
        public $idregistro8;
        public $Competidor9;
        public $Rival9;
        public $idregistro9;
        public $Competidor10;
        public $Rival10;
        public $idregistro10;
        public $nombregrupo;
        public $equipoa;
        public $equipob;

        public $puntajea;
        public $observaciona;
        public $firmaa;
        public $puntajeb;
        public $observacionb;
        public $firmab;
        public $usuario;
        public $arbitro;
        public $observacion_arbitro;
        public $firma_arbitro;
        public $obervacion_fma;
        public $aprobacion;
        public $usuarios;
        public $archivoa;
        public $archivob;
        public $identifier ;
        public $start;
        public $title;
        public $adicional;
        public function registro(){
            $sql = "insert into ".self::$tablename." (sala,ronda,encuentro,equipo_competidor,equipo_rival,fecha,id_competidor,id_rival) ";
            $sql .= "value (\"$this->sala\",\"$this->ronda\",\"$this->encuentro\",\"$this->equipo_competidor\",\"$this->equipo_rival\",\"$this->fecha\",\"$this->id_competidor\",\"$this->id_rival\")";
            return Executor::doit($sql);
        }
        public static function duplicidad($sala,$equipo){
        $sql = "select * from ".self::$tablename." where sala=\"$sala\" AND equipo=\"$equipo\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new SalaPersonalizadaData();
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
        public function actualizar1(){
            $sql = "update ".self::$tablename." set ronda=\"$this->ronda\", equipo_competidor=\"$this->equipo_competidor\", equipo_rival=\"$this->equipo_rival\", fecha=\"$this->fecha\" where id=$this->id ";
            Executor::doit($sql);
        }
        public function actualizara(){
            $sql = "update ".self::$tablename." set usuario=\"$this->usuario\", observaciona=\"$this->observaciona\", firmaa=\"$this->firmaa\", archivoa=\"$this->archivoa\" where id=$this->id ";
            Executor::doit($sql);
        }
        public function actualizarb(){
            $sql = "update ".self::$tablename." set usuario=\"$this->usuario\", observacionb=\"$this->observacionb\", firmab=\"$this->firmab\", archivob=\"$this->archivob\" where id=$this->id ";
            Executor::doit($sql);
        }
        public function actualizarar(){
            $sql = "update ".self::$tablename." set usuario=\"$this->usuario\", arbitro=\"$this->arbitro\", observacion_arbitro=\"$this->observacion_arbitro\", firma_arbitro=\"$this->firma_arbitro\" where id=$this->id ";
            Executor::doit($sql);
        }
        public function puntajea(){
            $sql = "update ".self::$tablename." set puntajea=\"$this->puntajea\"  where id=$this->id ";
            Executor::doit($sql);
        }
        public function puntajeb(){
            $sql = "update ".self::$tablename." set puntajeb=\"$this->puntajeb\"  where id=$this->id ";
            Executor::doit($sql);
        }
        public function actualizarfm(){
            $sql = "update ".self::$tablename." set obervacion_fma=\"$this->obervacion_fma\", aprobacion=\"$this->aprobacion\", usuario=\"$this->usuario\" where id=$this->id ";
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
            return Model::one($query[0],new SalaPersonalizadaData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaPersonalizadaData());
        }
        public static function verid2($id){
            $sql = "SELECT sp.*, 
                           c.nombregrupo, 
                           IF(sp.id_competidor = 0, 'Sin equipo', COALESCE(e.nombre, 'Sin equipo')) AS equipoa, 
                           IF(sp.id_rival = 0, 'Sin equipo', COALESCE(e1.nombre, 'Sin equipo')) AS equipob  
                    FROM sala_personalizada sp
                    JOIN sala s ON sp.sala = s.id
                    JOIN competicion c ON s.competicion = c.id
                    LEFT JOIN equipo e ON e.id = sp.id_competidor
                    LEFT JOIN equipo e1 ON e1.id = sp.id_rival
                    WHERE sp.id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new SalaPersonalizadaData());
        }
        public static function vercontenidos3(){
            $sql = "SELECT sp.*, 
                       c.nombregrupo, 
                       u.ci as usuarios,
                       IF(sp.id_competidor = 0, 'Sin equipo', COALESCE(e.nombre, 'Sin equipo')) AS equipoa, 
                       IF(sp.id_rival = 0, 'Sin equipo', COALESCE(e1.nombre, 'Sin equipo')) AS equipob  
                FROM sala_personalizada sp
                JOIN sala s ON sp.sala = s.id
                JOIN competicion c ON s.competicion = c.id
                LEFT JOIN equipo e ON e.id = sp.id_competidor
                LEFT JOIN equipo e1 ON e1.id = sp.id_rival
                LEFT JOIN usuario u ON u.id=sp.usuario
                -- WHERE DATE(sp.fecha) = CURDATE() --solo se la fecha actual--
                -- WHERE DATE(sp.fecha) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) --de hoy y de mañana--
                WHERE DATE(sp.fecha) BETWEEN DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND CURDATE() 
                  AND ((sp.id_competidor IS NOT NULL AND sp.id_competidor != 0)
                       OR (sp.id_rival IS NOT NULL AND sp.id_rival != 0))
                ORDER BY c.nombregrupo, sp.fecha";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaPersonalizadaData());
        }
        public static function vercontenidos4($fecha){
            $sql = "SELECT sp.*, 
                       '1' AS adicional,
                       c.nombregrupo, 
                       u.ci as usuarios,
                       IF(sp.id_competidor = 0, 'Sin equipo', COALESCE(e.nombre, 'Sin equipo')) AS equipoa, 
                       IF(sp.id_rival = 0, 'Sin equipo', COALESCE(e1.nombre, 'Sin equipo')) AS equipob  
                FROM sala_personalizada sp
                JOIN sala s ON sp.sala = s.id
                JOIN competicion c ON s.competicion = c.id
                LEFT JOIN equipo e ON e.id = sp.id_competidor
                LEFT JOIN equipo e1 ON e1.id = sp.id_rival
                LEFT JOIN usuario u ON u.id=sp.usuario
                WHERE sp.fecha = '$fecha' AND ((sp.id_competidor IS NOT NULL AND sp.id_competidor != 0)
                       OR (sp.id_rival IS NOT NULL AND sp.id_rival != 0))
                ORDER BY c.nombregrupo, sp.fecha";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaPersonalizadaData());
        }
        public static function vercontenidos5($fecha){
            $sql = "SELECT sp.*, 
                       c.nombregrupo, 
                       u.ci as usuarios,
                       IF(sp.id_competidor = 0, 'Sin equipo', COALESCE(e.nombre, 'Sin equipo')) AS equipoa, 
                       IF(sp.id_rival = 0, 'Sin equipo', COALESCE(e1.nombre, 'Sin equipo')) AS equipob  
                FROM sala_personalizada sp
                JOIN sala s ON sp.sala = s.id
                JOIN competicion c ON s.competicion = c.id
                LEFT JOIN equipo e ON e.id = sp.id_competidor
                LEFT JOIN equipo e1 ON e1.id = sp.id_rival
                LEFT JOIN usuario u ON u.id=sp.usuario
                WHERE DATE(sp.fecha) = '$fecha' 
                  AND ((sp.id_competidor IS NOT NULL AND sp.id_competidor != 0)
                       OR (sp.id_rival IS NOT NULL AND sp.id_rival != 0))
                ORDER BY c.nombregrupo, sp.fecha";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaPersonalizadaData());
        }
        public static function eventoslista(){
            $sql = "SELECT sp.fecha as start, c.nombregrupo as title, '1' AS adicional  
                    FROM sala_personalizada sp
                    JOIN sala s ON sp.sala = s.id
                    JOIN competicion c ON s.competicion = c.id
                    GROUP BY sp.fecha";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaPersonalizadaData());
        }

        public static function Listarencuentro($sala){
            $sql = "
                SELECT 
                s.ronda,
                s.fecha,
                
                MAX(CASE WHEN s.encuentro = 1 THEN COALESCE(e1.nombre, '--') END) AS Competidor1,
                MAX(CASE WHEN s.encuentro = 1 THEN COALESCE(e2.nombre, '--') END) AS Rival1,
                MAX(CASE WHEN s.encuentro = 1 THEN s.id END) AS idregistro1,
                MAX(CASE WHEN s.encuentro = 2 THEN COALESCE(e1.nombre, '--') END) AS Competidor2,
                MAX(CASE WHEN s.encuentro = 2 THEN COALESCE(e2.nombre, '--') END) AS Rival2,
                MAX(CASE WHEN s.encuentro = 2 THEN s.id END) AS idregistro2,
                -- Continúa con los demás encuentros de la misma manera
                MAX(CASE WHEN s.encuentro = 3 THEN COALESCE(e1.nombre, '--') END) AS Competidor3,
                MAX(CASE WHEN s.encuentro = 3 THEN COALESCE(e2.nombre, '--') END) AS Rival3,
                MAX(CASE WHEN s.encuentro = 3 THEN s.id END) AS idregistro3,
                MAX(CASE WHEN s.encuentro = 4 THEN COALESCE(e1.nombre, '--') END) AS Competidor4,
                MAX(CASE WHEN s.encuentro = 4 THEN COALESCE(e2.nombre, '--') END) AS Rival4,
                MAX(CASE WHEN s.encuentro = 4 THEN s.id END) AS idregistro4,
                MAX(CASE WHEN s.encuentro = 5 THEN COALESCE(e1.nombre, '--') END) AS Competidor5,
                MAX(CASE WHEN s.encuentro = 5 THEN COALESCE(e2.nombre, '--') END) AS Rival5,
                MAX(CASE WHEN s.encuentro = 5 THEN s.id END) AS idregistro5,
                MAX(CASE WHEN s.encuentro = 6 THEN COALESCE(e1.nombre, '--') END) AS Competidor6,
                MAX(CASE WHEN s.encuentro = 6 THEN COALESCE(e2.nombre, '--') END) AS Rival6,
                MAX(CASE WHEN s.encuentro = 6 THEN s.id END) AS idregistro6,
                MAX(CASE WHEN s.encuentro = 7 THEN COALESCE(e1.nombre, '--') END) AS Competidor7,
                MAX(CASE WHEN s.encuentro = 7 THEN COALESCE(e2.nombre, '--') END) AS Rival7,
                MAX(CASE WHEN s.encuentro = 7 THEN s.id END) AS idregistro7,
                MAX(CASE WHEN s.encuentro = 8 THEN COALESCE(e1.nombre, '--') END) AS Competidor8,
                MAX(CASE WHEN s.encuentro = 8 THEN COALESCE(e2.nombre, '--') END) AS Rival8,
                MAX(CASE WHEN s.encuentro = 8 THEN s.id END) AS idregistro8,
                MAX(CASE WHEN s.encuentro = 9 THEN COALESCE(e1.nombre, '--') END) AS Competidor9,
                MAX(CASE WHEN s.encuentro = 9 THEN COALESCE(e2.nombre, '--') END) AS Rival9,
                MAX(CASE WHEN s.encuentro = 9 THEN s.id END) AS idregistro9,
                MAX(CASE WHEN s.encuentro = 10 THEN COALESCE(e1.nombre, '--') END) AS Competidor10,
                MAX(CASE WHEN s.encuentro = 10 THEN COALESCE(e2.nombre, '--') END) AS Rival10,
                MAX(CASE WHEN s.encuentro = 10 THEN s.id END) AS idregistro10
            FROM 
                sala_personalizada s
                LEFT JOIN equipo e1 ON e1.id = s.id_competidor
                LEFT JOIN equipo e2 ON e2.id = s.id_rival
            WHERE 
                s.sala = $sala
            GROUP BY 
                s.ronda, s.fecha
            HAVING
                -- Condición para incluir solo las filas con al menos un competidor o un rival
                Competidor1 IS NOT NULL OR Competidor2 IS NOT NULL OR Competidor3 IS NOT NULL OR Competidor4 IS NOT NULL OR
                Competidor5 IS NOT NULL OR Competidor6 IS NOT NULL OR Competidor7 IS NOT NULL OR Competidor8 IS NOT NULL OR
                Competidor9 IS NOT NULL OR Competidor10 IS NOT NULL OR
                Rival1 IS NOT NULL OR Rival2 IS NOT NULL OR Rival3 IS NOT NULL OR Rival4 IS NOT NULL OR
                Rival5 IS NOT NULL OR Rival6 IS NOT NULL OR Rival7 IS NOT NULL OR Rival8 IS NOT NULL OR
                Rival9 IS NOT NULL OR Rival10 IS NOT NULL
            ORDER BY 
                s.ronda ASC, s.fecha ASC";

            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaPersonalizadaData());
        }

        public static function vercontenidos($sala,$equipo){
            $sql = "select * from ".self::$tablename." WHERE sala = $sala AND equipo=$equipo ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaPersonalizadaData());
        }
        public static function vercontenidos1($sala){
            $sql = "select * from ".self::$tablename." WHERE sala=$sala ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaPersonalizadaData());
        }
        public static function verid1($sala,$equipo){
            $sql = "select * from ".self::$tablename." where sala = $sala AND equipo=$equipo";
            $query = Executor::doit($sql);
            return Model::one($query[0],new SalaPersonalizadaData());
        }
        public static function vercontenidoPaginado($start, $length, $search = ''){
            $sql = "SELECT c.*, s.nombre as sucursales FROM ".self::$tablename;
            $sql .= " c LEFT JOIN sucursal s ON s.id=c.sucursal";
            if ($search) {
                $sql .= " WHERE c.nombre LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaPersonalizadaData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SalaPersonalizadaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SalaPersonalizadaData());
            return $result->total;
        }
    }
?>
