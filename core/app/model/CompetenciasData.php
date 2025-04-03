<?php
class CompetenciasData {
    public static $tablename = "competencias";
        public $id;
        public $encuentro1_a;
        public $encuentro1_b;
        public $encuentro2_a;
        public $encuentro2_b;
        public $encuentro3_a;
        public $encuentro3_b;
        public $encuentro4_a;
        public $encuentro4_b;
        public $encuentro5_a;
        public $encuentro5_b;
        public $encuentro6_a;
        public $encuentro6_b;
        public $encuentro7_a;
        public $encuentro7_b;
        public $fecha_encuentro;
        public $sala;
        public $count;
        public $total;

        public $equipo1;
        public $equipo2;
        public $equipo3;
        public $equipo4;
        public $equipo5;
        public $equipo6;
        public $equipo7;
        public $equipo8;
        public $equipo9;
        public $equipo10;
        public $equipo11;
        public $equipo12;
        public $equipo13;
        public $equipo14;
        public $estado;
        public $estado1_a;
        public $accion1_a;
        public $estado1_b;
        public $accion1_b;
        public $estado2_a;
        public $accion2_a;
        public $estado2_b;
        public $accion2_b;
        public $estado3_a;
        public $accion3_a;
        public $estado3_b;
        public $accion3_b;
        public $estado4_a;
        public $accion4_a;
        public $estado4_b;
        public $accion4_b;
        public $estado5_a;
        public $accion5_a;
        public $estado5_b;
        public $accion5_b;
        public $estado6_a;
        public $accion6_a;
        public $estado6_b;
        public $accion6_b;
        public $estado7_a;
        public $accion7_a;
        public $estado7_b;
        public $accion7_b;

        public $observacion1_a;
        public $firma1_a;
        public $observacion1_b;
        public $firma1_b;
        public $observacion2_a;
        public $firma2_a;
        public $observacion2_b;
        public $firma2_b;
        public $observacion3_a;
        public $firma3_a;
        public $observacion3_b;
        public $firma3_b;
        public $observacion4_a;
        public $firma4_a;
        public $observacion4_b;
        public $firma4_b;
        public $observacion5_a;
        public $firma5_a;
        public $observacion5_b;
        public $firma5_b;
        public $observacion6_a;
        public $firma6_a;
        public $observacion6_b;
        public $firma6_b;
        public $observacion7_a;
        public $firma7_a;
        public $observacion7_b;
        public $firma7_b;
        public $arbitro;
        public $observacion_arbitro;
        public $firma_arbitro;
        public $obervacion_fma;
        public $aprobacion;
        public $usuario1;
        public $usuario2;
        public $usuario3;
        public $usuario4;
        public $usuario5;
        public $usuario6;
        public $usuario7;
        public $arbitro1;
        public $observacion_arbitro1;
        public $firma_arbitro1;
        public $obervacion_fma1;
        public $aprobacion1;
        public $arbitro2;
        public $observacion_arbitro2;
        public $firma_arbitro2;
        public $obervacion_fma2;
        public $aprobacion2;
        public $arbitro3;
        public $observacion_arbitro3;
        public $firma_arbitro3;
        public $obervacion_fma3;
        public $aprobacion3;
        public $arbitro4;
        public $observacion_arbitro4;
        public $firma_arbitro4;
        public $obervacion_fma4;
        public $aprobacion4;
        public $arbitro5;
        public $observacion_arbitro5;
        public $firma_arbitro5;
        public $obervacion_fma5;
        public $aprobacion5;
        public $arbitro6;
        public $observacion_arbitro6;
        public $firma_arbitro6;
        public $obervacion_fma6;
        public $aprobacion6;
        public $arbitro7;
        public $observacion_arbitro7;
        public $firma_arbitro7;
        public $obervacion_fma7;
        public $aprobacion7;
        public $archivo1_a;
        public $archivo1_b;
        public $archivo2_a;
        public $archivo2_b;
        public $archivo3_a;
        public $archivo3_b;
        public $archivo4_a;
        public $archivo4_b;
        public $archivo5_a;
        public $archivo5_b;
        public $archivo6_a;
        public $archivo6_b;
        public $archivo7_a;
        public $archivo7_b;
        public $start;
        public $title;
        public $total_encuentros; 
        public $rival;
        public $puntos ;
        public $accion;
        public $total_accion ;
        public $adicional;
        public function registro_competicion() {
        $sql = "INSERT INTO competencias (encuentro1_a, encuentro1_b, encuentro2_a, encuentro2_b, encuentro3_a, encuentro3_b, encuentro4_a, encuentro4_b, encuentro5_a, encuentro5_b, encuentro6_a, encuentro6_b, encuentro7_a, encuentro7_b, fecha_encuentro, sala) VALUES (\"$this->encuentro1_a\",\"$this->encuentro1_b\",\"$this->encuentro2_a\",\"$this->encuentro2_b\",\"$this->encuentro3_a\",\"$this->encuentro3_b\",\"$this->encuentro4_a\",\"$this->encuentro4_b\",\"$this->encuentro5_a\",\"$this->encuentro5_b\",\"$this->encuentro6_a\",\"$this->encuentro6_b\",\"$this->encuentro7_a\",\"$this->encuentro7_b\",\"$this->fecha_encuentro\",\"$this->sala\")";
        return Executor::doit($sql);
    }
    //     public function registro_competicion() {
    //     $sql = "INSERT INTO competencias (encuentro1_a, encuentro1_b, encuentro2_a, encuentro2_b, encuentro3_a, encuentro3_b, encuentro4_a, encuentro4_b, encuentro5_a, encuentro5_b, encuentro6_a, encuentro6_b, encuentro7_a, encuentro7_b) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    //     $params = array($this->encuentro1_a, $this->encuentro1_b, $this->encuentro2_a, $this->encuentro2_b, $this->encuentro3_a, $this->encuentro3_b, $this->encuentro4_a, $this->encuentro4_b, $this->encuentro5_a, $this->encuentro5_b, $this->encuentro6_a, $this->encuentro6_b, $this->encuentro7_a, $this->encuentro7_b);
    //     Executor::doit($sql, $params);
    // }
        public function registro_competicionDH(){
            $sql = "insert into ".self::$tablename." (encuentro1_a,encuentro1_b,encuentro2_a,encuentro2_b,encuentro3_a,encuentro3_b,encuentro4_a,encuentro4_b,fecha_encuentro, sala) ";
            $sql .= "value (\"$this->encuentro1_a\",\"$this->encuentro1_b\",\"$this->encuentro2_a\",\"$this->encuentro2_b\",\"$this->encuentro3_a\",\"$this->encuentro3_b\",\"$this->encuentro4_a\",\"$this->encuentro4_b\",\"$this->fecha_encuentro\",\"$this->sala\")";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set fecha_encuentro=\"$this->fecha_encuentro\" where id=$this->id";
            Executor::doit($sql);
        }
        public function validararbitro(){
            $sql = "update ".self::$tablename." set arbitro=\"$this->arbitro\",observacion_arbitro=\"$this->observacion_arbitro\",firma_arbitro=\"$this->firma_arbitro\" where id=$this->id";
            Executor::doit($sql);
        }
        public function validararfma(){
            $sql = "update ".self::$tablename." set obervacion_fma=\"$this->obervacion_fma\",aprobacion=\"$this->aprobacion\" where id=$this->id";
            Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select c.* from ".self::$tablename." c  where c.id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new CompetenciasData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        public static function vercontenido(){
            $sql = "select * from ".self::$tablename;
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompetenciasData());
        }
        public static function listarrivales($sala, $equipo){
            $sql = " SELECT 
                        rival,
                        SUM(accion) AS total_accion
                    FROM (
                        SELECT 
                            CASE 
                                WHEN c.encuentro1_a = $equipo THEN c.encuentro1_b
                                WHEN c.encuentro1_b = $equipo THEN c.encuentro1_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro1_a = $equipo THEN c.accion1_a
                                WHEN c.encuentro1_b = $equipo THEN c.accion1_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro1_a = $equipo OR c.encuentro1_b = $equipo)
                        UNION ALL
                        SELECT 
                            CASE 
                                WHEN c.encuentro2_a = $equipo THEN c.encuentro2_b
                                WHEN c.encuentro2_b = $equipo THEN c.encuentro2_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro2_a = $equipo THEN c.accion2_a
                                WHEN c.encuentro2_b = $equipo THEN c.accion2_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro2_a = $equipo OR c.encuentro2_b = $equipo)
                        UNION ALL
                        SELECT 
                            CASE 
                                WHEN c.encuentro3_a = $equipo THEN c.encuentro3_b
                                WHEN c.encuentro3_b = $equipo THEN c.encuentro3_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro3_a = $equipo THEN c.accion3_a
                                WHEN c.encuentro3_b = $equipo THEN c.accion3_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro3_a = $equipo OR c.encuentro3_b = $equipo)
                        UNION ALL
                        SELECT 
                            CASE 
                                WHEN c.encuentro4_a = $equipo THEN c.encuentro4_b
                                WHEN c.encuentro4_b = $equipo THEN c.encuentro4_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro4_a = $equipo THEN c.accion4_a
                                WHEN c.encuentro4_b = $equipo THEN c.accion4_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro4_a = $equipo OR c.encuentro4_b = $equipo)
                        UNION ALL
                        SELECT 
                            CASE 
                                WHEN c.encuentro5_a = $equipo THEN c.encuentro5_b
                                WHEN c.encuentro5_b = $equipo THEN c.encuentro5_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro5_a = $equipo THEN c.accion5_a
                                WHEN c.encuentro5_b = $equipo THEN c.accion5_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro5_a = $equipo OR c.encuentro5_b = $equipo)
                        UNION ALL
                        SELECT 
                            CASE 
                                WHEN c.encuentro6_a = $equipo THEN c.encuentro6_b
                                WHEN c.encuentro6_b = $equipo THEN c.encuentro6_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro6_a = $equipo THEN c.accion6_a
                                WHEN c.encuentro6_b = $equipo THEN c.accion6_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro6_a = $equipo OR c.encuentro6_b = $equipo)
                        UNION ALL
                        SELECT 
                            CASE 
                                WHEN c.encuentro7_a = $equipo THEN c.encuentro7_b
                                WHEN c.encuentro7_b = $equipo THEN c.encuentro7_a
                            END AS rival,
                            CASE
                                WHEN c.encuentro7_a = $equipo THEN c.accion7_a
                                WHEN c.encuentro7_b = $equipo THEN c.accion7_b
                            END AS accion
                        FROM competencias c
                        WHERE c.sala = $sala AND (c.encuentro7_a = $equipo OR c.encuentro7_b = $equipo)
                    ) AS subquery
                    WHERE rival IS NOT NULL
                    GROUP BY rival ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompetenciasData());
        }
        public static function vercontenidos2(){
            $sql = "SELECT DATE(co.fecha_encuentro) AS start, co.id, c.nombregrupo as title, '2' AS adicional  
                    FROM competencias co 
                    JOIN sala s ON co.sala = s.id
                    JOIN competicion c ON s.competicion = c.id
                    GROUP BY DATE(fecha_encuentro)";
            $query = Executor::doit($sql);
            return Model::many($query[0], new CompetenciasData());
        }

        public static function vercontenidos($sala){
            $sql = "select c.*, e.nombre as equipo1, e1.nombre as equipo2, e2.nombre as equipo3, e3.nombre as equipo4, e4.nombre as equipo5, e5.nombre as equipo6, e6.nombre as equipo7, e7.nombre as equipo8, e8.nombre as equipo9, e9.nombre as equipo10, e10.nombre as equipo11, e11.nombre as equipo12, e12.nombre as equipo13, e13.nombre as equipo14 from ".self::$tablename." c 
            LEFT JOIN equipo e ON e.id=c.encuentro1_a 
            LEFT JOIN equipo e1 ON e1.id=c.encuentro1_b 
            LEFT JOIN equipo e2 ON e2.id=c.encuentro2_a 
            LEFT JOIN equipo e3 ON e3.id=c.encuentro2_b

            LEFT JOIN equipo e4 ON e4.id=c.encuentro3_a 
            LEFT JOIN equipo e5 ON e5.id=c.encuentro3_b
            LEFT JOIN equipo e6 ON e6.id=c.encuentro4_a 
            LEFT JOIN equipo e7 ON e7.id=c.encuentro4_b
            LEFT JOIN equipo e8 ON e8.id=c.encuentro5_a 
            LEFT JOIN equipo e9 ON e9.id=c.encuentro5_b
            LEFT JOIN equipo e10 ON e10.id=c.encuentro6_a 
            LEFT JOIN equipo e11 ON e11.id=c.encuentro6_b
            LEFT JOIN equipo e12 ON e12.id=c.encuentro7_a 
            LEFT JOIN equipo e13 ON e13.id=c.encuentro7_b

             where c.sala=$sala ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompetenciasData());
        }
        public static function vercontenidos1($sala){
            $sql = "select c.*, e.nombre as equipo1, e1.nombre as equipo2, e2.nombre as equipo3, e3.nombre as equipo4, e4.nombre as equipo5, e5.nombre as equipo6, e6.nombre as equipo7, e7.nombre as equipo8 from ".self::$tablename." c 
            JOIN equipo e ON e.id=c.encuentro1_a 
            JOIN equipo e1 ON e1.id=c.encuentro1_b 
            JOIN equipo e2 ON e2.id=c.encuentro2_a 
            JOIN equipo e3 ON e3.id=c.encuentro2_b

            JOIN equipo e4 ON e4.id=c.encuentro3_a 
            JOIN equipo e5 ON e5.id=c.encuentro3_b
            JOIN equipo e6 ON e6.id=c.encuentro4_a 
            JOIN equipo e7 ON e7.id=c.encuentro4_b

             where c.sala=$sala ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompetenciasData());
        }
        public static function vertotal($liga){
            $sql = "select * from ".self::$tablename." where liga=$liga ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new CompetenciasData());
        }
        public static function vertotalmax($liga) {
		    $sql = "SELECT MAX(id) as max_id FROM " . self::$tablename . " WHERE liga=$liga";
		    $query = Executor::doit($sql);
		    $result = Model::one($query[0], new CompetenciasData());
		    return $result ? $result->max_id : null;
		}
        public static function duplicidad($sala,$fecha_encuentro){
        $sql = "select * from ".self::$tablename." where sala=\"$sala\" and fecha_encuentro=\"$fecha_encuentro\" ";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new CompetenciasData();
            $array[$cnt]->sala = $r['sala'];
            $array[$cnt]->fecha_encuentro = $r['fecha_encuentro'];
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
            return Model::many($query[0], new CompetenciasData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new CompetenciasData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename;
            if ($search) {
                $sql .= " WHERE nombre LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new CompetenciasData());
            return $result->total;
        }
    }
?>