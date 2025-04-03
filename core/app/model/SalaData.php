<?php
class SalaData {
    public static $tablename = "sala";
        public $id;
        public $codigo;
        public $liga;
        public $competicion;
        public $personalizada;
        public $count;
        public $total;
        public $last_id;
        public $ligas;
        public $competiciones;
        public $nombregrupo;
        public $sala_codigo;
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
        public $tipocompeticones1;
        public $estado;
        public $tipocompeticiones1;
        public $competencia_id;
        public $equipo_a;
        public $equipo_b;
        public $estado_a;
        public $resultado_a;
        public $estado_b;
        public $resultado_b;
        public $nombreligas;
        public $nombrequipo_a;
        public $nombrequipo_b;
        public $aprobacion;
        public $observacion;
        public $firma;
        public $observacion_a;
        public $firma_a;
        public $observacion_b;
        public $firma_b;
        public $usuario;
        public $equipo;
        public $veces_jugadas;
        public $victorias;
        public $empates;
        public $derrotas;
        public $incomparecencias;
        public $puntos;
        public $olimpico;
        public $sonnenborg_berger;
        public $sala;
        public $tipocompeticiones;
        public $grupo;
        public $nomequipoa;
        public $nomequipob;
        public $nomequipo;
        public $fecha;
        public $sancion_equipo ;
        public $sancion_total ;
        public $puntos_rival;
        public $adicional;
        public function registro(){
            $sql = "insert into ".self::$tablename." (codigo,liga,competicion) ";
            $sql .= "value (\"$this->codigo\",\"$this->liga\",\"$this->competicion\")";
            return Executor::doit($sql);
        }
        public function registro1(){
            $sql = "insert into ".self::$tablename." (codigo,liga,competicion,personalizada) ";
            $sql .= "value (\"$this->codigo\",\"$this->liga\",\"$this->competicion\",1)";
            return Executor::doit($sql);
        }
        public function actualizar(){
            $sql = "update ".self::$tablename." set sucursal=\"$this->sucursal\", nombre=\"$this->nombre\", duplicidad=\"$this->duplicidad\" where id=$this->id";
            Executor::doit($sql);
        }
        public static function verid($id){
            $sql = "select c.*, l.nombre as nombreligas, co.nombregrupo from ".self::$tablename." c JOIN liga l ON l.id=c.liga JOIN competicion co ON co.id=c.competicion where c.id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new SalaData());
        }
        public static function verid1($id){
            $sql = "select c.*, l.nombre as nombreligas, co.nombregrupo,ti.nombre as tipocompeticiones,co.grupo from ".self::$tablename." c JOIN liga l ON l.id=c.liga 
                    JOIN competicion co ON co.id=c.competicion 
                    JOIN tipocompeticiones ti ON ti.id=co.tipocompeticion
                    where c.id=$id";
            $query = Executor::doit($sql);
            return Model::one($query[0],new SalaData());
        }
        public function eliminar(){
            $sql = "delete from ".self::$tablename." where id=$this->id";
            Executor::doit($sql);
        }
        
        public static function verultimoid(){
            $sql = "SELECT MAX(id) AS last_id FROM " . self::$tablename;
            $query = Executor::doit($sql);
            $result = Model::one($query[0],new SalaData());
            return $result ? $result->last_id : null;
        }
        public static function vercontenido($liga){
            $sql = "select c.*, e.nombre from ".self::$tablename." c JOIN equipo e ON e.id=c.equipo  WHERE c.liga=$liga ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }
        public static function vercontenidos(){
            $sql = " SELECT 
                s.codigo AS sala_codigo,
                c.encuentro1_a, c.encuentro1_b,
                c.encuentro2_a, c.encuentro2_b,
                c.encuentro3_a, c.encuentro3_b,
                c.encuentro4_a, c.encuentro4_b,
                c.encuentro5_a, c.encuentro5_b,
                c.encuentro6_a, c.encuentro6_b,
                c.encuentro7_a, c.encuentro7_b,
                c.fecha_encuentro
            FROM 
                sala s
            JOIN 
                competencias c ON s.id = c.sala
            ORDER BY 
                s.codigo, c.fecha_encuentro ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }
        // public static function vercontenidos1(){
        //     $sql = "SELECT 
        //             t.nombre AS tipocompeticones1,
        //             s.competicion AS competicion,
        //             s.codigo AS sala_codigo,
        //             c.encuentro1_a, c.encuentro1_b,
        //             c.encuentro2_a, c.encuentro2_b,
        //             c.encuentro3_a, c.encuentro3_b,
        //             c.encuentro4_a, c.encuentro4_b,
        //             c.encuentro5_a, c.encuentro5_b,
        //             c.encuentro6_a, c.encuentro6_b,
        //             c.encuentro7_a, c.encuentro7_b,
        //             c.fecha_encuentro
        //         FROM 
        //             sala s
        //         JOIN 
        //             competencias c ON s.id = c.sala
        //         JOIN 
        //             competicion comp ON comp.id = s.competicion
        //         JOIN 
        //             tipocompeticiones t ON t.id = comp.tipocompeticion 
        //         WHERE 
        //             c.estado=1
        //         ORDER BY 
        //             t.nombre, c.fecha_encuentro;
        //         ";
        //     $query = Executor::doit($sql);
        //     return Model::many($query[0], new SalaData());
        // }
        public static function vercontenidos1(){
            $sql = "SELECT 
                        t.nombre AS tipocompeticones1,
                        s.competicion AS competicion,
                        s.codigo AS sala_codigo,
                        c.encuentro1_a, c.encuentro1_b,
                        c.encuentro2_a, c.encuentro2_b,
                        c.encuentro3_a, c.encuentro3_b,
                        c.encuentro4_a, c.encuentro4_b,
                        c.encuentro5_a, c.encuentro5_b,
                        c.encuentro6_a, c.encuentro6_b,
                        c.encuentro7_a, c.encuentro7_b,
                        c.fecha_encuentro
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion comp ON comp.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = comp.tipocompeticion 
                    ORDER BY 
                        t.nombre,
                        CASE 
                            WHEN c.estado = 1 THEN 0
                            ELSE 1
                        END,
                        CASE 
                            WHEN c.fecha_encuentro < CURDATE() THEN 0
                            ELSE 1
                        END,
                        ABS(DATEDIFF(c.fecha_encuentro, CURDATE())),
                        c.fecha_encuentro";
                        
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }
        public static function vercontenidos2(){
            $sql = "SELECT *
                FROM (
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre AS tipocompeticiones1,
                        s.competicion AS competicion,
                        s.codigo AS sala_codigo,
                        c.encuentro1_a AS equipo_a,
                        c.estado1_a AS estado_a,
                        c.accion1_a AS resultado_a,
                        c.encuentro1_b AS equipo_b,
                        c.estado1_b AS estado_b,
                        c.accion1_b AS resultado_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre as nombrequipo_a,
                        e1.nombre as nombrequipo_b

                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro1_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro1_b
                    WHERE 
                        c.encuentro1_a IS NOT NULL AND c.encuentro1_b IS NOT NULL AND c.encuentro1_a <> '' AND c.encuentro1_b <> ''
                    UNION ALL
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre,
                        s.competicion,
                        s.codigo,
                        c.encuentro2_a,
                        c.estado2_a,
                        c.accion2_a,
                        c.encuentro2_b,
                        c.estado2_b,
                        c.accion2_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre,
                        e1.nombre
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro2_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro2_b
                    WHERE 
                        c.encuentro2_a IS NOT NULL AND c.encuentro2_b IS NOT NULL AND c.encuentro2_a <> '' AND c.encuentro2_b <> ''
                    UNION ALL
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre,
                        s.competicion,
                        s.codigo,
                        c.encuentro3_a,
                        c.estado3_a,
                        c.accion3_a,
                        c.encuentro3_b,
                        c.estado3_b,
                        c.accion3_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre,
                        e1.nombre
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro3_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro3_b
                    WHERE 
                        c.encuentro3_a IS NOT NULL AND c.encuentro3_b IS NOT NULL AND c.encuentro3_a <> '' AND c.encuentro3_b <> ''
                    UNION ALL
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre,
                        s.competicion,
                        s.codigo,
                        c.encuentro4_a,
                        c.estado4_a,
                        c.accion4_a,
                        c.encuentro4_b,
                        c.estado4_b,
                        c.accion4_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre,
                        e1.nombre
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro4_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro4_b
                    WHERE 
                        c.encuentro4_a IS NOT NULL AND c.encuentro4_b IS NOT NULL AND c.encuentro4_a <> '' AND c.encuentro4_b <> ''
                    UNION ALL
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre,
                        s.competicion,
                        s.codigo,
                        c.encuentro5_a,
                        c.estado5_a,
                        c.accion5_a,
                        c.encuentro5_b,
                        c.estado5_b,
                        c.accion5_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre,
                        e1.nombre
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro5_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro5_b
                    WHERE 
                        c.encuentro5_a IS NOT NULL AND c.encuentro5_b IS NOT NULL AND c.encuentro5_a <> '' AND c.encuentro5_b <> ''
                    UNION ALL
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre,
                        s.competicion,
                        s.codigo,
                        c.encuentro6_a,
                        c.estado6_a,
                        c.accion6_a,
                        c.encuentro6_b,
                        c.estado6_b,
                        c.accion6_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre,
                        e1.nombre
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro6_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro6_b
                    WHERE 
                        c.encuentro6_a IS NOT NULL AND c.encuentro6_b IS NOT NULL AND c.encuentro6_a <> '' AND c.encuentro6_b <> ''
                    UNION ALL
                    SELECT 
                        c.id AS competencia_id,
                        t.nombre,
                        s.competicion,
                        s.codigo,
                        c.encuentro7_a,
                        c.estado7_a,
                        c.accion7_a,
                        c.encuentro7_b,
                        c.estado7_b,
                        c.accion7_b,
                        c.fecha_encuentro,
                        c2.nombregrupo,
                        e.nombre,
                        e1.nombre
                    FROM 
                        sala s
                    JOIN 
                        competencias c ON s.id = c.sala
                    JOIN 
                        competicion c2 ON c2.id = s.competicion
                    JOIN 
                        tipocompeticiones t ON t.id = c2.tipocompeticion
                    JOIN 
                        equipo e ON e.id = c.encuentro7_a
                    JOIN 
                        equipo e1 ON e1.id = c.encuentro7_b
                    WHERE 
                        c.encuentro7_a IS NOT NULL AND c.encuentro7_b IS NOT NULL AND c.encuentro7_a <> '' AND c.encuentro7_b <> ''
                ) AS subquery
                ORDER BY 
                    tipocompeticiones1, fecha_encuentro, competicion, sala_codigo";  
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }
        public static function vercontenidos3(){
            $sql = "SELECT *
                        FROM (
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro1_a AS equipo_a,
                                c.estado1_a AS estado_a,
                                c.accion1_a AS resultado_a,
                                c.encuentro1_b AS equipo_b,
                                c.estado1_b AS estado_b,
                                c.accion1_b AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre as nombrequipo_a,
                                e1.nombre as nombrequipo_b,
                                c.aprobacion1 as aprobacion,
                                c.firma1_a as firma_a,
                                c.observacion1_b as observacion_b,
                                c.firma1_b as firma_b,
                                u.ci as usuario
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro1_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro1_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario1
                            WHERE 
                                c.encuentro1_a IS NOT NULL AND c.encuentro1_b IS NOT NULL AND c.encuentro1_a <> '' AND c.encuentro1_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro2_a,
                                c.estado2_a,
                                c.accion2_a,
                                c.encuentro2_b,
                                c.estado2_b,
                                c.accion2_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion2,
                                c.firma2_a,
                                c.observacion2_b,
                                c.firma2_b,
                                u.ci
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro2_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro2_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario2
                            WHERE 
                                c.encuentro2_a IS NOT NULL AND c.encuentro2_b IS NOT NULL AND c.encuentro2_a <> '' AND c.encuentro2_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro3_a,
                                c.estado3_a,
                                c.accion3_a,
                                c.encuentro3_b,
                                c.estado3_b,
                                c.accion3_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion3,
                                c.firma3_a,
                                c.observacion3_b,
                                c.firma3_b,
                                u.ci
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro3_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro3_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario3
                            WHERE 
                                c.encuentro3_a IS NOT NULL AND c.encuentro3_b IS NOT NULL AND c.encuentro3_a <> '' AND c.encuentro3_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro4_a,
                                c.estado4_a,
                                c.accion4_a,
                                c.encuentro4_b,
                                c.estado4_b,
                                c.accion4_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion4,
                                c.firma4_a,
                                c.observacion4_b,
                                c.firma4_b,
                                u.ci
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro4_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro4_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario4
                            WHERE 
                                c.encuentro4_a IS NOT NULL AND c.encuentro4_b IS NOT NULL AND c.encuentro4_a <> '' AND c.encuentro4_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro5_a,
                                c.estado5_a,
                                c.accion5_a,
                                c.encuentro5_b,
                                c.estado5_b,
                                c.accion5_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion5,
                                c.firma5_a,
                                c.observacion5_b,
                                c.firma5_b,
                                u.ci
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro5_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro5_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario5
                            WHERE 
                                c.encuentro5_a IS NOT NULL AND c.encuentro5_b IS NOT NULL AND c.encuentro5_a <> '' AND c.encuentro5_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro6_a,
                                c.estado6_a,
                                c.accion6_a,
                                c.encuentro6_b,
                                c.estado6_b,
                                c.accion6_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion6,
                                c.firma6_a,
                                c.observacion6_b,
                                c.firma6_b,
                                u.ci
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro6_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro6_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario6
                            WHERE 
                                c.encuentro6_a IS NOT NULL AND c.encuentro6_b IS NOT NULL AND c.encuentro6_a <> '' AND c.encuentro6_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro7_a,
                                c.estado7_a,
                                c.accion7_a,
                                c.encuentro7_b,
                                c.estado7_b,
                                c.accion7_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion7,
                                c.firma7_a,
                                c.observacion7_b,
                                c.firma7_b,
                                u.ci
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro7_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro7_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario7
                            WHERE 
                                c.encuentro7_a IS NOT NULL AND c.encuentro7_b IS NOT NULL AND c.encuentro7_a <> '' AND c.encuentro7_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                        ) AS subquery
                        ORDER BY 
                            tipocompeticiones1, fecha_encuentro, competicion, sala_codigo";
                        
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }
        public static function vercontenidos4(){
            $sql = "SELECT *
                        FROM (
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro1_a AS equipo_a,
                                c.estado1_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro1_b AS equipo_b,
                                c.estado1_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro1_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro1_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro1_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro1_b
                            WHERE 
                                c.encuentro1_a IS NOT NULL AND c.encuentro1_b IS NOT NULL AND c.encuentro1_a <> '' AND c.encuentro1_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro1_a, c.estado1_a, c.encuentro1_b, c.estado1_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro2_a AS equipo_a,
                                c.estado2_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro2_b AS equipo_b,
                                c.estado2_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro2_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro2_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro2_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro2_b
                            WHERE 
                                c.encuentro2_a IS NOT NULL AND c.encuentro2_b IS NOT NULL AND c.encuentro2_a <> '' AND c.encuentro2_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro2_a, c.estado2_a, c.encuentro2_b, c.estado2_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro3_a AS equipo_a,
                                c.estado3_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro3_b AS equipo_b,
                                c.estado3_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro3_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro3_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro3_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro3_b
                            WHERE 
                                c.encuentro3_a IS NOT NULL AND c.encuentro3_b IS NOT NULL AND c.encuentro3_a <> '' AND c.encuentro3_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro3_a, c.estado3_a, c.encuentro3_b, c.estado3_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro4_a AS equipo_a,
                                c.estado4_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro4_b AS equipo_b,
                                c.estado4_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro4_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro4_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro4_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro4_b
                            WHERE 
                                c.encuentro4_a IS NOT NULL AND c.encuentro4_b IS NOT NULL AND c.encuentro4_a <> '' AND c.encuentro4_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro4_a, c.estado4_a, c.encuentro4_b, c.estado4_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro5_a AS equipo_a,
                                c.estado5_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro5_b AS equipo_b,
                                c.estado5_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro5_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro5_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro5_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro5_b
                            WHERE 
                                c.encuentro5_a IS NOT NULL AND c.encuentro5_b IS NOT NULL AND c.encuentro5_a <> '' AND c.encuentro5_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro5_a, c.estado5_a, c.encuentro5_b, c.estado5_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro6_a AS equipo_a,
                                c.estado6_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro6_b AS equipo_b,
                                c.estado6_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro6_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro6_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro6_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro6_b
                            WHERE 
                                c.encuentro6_a IS NOT NULL AND c.encuentro6_b IS NOT NULL AND c.encuentro6_a <> '' AND c.encuentro6_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro6_a, c.estado6_a, c.encuentro6_b, c.estado6_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro7_a AS equipo_a,
                                c.estado7_a AS estado_a,
                                COALESCE(SUM(CASE WHEN a.resultado = '1' THEN 1
                                                  WHEN a.resultado = '1/2' THEN 0.5
                                                  WHEN a.resultado = '0' THEN 0
                                                  WHEN a.resultado = '+' THEN 1
                                                  WHEN a.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_a,
                                c.encuentro7_b AS equipo_b,
                                c.estado7_b AS estado_b,
                                COALESCE(SUM(CASE WHEN a1.resultado = '1' THEN 1
                                                  WHEN a1.resultado = '1/2' THEN 0.5
                                                  WHEN a1.resultado = '0' THEN 0
                                                  WHEN a1.resultado = '+' THEN 1
                                                  WHEN a1.resultado = '-' THEN 0
                                                  ELSE 0
                                              END), 0) AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre AS nombrequipo_a,
                                e1.nombre AS nombrequipo_b
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro7_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro7_b
                            LEFT JOIN 
                                acta a ON a.competencias = c.id AND a.equipo = c.encuentro7_a
                            LEFT JOIN 
                                acta a1 ON a1.competencias = c.id AND a1.equipo = c.encuentro7_b
                            WHERE 
                                c.encuentro7_a IS NOT NULL AND c.encuentro7_b IS NOT NULL AND c.encuentro7_a <> '' AND c.encuentro7_b <> '' AND 
                                c.estado = 1 AND c.fecha_encuentro = CURDATE()
                            GROUP BY 
                                c.id, t.nombre, s.competicion, s.codigo, c.encuentro7_a, c.estado7_a, c.encuentro7_b, c.estado7_b, 
                                c.fecha_encuentro, c2.nombregrupo, e.nombre, e1.nombre
                        ) AS subquery
                        ORDER BY estado_a DESC, estado_b DESC, fecha_encuentro DESC";
                        
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }

        public static function duplicidadd($duplicidad){
        $sql = "select * from ".self::$tablename." where duplicidad=\"$duplicidad\"";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while($r = $query[0]->fetch_array()){
            $array[$cnt] = new SalaData();
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
            $sql = "SELECT c.*, l.nombre as ligas, CONCAT(co.nombregrupo, ' (' ,co.grupo, ') ', tp.nombre) as competiciones, co.nombregrupo as nombregrupo FROM ".self::$tablename;
            $sql .= " c JOIN liga l ON l.id=c.liga JOIN competicion co ON co.id=c.competicion JOIN tipocompeticiones tp ON tp.id=co.tipocompeticion WHERE c.personalizada=0";
            if ($search) {
                $sql .= " AND c.codigo LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }
        public static function totalRegistro(){
            $sql = "select COUNT(*) as total from ".self::$tablename." where personalizada=0 ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SalaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados($search){
            $sql = "select COUNT(*) as total from ".self::$tablename." where personalizada=0 ";
            if ($search) {
                $sql .= " WHERE codigo LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SalaData());
            return $result->total;
        }

        public static function vercontenidoPaginado1($start, $length, $search = ''){
            $sql = "SELECT c.*, l.nombre as ligas, CONCAT(co.nombregrupo, ' (' ,co.grupo, ') ', tp.nombre) as competiciones, co.nombregrupo as nombregrupo FROM ".self::$tablename;
            $sql .= " c JOIN liga l ON l.id=c.liga JOIN competicion co ON co.id=c.competicion JOIN tipocompeticiones tp ON tp.id=co.tipocompeticion WHERE c.personalizada=1";
            if ($search) {
                $sql .= " AND c.codigo LIKE '%$search%'";
            }
            $sql .= " LIMIT $start, $length";
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }
        public static function totalRegistro1(){
            $sql = "select COUNT(*) as total from ".self::$tablename." where personalizada=1 ";
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SalaData());
            return $result->total;
        }
        public static function totalRegistrosFiltrados1($search){
            $sql = "select COUNT(*) as total from ".self::$tablename." where personalizada=1 ";
            if ($search) {
                $sql .= " WHERE codigo LIKE '%$search%'";
            }
            $query = Executor::doit($sql);
            $result = Model::one($query[0], new SalaData());
            return $result->total;
        }

        public static function clasificacion(){
            $sql = "SELECT
                    equipo,
                    COUNT(*) AS veces_jugadas,
                    SUM(victoria) AS victorias,
                    SUM(empate) AS empates,
                    SUM(derrota) AS derrotas,
                    SUM(incomparecencia) AS incomparecencias,
                    SUM(
                        CASE 
                            WHEN victoria = 1 THEN 3
                            WHEN empate = 1 THEN 2
                            WHEN derrota = 1 THEN 1
                            ELSE 0 
                        END
                    ) AS puntos,
                    SUM(accion) AS olimpico,
                    SUM(sonnenborg_berger) AS sonnenborg_berger
                FROM (
                    -- Encuentro 1
                    SELECT 
                        encuentro1_a AS equipo, 
                        CASE WHEN accion1_a = '-' OR accion1_b = '-' THEN 0 ELSE accion1_a END AS accion,
                        CASE WHEN accion1_a > accion1_b AND accion1_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion1_a = accion1_b AND accion1_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion1_a < accion1_b AND accion1_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion1_a = '-' OR accion1_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion1_b = '-' THEN 0
                            WHEN accion1_b > accion1_a THEN 3
                            WHEN accion1_b = accion1_a THEN 2
                            WHEN accion1_b < accion1_a THEN 1
                            ELSE 0
                        END) * accion1_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion1_a IS NOT NULL AND accion1_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro1_b AS equipo, 
                        CASE WHEN accion1_b = '-' OR accion1_a = '-' THEN 0 ELSE accion1_b END AS accion,
                        CASE WHEN accion1_b > accion1_a AND accion1_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion1_b = accion1_a AND accion1_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion1_b < accion1_a AND accion1_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion1_b = '-' OR accion1_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion1_a = '-' THEN 0
                            WHEN accion1_a > accion1_b THEN 3
                            WHEN accion1_a = accion1_b THEN 2
                            WHEN accion1_a < accion1_b THEN 1
                            ELSE 0
                        END) * accion1_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion1_a IS NOT NULL AND accion1_b IS NOT NULL
                    
                    UNION ALL
                    
                    -- Encuentro 2
                    SELECT 
                        encuentro2_a AS equipo, 
                        CASE WHEN accion2_a = '-' OR accion2_b = '-' THEN 0 ELSE accion2_a END AS accion,
                        CASE WHEN accion2_a > accion2_b AND accion2_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion2_a = accion2_b AND accion2_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion2_a < accion2_b AND accion2_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion2_a = '-' OR accion2_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion2_b = '-' THEN 0
                            WHEN accion2_b > accion2_a THEN 3
                            WHEN accion2_b = accion2_a THEN 2
                            WHEN accion2_b < accion2_a THEN 1
                            ELSE 0
                        END) * accion2_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion2_a IS NOT NULL AND accion2_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro2_b AS equipo, 
                        CASE WHEN accion2_b = '-' OR accion2_a = '-' THEN 0 ELSE accion2_b END AS accion,
                        CASE WHEN accion2_b > accion2_a AND accion2_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion2_b = accion2_a AND accion2_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion2_b < accion2_a AND accion2_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion2_b = '-' OR accion2_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion2_a = '-' THEN 0
                            WHEN accion2_a > accion2_b THEN 3
                            WHEN accion2_a = accion2_b THEN 2
                            WHEN accion2_a < accion2_b THEN 1
                            ELSE 0
                        END) * accion2_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion2_a IS NOT NULL AND accion2_b IS NOT NULL
                    
                    UNION ALL
                    
                    -- Encuentro 3
                    SELECT 
                        encuentro3_a AS equipo, 
                        CASE WHEN accion3_a = '-' OR accion3_b = '-' THEN 0 ELSE accion3_a END AS accion,
                        CASE WHEN accion3_a > accion3_b AND accion3_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion3_a = accion3_b AND accion3_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion3_a < accion3_b AND accion3_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion3_a = '-' OR accion3_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion3_b = '-' THEN 0
                            WHEN accion3_b > accion3_a THEN 3
                            WHEN accion3_b = accion3_a THEN 2
                            WHEN accion3_b < accion3_a THEN 1
                            ELSE 0
                        END) * accion3_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion3_a IS NOT NULL AND accion3_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro3_b AS equipo, 
                        CASE WHEN accion3_b = '-' OR accion3_a = '-' THEN 0 ELSE accion3_b END AS accion,
                        CASE WHEN accion3_b > accion3_a AND accion3_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion3_b = accion3_a AND accion3_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion3_b < accion3_a AND accion3_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion3_b = '-' OR accion3_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion3_a = '-' THEN 0
                            WHEN accion3_a > accion3_b THEN 3
                            WHEN accion3_a = accion3_b THEN 2
                            WHEN accion3_a < accion3_b THEN 1
                            ELSE 0
                        END) * accion3_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion3_a IS NOT NULL AND accion3_b IS NOT NULL
                    
                    UNION ALL
                    
                    -- Encuentro 4
                    SELECT 
                        encuentro4_a AS equipo, 
                        CASE WHEN accion4_a = '-' OR accion4_b = '-' THEN 0 ELSE accion4_a END AS accion,
                        CASE WHEN accion4_a > accion4_b AND accion4_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion4_a = accion4_b AND accion4_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion4_a < accion4_b AND accion4_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion4_a = '-' OR accion4_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion4_b = '-' THEN 0
                            WHEN accion4_b > accion4_a THEN 3
                            WHEN accion4_b = accion4_a THEN 2
                            WHEN accion4_b < accion4_a THEN 1
                            ELSE 0
                        END) * accion4_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion4_a IS NOT NULL AND accion4_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro4_b AS equipo, 
                        CASE WHEN accion4_b = '-' OR accion4_a = '-' THEN 0 ELSE accion4_b END AS accion,
                        CASE WHEN accion4_b > accion4_a AND accion4_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion4_b = accion4_a AND accion4_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion4_b < accion4_a AND accion4_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion4_b = '-' OR accion4_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion4_a = '-' THEN 0
                            WHEN accion4_a > accion4_b THEN 3
                            WHEN accion4_a = accion4_b THEN 2
                            WHEN accion4_a < accion4_b THEN 1
                            ELSE 0
                        END) * accion4_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion4_a IS NOT NULL AND accion4_b IS NOT NULL
                    
                    UNION ALL
                    
                    -- Encuentro 5
                    SELECT 
                        encuentro5_a AS equipo, 
                        CASE WHEN accion5_a = '-' OR accion5_b = '-' THEN 0 ELSE accion5_a END AS accion,
                        CASE WHEN accion5_a > accion5_b AND accion5_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion5_a = accion5_b AND accion5_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion5_a < accion5_b AND accion5_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion5_a = '-' OR accion5_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion5_b = '-' THEN 0
                            WHEN accion5_b > accion5_a THEN 3
                            WHEN accion5_b = accion5_a THEN 2
                            WHEN accion5_b < accion5_a THEN 1
                            ELSE 0
                        END) * accion5_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion5_a IS NOT NULL AND accion5_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro5_b AS equipo, 
                        CASE WHEN accion5_b = '-' OR accion5_a = '-' THEN 0 ELSE accion5_b END AS accion,
                        CASE WHEN accion5_b > accion5_a AND accion5_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion5_b = accion5_a AND accion5_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion5_b < accion5_a AND accion5_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion5_b = '-' OR accion5_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion5_a = '-' THEN 0
                            WHEN accion5_a > accion5_b THEN 3
                            WHEN accion5_a = accion5_b THEN 2
                            WHEN accion5_a < accion5_b THEN 1
                            ELSE 0
                        END) * accion5_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion5_a IS NOT NULL AND accion5_b IS NOT NULL
                    
                    UNION ALL
                    
                    -- Encuentro 6
                    SELECT 
                        encuentro6_a AS equipo, 
                        CASE WHEN accion6_a = '-' OR accion6_b = '-' THEN 0 ELSE accion6_a END AS accion,
                        CASE WHEN accion6_a > accion6_b AND accion6_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion6_a = accion6_b AND accion6_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion6_a < accion6_b AND accion6_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion6_a = '-' OR accion6_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion6_b = '-' THEN 0
                            WHEN accion6_b > accion6_a THEN 3
                            WHEN accion6_b = accion6_a THEN 2
                            WHEN accion6_b < accion6_a THEN 1
                            ELSE 0
                        END) * accion6_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion6_a IS NOT NULL AND accion6_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro6_b AS equipo, 
                        CASE WHEN accion6_b = '-' OR accion6_a = '-' THEN 0 ELSE accion6_b END AS accion,
                        CASE WHEN accion6_b > accion6_a AND accion6_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion6_b = accion6_a AND accion6_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion6_b < accion6_a AND accion6_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion6_b = '-' OR accion6_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion6_a = '-' THEN 0
                            WHEN accion6_a > accion6_b THEN 3
                            WHEN accion6_a = accion6_b THEN 2
                            WHEN accion6_a < accion6_b THEN 1
                            ELSE 0
                        END) * accion6_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion6_a IS NOT NULL AND accion6_b IS NOT NULL
                    
                    UNION ALL
                    
                    -- Encuentro 7
                    SELECT 
                        encuentro7_a AS equipo, 
                        CASE WHEN accion7_a = '-' OR accion7_b = '-' THEN 0 ELSE accion7_a END AS accion,
                        CASE WHEN accion7_a > accion7_b AND accion7_b != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion7_a = accion7_b AND accion7_a != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion7_a < accion7_b AND accion7_a != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion7_a = '-' OR accion7_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion7_b = '-' THEN 0
                            WHEN accion7_b > accion7_a THEN 3
                            WHEN accion7_b = accion7_a THEN 2
                            WHEN accion7_b < accion7_a THEN 1
                            ELSE 0
                        END) * accion7_a AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion7_a IS NOT NULL AND accion7_b IS NOT NULL
                    
                    UNION ALL
                    
                    SELECT 
                        encuentro7_b AS equipo, 
                        CASE WHEN accion7_b = '-' OR accion7_a = '-' THEN 0 ELSE accion7_b END AS accion,
                        CASE WHEN accion7_b > accion7_a AND accion7_a != '-' THEN 1 ELSE 0 END AS victoria,
                        CASE WHEN accion7_b = accion7_a AND accion7_b != '-' THEN 1 ELSE 0 END AS empate,
                        CASE WHEN accion7_b < accion7_a AND accion7_b != '-' THEN 1 ELSE 0 END AS derrota,
                        CASE WHEN accion7_b = '-' OR accion7_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                        (CASE 
                            WHEN accion7_a = '-' THEN 0
                            WHEN accion7_a > accion7_b THEN 3
                            WHEN accion7_a = accion7_b THEN 2
                            WHEN accion7_a < accion7_b THEN 1
                            ELSE 0
                        END) * accion7_b AS sonnenborg_berger
                    FROM competencias 
                    WHERE sala = 14 AND accion7_a IS NOT NULL AND accion7_b IS NOT NULL
                ) AS resultados
                GROUP BY equipo
                ORDER BY puntos DESC, olimpico DESC, sonnenborg_berger DESC";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }
        public static function clasificacion1(){
            $sql = " SELECT estado, sala, equipo,
                COUNT(*) AS veces_jugadas,
                SUM(victoria) AS victorias,
                SUM(empate) AS empates,
                SUM(derrota) AS derrotas,
                SUM(incomparecencia) AS incomparecencias,
                SUM(
                    CASE 
                        WHEN victoria = 1 THEN 3
                        WHEN empate = 1 THEN 2
                        WHEN derrota = 1 THEN 1
                        ELSE 0 
                    END
                ) AS puntos,
                SUM(accion) AS olimpico,
                SUM(sonnenborg_berger) AS sonnenborg_berger
            FROM (
                SELECT encuentro1_a AS equipo, sala, estado,  
                       CASE WHEN accion1_a = '-' OR accion1_b = '-' THEN 0 ELSE accion1_a END AS accion,
                    CASE WHEN accion1_a > accion1_b AND accion1_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion1_a = accion1_b AND accion1_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion1_a < accion1_b AND accion1_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion1_a = '-' OR accion1_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion1_b = '-' THEN 0
                        WHEN accion1_b > accion1_a THEN 3
                        WHEN accion1_b = accion1_a THEN 2
                        WHEN accion1_b < accion1_a THEN 1
                        ELSE 0
                    END) * accion1_a AS sonnenborg_berger
                FROM competencias 

                WHERE encuentro1_a IS NOT NULL AND accion1_a IS NOT NULL AND accion1_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro1_b AS equipo, sala, estado,  
                       CASE WHEN accion1_b = '-' OR accion1_a = '-' THEN 0 ELSE accion1_b END AS accion,
                    CASE WHEN accion1_b > accion1_a AND accion1_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion1_b = accion1_a AND accion1_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion1_b < accion1_a AND accion1_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion1_b = '-' OR accion1_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion1_a = '-' THEN 0
                        WHEN accion1_a > accion1_b THEN 3
                        WHEN accion1_a = accion1_b THEN 2
                        WHEN accion1_a < accion1_b THEN 1
                        ELSE 0
                    END) * accion1_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro1_b IS NOT NULL AND accion1_b IS NOT NULL AND accion1_a IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro2_a AS equipo, sala, estado,  
                       CASE WHEN accion2_a = '-' OR accion2_b = '-' THEN 0 ELSE accion2_a END AS accion,
                    CASE WHEN accion2_a > accion2_b AND accion2_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion2_a = accion2_b AND accion2_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion2_a < accion2_b AND accion2_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion2_a = '-' OR accion2_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion2_b = '-' THEN 0
                        WHEN accion2_b > accion2_a THEN 3
                        WHEN accion2_b = accion2_a THEN 2
                        WHEN accion2_b < accion2_a THEN 1
                        ELSE 0
                    END) * accion2_a AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro2_a IS NOT NULL AND accion2_a IS NOT NULL AND accion2_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro2_b AS equipo, sala, estado,  
                       CASE WHEN accion2_b = '-' OR accion2_a = '-' THEN 0 ELSE accion2_b END AS accion,
                    CASE WHEN accion2_b > accion2_a AND accion2_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion2_b = accion2_a AND accion2_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion2_b < accion2_a AND accion2_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion2_b = '-' OR accion2_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion2_a = '-' THEN 0
                        WHEN accion2_a > accion2_b THEN 3
                        WHEN accion2_a = accion2_b THEN 2
                        WHEN accion2_a < accion2_b THEN 1
                        ELSE 0
                    END) * accion2_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro2_b IS NOT NULL AND accion2_b IS NOT NULL AND accion2_a IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro3_a AS equipo, sala, estado,  
                       CASE WHEN accion3_a = '-' OR accion3_b = '-' THEN 0 ELSE accion3_a END AS accion,
                    CASE WHEN accion3_a > accion3_b AND accion3_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion3_a = accion3_b AND accion3_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion3_a < accion3_b AND accion3_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion3_a = '-' OR accion3_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion3_b = '-' THEN 0
                        WHEN accion3_b > accion3_a THEN 3
                        WHEN accion3_b = accion3_a THEN 2
                        WHEN accion3_b < accion3_a THEN 1
                        ELSE 0
                    END) * accion3_a AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro3_a IS NOT NULL AND accion3_a IS NOT NULL AND accion3_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro3_b AS equipo, sala, estado,  
                       CASE WHEN accion3_b = '-' OR accion3_a = '-' THEN 0 ELSE accion3_b END AS accion,
                    CASE WHEN accion3_b > accion3_a AND accion3_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion3_b = accion3_a AND accion3_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion3_b < accion3_a AND accion3_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion3_b = '-' OR accion3_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion3_a = '-' THEN 0
                        WHEN accion3_a > accion3_b THEN 3
                        WHEN accion3_a = accion3_b THEN 2
                        WHEN accion3_a < accion3_b THEN 1
                        ELSE 0
                    END) * accion3_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro3_b IS NOT NULL AND accion3_b IS NOT NULL AND accion3_a IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro4_a AS equipo, sala, estado,  
                       CASE WHEN accion4_a = '-' OR accion4_b = '-' THEN 0 ELSE accion4_a END AS accion,
                    CASE WHEN accion4_a > accion4_b AND accion4_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion4_a = accion4_b AND accion4_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion4_a < accion4_b AND accion4_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion4_a = '-' OR accion4_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion4_b = '-' THEN 0
                        WHEN accion4_b > accion4_a THEN 3
                        WHEN accion4_b = accion4_a THEN 2
                        WHEN accion4_b < accion4_a THEN 1
                        ELSE 0
                    END) * accion4_a AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro4_a IS NOT NULL AND accion4_a IS NOT NULL AND accion4_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro4_b AS equipo, sala, estado,  
                       CASE WHEN accion4_b = '-' OR accion4_a = '-' THEN 0 ELSE accion4_b END AS accion,
                    CASE WHEN accion4_b > accion4_a AND accion4_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion4_b = accion4_a AND accion4_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion4_b < accion4_a AND accion4_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion4_b = '-' OR accion4_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion4_a = '-' THEN 0
                        WHEN accion4_a > accion4_b THEN 3
                        WHEN accion4_a = accion4_b THEN 2
                        WHEN accion4_a < accion4_b THEN 1
                        ELSE 0
                    END) * accion4_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro4_b IS NOT NULL AND accion4_b IS NOT NULL AND accion4_a IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro5_a AS equipo, sala, estado,  
                        CASE WHEN accion5_a = '-' OR accion5_b = '-' THEN 0 ELSE accion5_a END AS accion,
                    CASE WHEN accion5_a > accion5_b AND accion5_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion5_a = accion5_b AND accion5_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion5_a < accion5_b AND accion5_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion5_a = '-' OR accion5_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion5_b = '-' THEN 0
                        WHEN accion5_b > accion5_a THEN 3
                        WHEN accion5_b = accion5_a THEN 2
                        WHEN accion5_b < accion5_a THEN 1
                        ELSE 0
                    END) * accion5_a AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro5_a IS NOT NULL AND accion5_a IS NOT NULL AND accion5_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro5_b AS equipo, sala, estado,  
                       CASE WHEN accion5_b = '-' OR accion5_a = '-' THEN 0 ELSE accion5_b END AS accion,
                    CASE WHEN accion5_b > accion5_a AND accion5_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion5_b = accion5_a AND accion5_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion5_b < accion5_a AND accion5_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion5_b = '-' OR accion5_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion5_a = '-' THEN 0
                        WHEN accion5_a > accion5_b THEN 3
                        WHEN accion5_a = accion5_b THEN 2
                        WHEN accion5_a < accion5_b THEN 1
                        ELSE 0
                    END) * accion5_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro5_b IS NOT NULL AND accion5_b IS NOT NULL AND accion5_a IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro6_a AS equipo, sala, estado,  
                       CASE WHEN accion6_a = '-' OR accion6_b = '-' THEN 0 ELSE accion6_a END AS accion,
                    CASE WHEN accion6_a > accion6_b AND accion6_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion6_a = accion6_b AND accion6_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion6_a < accion6_b AND accion6_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion6_a = '-' OR accion6_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion6_b = '-' THEN 0
                        WHEN accion6_b > accion6_a THEN 3
                        WHEN accion6_b = accion6_a THEN 2
                        WHEN accion6_b < accion6_a THEN 1
                        ELSE 0
                    END) * accion6_a AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro6_a IS NOT NULL AND accion6_a IS NOT NULL AND accion6_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro6_b AS equipo, sala, estado,  
                       CASE WHEN accion6_b = '-' OR accion6_a = '-' THEN 0 ELSE accion6_b END AS accion,
                    CASE WHEN accion6_b > accion6_a AND accion6_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion6_b = accion6_a AND accion6_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion6_b < accion6_a AND accion6_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion6_b = '-' OR accion6_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion6_a = '-' THEN 0
                        WHEN accion6_a > accion6_b THEN 3
                        WHEN accion6_a = accion6_b THEN 2
                        WHEN accion6_a < accion6_b THEN 1
                        ELSE 0
                    END) * accion6_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro6_b IS NOT NULL AND accion6_b IS NOT NULL AND accion6_a IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro7_a AS equipo, sala, estado,  
                       CASE WHEN accion7_a = '-' OR accion7_b = '-' THEN 0 ELSE accion7_a END AS accion,
                    CASE WHEN accion7_a > accion7_b AND accion7_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion7_a = accion7_b AND accion7_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion7_a < accion7_b AND accion7_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion7_a = '-' OR accion7_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion7_b = '-' THEN 0
                        WHEN accion7_b > accion7_a THEN 3
                        WHEN accion7_b = accion7_a THEN 2
                        WHEN accion7_b < accion7_a THEN 1
                        ELSE 0
                    END) * accion7_a AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro7_a IS NOT NULL AND accion7_a IS NOT NULL AND accion7_b IS NOT NULL
                
                UNION ALL
                
                SELECT encuentro7_b AS equipo, sala, estado,  
                       CASE WHEN accion7_b = '-' OR accion7_a = '-' THEN 0 ELSE accion7_b END AS accion,
                    CASE WHEN accion7_b > accion7_a AND accion7_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN accion7_b = accion7_a AND accion7_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN accion7_b < accion7_a AND accion7_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN accion7_b = '-' OR accion7_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN accion7_a = '-' THEN 0
                        WHEN accion7_a > accion7_b THEN 3
                        WHEN accion7_a = accion7_b THEN 2
                        WHEN accion7_a < accion7_b THEN 1
                        ELSE 0
                    END) * accion7_b AS sonnenborg_berger
                FROM competencias 
                WHERE encuentro7_b IS NOT NULL AND accion7_b IS NOT NULL AND accion7_a IS NOT NULL
            ) AS lista_victorias
            GROUP BY equipo, sala
            ORDER BY puntos DESC, olimpico DESC, sonnenborg_berger desc ";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }
        




























        public static function clasificacion2(){
            $sql = "    SELECT COALESCE(nomequipoa, 'sin nombre') AS nomequipoa,
    COALESCE(nomequipob, 'sin nombre') AS nomequipob, estado, sala, equipo,
                COUNT(*) AS veces_jugadas,
                SUM(victoria) AS victorias,
                SUM(empate) AS empates,
                SUM(derrota) AS derrotas,
                SUM(incomparecencia) AS incomparecencias,
                SUM(
                    CASE 
                        WHEN victoria = 1 THEN 3
                        WHEN empate = 1 THEN 2
                        WHEN derrota = 1 THEN 1
                        ELSE 0 
                    END
                ) AS puntos,
                SUM(accion) AS olimpico,
                SUM(sonnenborg_berger) AS sonnenborg_berger
            FROM (
                SELECT c.encuentro1_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion1_a = '-' OR c.accion1_b = '-' THEN 0 ELSE c.accion1_a END AS accion,
                    CASE WHEN c.accion1_a > c.accion1_b AND c.accion1_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion1_a = c.accion1_b AND c.accion1_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion1_a < c.accion1_b AND c.accion1_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion1_a = '-' OR c.accion1_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion1_b = '-' THEN 0
                        WHEN c.accion1_b > c.accion1_a THEN 3
                        WHEN c.accion1_b = c.accion1_a THEN 2
                        WHEN c.accion1_b < c.accion1_a THEN 1
                        ELSE 0
                    END) * c.accion1_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro1_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro1_b 
                WHERE c.encuentro1_a IS NOT NULL AND c.accion1_a IS NOT NULL AND c.accion1_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro1_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion1_b = '-' OR c.accion1_a = '-' THEN 0 ELSE c.accion1_b END AS accion,
                    CASE WHEN c.accion1_b > c.accion1_a AND c.accion1_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion1_b = c.accion1_a AND c.accion1_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion1_b < c.accion1_a AND c.accion1_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion1_b = '-' OR c.accion1_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion1_a = '-' THEN 0
                        WHEN c.accion1_a > c.accion1_b THEN 3
                        WHEN c.accion1_a = c.accion1_b THEN 2
                        WHEN c.accion1_a < c.accion1_b THEN 1
                        ELSE 0
                    END) * c.accion1_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro1_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro1_b 
                WHERE c.encuentro1_b IS NOT NULL AND c.accion1_b IS NOT NULL AND c.accion1_a IS NOT NULL
                
                UNION ALL

                SELECT c.encuentro2_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion2_a = '-' OR c.accion2_b = '-' THEN 0 ELSE c.accion2_a END AS accion,
                    CASE WHEN c.accion2_a > c.accion2_b AND c.accion2_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion2_a = c.accion2_b AND c.accion2_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion2_a < c.accion2_b AND c.accion2_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion2_a = '-' OR c.accion2_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion2_b = '-' THEN 0
                        WHEN c.accion2_b > c.accion2_a THEN 3
                        WHEN c.accion2_b = c.accion2_a THEN 2
                        WHEN c.accion2_b < c.accion2_a THEN 1
                        ELSE 0
                    END) * c.accion2_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro2_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro2_b 
                WHERE c.encuentro2_a IS NOT NULL AND c.accion2_a IS NOT NULL AND c.accion2_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro2_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion2_b = '-' OR c.accion2_a = '-' THEN 0 ELSE c.accion2_b END AS accion,
                    CASE WHEN c.accion2_b > c.accion2_a AND c.accion2_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion2_b = c.accion2_a AND c.accion2_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion2_b < c.accion2_a AND c.accion2_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion2_b = '-' OR c.accion2_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion2_a = '-' THEN 0
                        WHEN c.accion2_a > c.accion2_b THEN 3
                        WHEN c.accion2_a = c.accion2_b THEN 2
                        WHEN c.accion2_a < c.accion2_b THEN 1
                        ELSE 0
                    END) * c.accion2_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro2_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro2_b 
                WHERE c.encuentro2_b IS NOT NULL AND c.accion2_b IS NOT NULL AND c.accion2_a IS NOT NULL

                UNION ALL

                SELECT c.encuentro3_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion3_a = '-' OR c.accion3_b = '-' THEN 0 ELSE c.accion3_a END AS accion,
                    CASE WHEN c.accion3_a > c.accion3_b AND c.accion3_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion3_a = c.accion3_b AND c.accion3_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion3_a < c.accion3_b AND c.accion3_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion3_a = '-' OR c.accion3_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion3_b = '-' THEN 0
                        WHEN c.accion3_b > c.accion3_a THEN 3
                        WHEN c.accion3_b = c.accion3_a THEN 2
                        WHEN c.accion3_b < c.accion3_a THEN 1
                        ELSE 0
                    END) * c.accion3_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro3_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro3_b 
                WHERE c.encuentro3_a IS NOT NULL AND c.accion3_a IS NOT NULL AND c.accion3_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro3_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion3_b = '-' OR c.accion3_a = '-' THEN 0 ELSE c.accion3_b END AS accion,
                    CASE WHEN c.accion3_b > c.accion3_a AND c.accion3_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion3_b = c.accion3_a AND c.accion3_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion3_b < c.accion3_a AND c.accion3_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion3_b = '-' OR c.accion3_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion3_a = '-' THEN 0
                        WHEN c.accion3_a > c.accion3_b THEN 3
                        WHEN c.accion3_a = c.accion3_b THEN 2
                        WHEN c.accion3_a < c.accion3_b THEN 1
                        ELSE 0
                    END) * c.accion3_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro3_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro3_b 
                WHERE c.encuentro3_b IS NOT NULL AND c.accion3_b IS NOT NULL AND c.accion3_a IS NOT NULL

                UNION ALL

                SELECT c.encuentro4_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion4_a = '-' OR c.accion4_b = '-' THEN 0 ELSE c.accion4_a END AS accion,
                    CASE WHEN c.accion4_a > c.accion4_b AND c.accion4_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion4_a = c.accion4_b AND c.accion4_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion4_a < c.accion4_b AND c.accion4_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion4_a = '-' OR c.accion4_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion4_b = '-' THEN 0
                        WHEN c.accion4_b > c.accion4_a THEN 3
                        WHEN c.accion4_b = c.accion4_a THEN 2
                        WHEN c.accion4_b < c.accion4_a THEN 1
                        ELSE 0
                    END) * c.accion4_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro4_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro4_b 
                WHERE c.encuentro4_a IS NOT NULL AND c.accion4_a IS NOT NULL AND c.accion4_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro4_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion4_b = '-' OR c.accion4_a = '-' THEN 0 ELSE c.accion4_b END AS accion,
                    CASE WHEN c.accion4_b > c.accion4_a AND c.accion4_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion4_b = c.accion4_a AND c.accion4_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion4_b < c.accion4_a AND c.accion4_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion4_b = '-' OR c.accion4_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion4_a = '-' THEN 0
                        WHEN c.accion4_a > c.accion4_b THEN 3
                        WHEN c.accion4_a = c.accion4_b THEN 2
                        WHEN c.accion4_a < c.accion4_b THEN 1
                        ELSE 0
                    END) * c.accion4_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro4_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro4_b 
                WHERE c.encuentro4_b IS NOT NULL AND c.accion4_b IS NOT NULL AND c.accion4_a IS NOT NULL

                UNION ALL

                SELECT c.encuentro5_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion5_a = '-' OR c.accion5_b = '-' THEN 0 ELSE c.accion5_a END AS accion,
                    CASE WHEN c.accion5_a > c.accion5_b AND c.accion5_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion5_a = c.accion5_b AND c.accion5_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion5_a < c.accion5_b AND c.accion5_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion5_a = '-' OR c.accion5_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion5_b = '-' THEN 0
                        WHEN c.accion5_b > c.accion5_a THEN 3
                        WHEN c.accion5_b = c.accion5_a THEN 2
                        WHEN c.accion5_b < c.accion5_a THEN 1
                        ELSE 0
                    END) * c.accion5_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro5_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro5_b 
                WHERE c.encuentro5_a IS NOT NULL AND c.accion5_a IS NOT NULL AND c.accion5_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro5_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion5_b = '-' OR c.accion5_a = '-' THEN 0 ELSE c.accion5_b END AS accion,
                    CASE WHEN c.accion5_b > c.accion5_a AND c.accion5_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion5_b = c.accion5_a AND c.accion5_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion5_b < c.accion5_a AND c.accion5_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion5_b = '-' OR c.accion5_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion5_a = '-' THEN 0
                        WHEN c.accion5_a > c.accion5_b THEN 3
                        WHEN c.accion5_a = c.accion5_b THEN 2
                        WHEN c.accion5_a < c.accion5_b THEN 1
                        ELSE 0
                    END) * c.accion5_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro5_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro5_b 
                WHERE c.encuentro5_b IS NOT NULL AND c.accion5_b IS NOT NULL AND c.accion5_a IS NOT NULL

                UNION ALL

                SELECT c.encuentro6_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion6_a = '-' OR c.accion6_b = '-' THEN 0 ELSE c.accion6_a END AS accion,
                    CASE WHEN c.accion6_a > c.accion6_b AND c.accion6_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion6_a = c.accion6_b AND c.accion6_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion6_a < c.accion6_b AND c.accion6_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion6_a = '-' OR c.accion6_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion6_b = '-' THEN 0
                        WHEN c.accion6_b > c.accion6_a THEN 3
                        WHEN c.accion6_b = c.accion6_a THEN 2
                        WHEN c.accion6_b < c.accion6_a THEN 1
                        ELSE 0
                    END) * c.accion6_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro6_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro6_b 
                WHERE c.encuentro6_a IS NOT NULL AND c.accion6_a IS NOT NULL AND c.accion6_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro6_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion6_b = '-' OR c.accion6_a = '-' THEN 0 ELSE c.accion6_b END AS accion,
                    CASE WHEN c.accion6_b > c.accion6_a AND c.accion6_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion6_b = c.accion6_a AND c.accion6_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion6_b < c.accion6_a AND c.accion6_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion6_b = '-' OR c.accion6_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion6_a = '-' THEN 0
                        WHEN c.accion6_a > c.accion6_b THEN 3
                        WHEN c.accion6_a = c.accion6_b THEN 2
                        WHEN c.accion6_a < c.accion6_b THEN 1
                        ELSE 0
                    END) * c.accion6_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro6_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro6_b 
                WHERE c.encuentro6_b IS NOT NULL AND c.accion6_b IS NOT NULL AND c.accion6_a IS NOT NULL

                UNION ALL

                SELECT c.encuentro7_a AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion7_a = '-' OR c.accion7_b = '-' THEN 0 ELSE c.accion7_a END AS accion,
                    CASE WHEN c.accion7_a > c.accion7_b AND c.accion7_b != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion7_a = c.accion7_b AND c.accion7_a != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion7_a < c.accion7_b AND c.accion7_a != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion7_a = '-' OR c.accion7_b = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion7_b = '-' THEN 0
                        WHEN c.accion7_b > c.accion7_a THEN 3
                        WHEN c.accion7_b = c.accion7_a THEN 2
                        WHEN c.accion7_b < c.accion7_a THEN 1
                        ELSE 0
                    END) * c.accion7_a AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro7_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro7_b 
                WHERE c.encuentro7_a IS NOT NULL AND c.accion7_a IS NOT NULL AND c.accion7_b IS NOT NULL
                
                UNION ALL
                
                SELECT c.encuentro7_b AS equipo, c.sala, c.estado, e1.nombre as nomequipoa, e2.nombre as nomequipob,  
                       CASE WHEN c.accion7_b = '-' OR c.accion7_a = '-' THEN 0 ELSE c.accion7_b END AS accion,
                    CASE WHEN c.accion7_b > c.accion7_a AND c.accion7_a != '-' THEN 1 ELSE 0 END AS victoria,
                    CASE WHEN c.accion7_b = c.accion7_a AND c.accion7_b != '-' THEN 1 ELSE 0 END AS empate,
                    CASE WHEN c.accion7_b < c.accion7_a AND c.accion7_b != '-' THEN 1 ELSE 0 END AS derrota,
                    CASE WHEN c.accion7_b = '-' OR c.accion7_a = '-' THEN 1 ELSE 0 END AS incomparecencia,
                    (CASE 
                        WHEN c.accion7_a = '-' THEN 0
                        WHEN c.accion7_a > c.accion7_b THEN 3
                        WHEN c.accion7_a = c.accion7_b THEN 2
                        WHEN c.accion7_a < c.accion7_b THEN 1
                        ELSE 0
                    END) * c.accion7_b AS sonnenborg_berger
                FROM competencias c 
                LEFT JOIN equipo AS e1 ON e1.id = c.encuentro7_a 
                LEFT JOIN equipo AS e2 ON e2.id = c.encuentro7_b 
                WHERE c.encuentro7_b IS NOT NULL AND c.accion7_b IS NOT NULL AND c.accion7_a IS NOT NULL

                ) AS lista_victorias
            GROUP BY equipo, sala
            ORDER BY puntos DESC, olimpico DESC, sonnenborg_berger desc";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }
























        public static function clasificacion3(){
            $sql = "  SELECT 
    lista_victorias.nomequipo AS nomequipo, 
    lista_victorias.estado, 
    lista_victorias.sala, 
    lista_victorias.equipo,
    COUNT(*) AS veces_jugadas,
    SUM(lista_victorias.victoria) AS victorias,
    SUM(lista_victorias.empate) AS empates,
    SUM(lista_victorias.derrota) AS derrotas,
    SUM(lista_victorias.incomparecencia) AS incomparecencias,
    SUM(
        CASE 
            WHEN lista_victorias.victoria = 1 THEN 3
            WHEN lista_victorias.empate = 1 THEN 2
            WHEN lista_victorias.derrota = 1 THEN 1
            ELSE 0 
        END
    ) - COALESCE(sancion_total.sancion, 0) AS puntos, 
    COALESCE(sancion_total.sancion, 0) AS sancion_total,
    SUM(lista_victorias.accion) AS olimpico,
    -- SUM(lista_victorias.sonnenborg_berger) AS sonnenborg_berger,
    SUM(lista_victorias.puntos_rival) AS puntos_rival,
    ROUND(
    (
        (
            (SUM(lista_victorias.puntos_rival) * COUNT(*)) * 
            SUM(
                CASE 
                    WHEN lista_victorias.victoria = 1 THEN 3
                    WHEN lista_victorias.empate = 1 THEN 2
                    WHEN lista_victorias.derrota = 1 THEN 1
                    ELSE 0 
                END
            ) - COALESCE(sancion_total.sancion, 0)
        ) / COUNT(*)
    ) / 6,
    2
) AS sonnenborg_berger

FROM (
    -- Equipo 1 A
    SELECT 
        c.encuentro1_a AS equipo, c.sala, c.estado,  e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion1_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion1_b = '-') AND c.accion1_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion1_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion1_a = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion1_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion1_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion1_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro1_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro1_a AND s1.sala = c.sala -- Sanción equipo 1
    WHERE c.encuentro1_a IS NOT NULL AND c.accion1_a IS NOT NULL AND c.accion1_b IS NOT NULL

    UNION ALL

    -- Equipo 1 B
    SELECT 
        c.encuentro1_b AS equipo, c.sala, c.estado, e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion1_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion1_a = '-') AND c.accion1_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion1_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion1_b = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion1_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion1_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion1_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro1_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro1_b AND s2.sala = c.sala -- Sanción equipo 2
    WHERE c.encuentro1_b IS NOT NULL AND c.accion1_b IS NOT NULL AND c.accion1_a IS NOT NULL

    UNION ALL
    -- Equipo 2 A
    SELECT 
        c.encuentro2_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion2_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion2_b = '-') AND c.accion2_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion2_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion2_a = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion2_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion2_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion2_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro2_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro2_a AND s1.sala = c.sala 
    WHERE c.encuentro2_a IS NOT NULL AND c.accion2_a IS NOT NULL AND c.accion2_b IS NOT NULL

    UNION ALL

     -- Equipo 2 B
    SELECT 
        c.encuentro2_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion2_b = '-'  THEN 0 
            ELSE CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion2_a = '-' ) AND c.accion2_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion2_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion2_b = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion2_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion2_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion2_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro2_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro2_b AND s2.sala = c.sala 
    WHERE c.encuentro2_b IS NOT NULL AND c.accion2_b IS NOT NULL AND c.accion2_a IS NOT NULL

    UNION ALL
-- Equipo 3 A
    SELECT 
        c.encuentro3_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion3_a = '-'  THEN 0 
            ELSE CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion3_b = '-' ) AND c.accion3_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion3_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion3_a = '-' THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion3_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion3_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion3_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro3_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro3_a AND s1.sala = c.sala 
    WHERE c.encuentro3_a IS NOT NULL AND c.accion3_a IS NOT NULL AND c.accion3_b IS NOT NULL

    UNION ALL

    -- Equipo 3 B
    SELECT 
        c.encuentro3_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion3_b = '-'  THEN 0 
            ELSE CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion3_a = '-') AND c.accion3_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion3_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion3_b = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion3_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion3_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion3_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro3_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro3_b AND s2.sala = c.sala 
    WHERE c.encuentro3_b IS NOT NULL AND c.accion3_b IS NOT NULL AND c.accion3_a IS NOT NULL

    UNION ALL

-- Equipo 4 A
    SELECT 
        c.encuentro4_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion4_a = '-'  THEN 0 
            ELSE CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion4_b = '-') AND c.accion4_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion4_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion4_a = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion4_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion4_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion4_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro4_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro4_a AND s1.sala = c.sala 
    WHERE c.encuentro4_a IS NOT NULL AND c.accion4_a IS NOT NULL AND c.accion4_b IS NOT NULL

    UNION ALL

    -- Equipo 4 B
    SELECT 
        c.encuentro4_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion4_b = '-'  THEN 0 
            ELSE CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion4_a = '-' ) AND c.accion4_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion4_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion4_b = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion4_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion4_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion4_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro4_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro4_b AND s2.sala = c.sala 
    WHERE c.encuentro4_b IS NOT NULL AND c.accion4_b IS NOT NULL AND c.accion4_a IS NOT NULL

    UNION ALL

-- Equipo 5 A
    SELECT 
        c.encuentro5_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion5_a = '-'   THEN 0 
            ELSE CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion5_b = '-' ) AND c.accion5_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion5_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion5_a = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion5_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion5_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion5_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro5_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro5_a AND s1.sala = c.sala 
    WHERE c.encuentro5_a IS NOT NULL AND c.accion5_a IS NOT NULL AND c.accion5_b IS NOT NULL

    UNION ALL

    -- Equipo 5 B
    SELECT 
        c.encuentro5_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion5_b = '-'  THEN 0 
            ELSE CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion5_a = '-' ) AND c.accion5_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion5_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion5_b = '-'  THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion5_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion5_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion5_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro5_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro5_b AND s2.sala = c.sala 
    WHERE c.encuentro5_b IS NOT NULL AND c.accion5_b IS NOT NULL AND c.accion5_a IS NOT NULL

    UNION ALL

-- Equipo 6 A
    SELECT 
        c.encuentro6_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion6_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion6_b = '-' ) AND c.accion6_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion6_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion6_a = '-' THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion6_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion6_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion6_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro6_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro6_a AND s1.sala = c.sala 
   WHERE c.encuentro6_a IS NOT NULL AND c.accion6_a IS NOT NULL AND c.accion6_b IS NOT NULL

    UNION ALL

    -- Equipo 6 B
    SELECT 
        c.encuentro6_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion6_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion6_a = '-' ) AND c.accion6_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion6_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion6_b = '-' THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion6_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion6_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion6_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro6_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro6_b AND s2.sala = c.sala 
    WHERE c.encuentro6_b IS NOT NULL AND c.accion6_b IS NOT NULL AND c.accion6_a IS NOT NULL
    UNION ALL

-- Equipo 7 A
    SELECT 
        c.encuentro7_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion7_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion7_b = '-' ) AND c.accion7_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion7_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion7_a = '-' THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s1.sancion AS sancion, -- Sanción del equipo 1
        (
            CASE 
                WHEN c.accion7_b = '-' THEN 0
                ELSE CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion7_a, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion7_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro7_a 
    -- LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro7_a AND s1.sala = c.sala 
    WHERE c.encuentro7_a IS NOT NULL AND c.accion7_a IS NOT NULL AND c.accion7_b IS NOT NULL

    UNION ALL

    -- Equipo 7 B
    SELECT 
        c.encuentro7_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion7_b = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion7_a = '-' ) AND c.accion7_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion7_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion7_b = '-' THEN 1 
            ELSE 0 
        END AS incomparecencia,
        -- s2.sancion AS sancion, -- Sanción del equipo 2
        (
            CASE 
                WHEN c.accion1_a = '-' THEN 0
                ELSE CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
            END
        ) * COALESCE(NULLIF(c.accion1_b, '-'), '0') AS sonnenborg_berger,
        CASE 
            WHEN c.accion7_a = '-' THEN 0 
            ELSE CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) 
        END AS puntos_rival
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro7_b 
    -- LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro7_b AND s2.sala = c.sala 
    WHERE c.encuentro7_b IS NOT NULL AND c.accion7_b IS NOT NULL AND c.accion7_a IS NOT NULL

                ) AS lista_victorias
LEFT JOIN sancion sancion_total 
    ON lista_victorias.equipo = sancion_total.equipo 
    AND lista_victorias.sala = sancion_total.sala

            GROUP BY equipo, sala
            ORDER BY sala ASC, puntos DESC, olimpico DESC, sonnenborg_berger desc";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }






















public static function clasificacion4(){
            $sql = "  SELECT 
    lista_victorias.nomequipo AS nomequipo, 
    lista_victorias.estado, 
    lista_victorias.sala, 
    lista_victorias.equipo,
    COUNT(*) AS veces_jugadas,
    SUM(lista_victorias.victoria) AS victorias,
    SUM(lista_victorias.empate) AS empates,
    SUM(lista_victorias.derrota) AS derrotas,
    SUM(lista_victorias.incomparecencia) AS incomparecencias,
    SUM(
        CASE 
            WHEN lista_victorias.victoria = 1 THEN 3
            WHEN lista_victorias.empate = 1 THEN 2
            WHEN lista_victorias.derrota = 1 THEN 1
            ELSE 0 
        END
    ) - COALESCE(SUM(lista_victorias.sancion), 0) AS puntos, 
    COALESCE(SUM(lista_victorias.sancion), 0) AS sancion_equipo, -- Sanción para este equipo
    SUM(lista_victorias.accion) AS olimpico,
    SUM(lista_victorias.sonnenborg_berger) AS sonnenborg_berger
FROM (
    -- Equipo 1 A
    SELECT 
        c.encuentro1_a AS equipo, c.sala, c.estado,  e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion1_a = '-' OR c.accion1_b = '-' OR c.accion1_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion1_b = '-' OR c.accion1_b IS NULL) AND c.accion1_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion1_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion1_a = '-' OR c.accion1_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion1_b = '-' OR c.accion1_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro1_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro1_a AND s1.sala = c.sala -- Sanción equipo 1
    WHERE c.encuentro1_a IS NOT NULL

    UNION ALL

    -- Equipo 1 B
    SELECT 
        c.encuentro1_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion1_b = '-' OR c.accion1_a = '-' OR c.accion1_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion1_a = '-' OR c.accion1_a IS NULL) AND c.accion1_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion1_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion1_b = '-' OR c.accion1_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion1_a = '-' OR c.accion1_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion1_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion1_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro1_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro1_b AND s2.sala = c.sala -- Sanción equipo 2
    WHERE c.encuentro1_b IS NOT NULL

    UNION ALL
    -- Equipo 2 A
    SELECT 
        c.encuentro2_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion2_a = '-' OR c.accion2_b = '-' OR c.accion2_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion2_b = '-' OR c.accion2_b IS NULL) AND c.accion2_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion2_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion2_a = '-' OR c.accion2_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion2_b = '-' OR c.accion2_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro2_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro2_a AND s1.sala = c.sala 
    WHERE c.encuentro2_a IS NOT NULL

    UNION ALL

     -- Equipo 2 B
    SELECT 
        c.encuentro2_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion2_b = '-' OR c.accion2_a = '-' OR c.accion2_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion2_a = '-' OR c.accion2_a IS NULL) AND c.accion2_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion2_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion2_b = '-' OR c.accion2_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion2_a = '-' OR c.accion2_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion2_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion2_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro2_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro2_b AND s2.sala = c.sala 
    WHERE c.encuentro2_b IS NOT NULL

    UNION ALL
-- Equipo 3 A
    SELECT 
        c.encuentro3_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion3_a = '-' OR c.accion3_b = '-' OR c.accion3_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion3_b = '-' OR c.accion3_b IS NULL) AND c.accion3_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion3_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion3_a = '-' OR c.accion3_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion3_b = '-' OR c.accion3_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro3_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro3_a AND s1.sala = c.sala -- Sanción equipo 1
    WHERE c.encuentro3_a IS NOT NULL

    UNION ALL

    -- Equipo 3 B
    SELECT 
        c.encuentro3_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion3_b = '-' OR c.accion3_a = '-' OR c.accion3_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion3_a = '-' OR c.accion3_a IS NULL) AND c.accion3_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion3_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion3_b = '-' OR c.accion3_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion3_a = '-' OR c.accion3_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion3_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion3_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro3_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro3_b AND s2.sala = c.sala 
    WHERE c.encuentro3_b IS NOT NULL

    UNION ALL

-- Equipo 4 A
    SELECT 
        c.encuentro4_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion4_a = '-' OR c.accion4_b = '-' OR c.accion4_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion4_b = '-' OR c.accion4_b IS NULL) AND c.accion4_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion4_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion4_a = '-' OR c.accion4_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion4_b = '-' OR c.accion4_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro4_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro4_a AND s1.sala = c.sala 
    WHERE c.encuentro4_a IS NOT NULL

    UNION ALL

    -- Equipo 4 B
    SELECT 
        c.encuentro4_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion4_b = '-' OR c.accion4_a = '-' OR c.accion4_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion4_a = '-' OR c.accion4_a IS NULL) AND c.accion4_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion4_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion4_b = '-' OR c.accion4_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion4_a = '-' OR c.accion4_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion4_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion4_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro4_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro4_b AND s2.sala = c.sala 
    WHERE c.encuentro4_b IS NOT NULL

    UNION ALL

-- Equipo 5 A
    SELECT 
        c.encuentro5_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion5_a = '-' OR c.accion5_b = '-' OR c.accion5_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion5_b = '-' OR c.accion5_b IS NULL) AND c.accion5_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion5_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion5_a = '-' OR c.accion5_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion5_b = '-' OR c.accion5_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro5_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro5_a AND s1.sala = c.sala 
    WHERE c.encuentro5_a IS NOT NULL

    UNION ALL

    -- Equipo 5 B
    SELECT 
        c.encuentro5_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion5_b = '-' OR c.accion5_a = '-' OR c.accion5_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion5_a = '-' OR c.accion5_a IS NULL) AND c.accion5_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion5_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion5_b = '-' OR c.accion5_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion5_a = '-' OR c.accion5_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion5_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion5_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro5_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro5_b AND s2.sala = c.sala 
    WHERE c.encuentro5_b IS NOT NULL

    UNION ALL

-- Equipo 6 A
    SELECT 
        c.encuentro6_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion6_a = '-' OR c.accion6_b = '-' OR c.accion6_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion6_b = '-' OR c.accion6_b IS NULL) AND c.accion6_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion6_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion6_a = '-' OR c.accion6_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion6_b = '-' OR c.accion6_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro6_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro6_a AND s1.sala = c.sala 
    WHERE c.encuentro6_a IS NOT NULL

    UNION ALL

    -- Equipo 6 B
    SELECT 
        c.encuentro6_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion6_b = '-' OR c.accion6_a = '-' OR c.accion6_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion6_a = '-' OR c.accion6_a IS NULL) AND c.accion6_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion6_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion6_b = '-' OR c.accion6_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion6_a = '-' OR c.accion6_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion6_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion6_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro6_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro6_b AND s2.sala = c.sala 
    WHERE c.encuentro6_b IS NOT NULL

    UNION ALL

-- Equipo 7 A
    SELECT 
        c.encuentro7_a AS equipo, 
        c.sala, 
        c.estado, 
        e1.nombre AS nomequipo, 
        CASE 
            WHEN c.accion7_a = '-' OR c.accion7_b = '-' OR c.accion7_a IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion7_b = '-' OR c.accion7_b IS NULL) AND c.accion7_a != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion7_b != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion7_a = '-' OR c.accion7_a IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s1.sancion AS sancion, -- Sanción del equipo 1
        (CASE 
            WHEN c.accion7_b = '-' OR c.accion7_b IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e1 ON e1.id = c.encuentro7_a 
    LEFT JOIN sancion AS s1 ON s1.equipo = c.encuentro7_a AND s1.sala = c.sala 
    WHERE c.encuentro7_a IS NOT NULL

    UNION ALL

    -- Equipo 7 B
    SELECT 
        c.encuentro7_b AS equipo, 
        c.sala, 
        c.estado, 
        e2.nombre AS nomequipo, 
        CASE 
            WHEN c.accion7_b = '-' OR c.accion7_a = '-' OR c.accion7_b IS NULL THEN 0 
            ELSE CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) 
        END AS accion,
        CASE 
            WHEN (c.accion7_a = '-' OR c.accion7_a IS NULL) AND c.accion7_b != '-' THEN 1 
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS victoria,
        CASE 
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) 
            AND c.accion7_a != '-' THEN 1 
            ELSE 0 
        END AS empate,
        CASE 
            WHEN CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) THEN 1 
            ELSE 0 
        END AS derrota,
        CASE 
            WHEN c.accion7_b = '-' OR c.accion7_b IS NULL THEN 1 
            ELSE 0 
        END AS incomparecencia,
        s2.sancion AS sancion, -- Sanción del equipo 2
        (CASE 
            WHEN c.accion7_a = '-' OR c.accion7_a IS NULL THEN 0
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) > CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 3
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) = CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 2
            WHEN CAST(REPLACE(c.accion7_a, ',', '.') AS DECIMAL(10,2)) < CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) THEN 1
            ELSE 0
        END) * CAST(REPLACE(c.accion7_b, ',', '.') AS DECIMAL(10,2)) AS sonnenborg_berger
    FROM competencias c 
    LEFT JOIN equipo AS e2 ON e2.id = c.encuentro7_b 
    LEFT JOIN sancion AS s2 ON s2.equipo = c.encuentro7_b AND s2.sala = c.sala 
    WHERE c.encuentro7_b IS NOT NULL

                ) AS lista_victorias
            GROUP BY equipo, sala
            ORDER BY sala DESC, puntos DESC, olimpico DESC, sonnenborg_berger desc";
            $query = Executor::doit($sql);
            return Model::many($query[0],new SalaData());
        }














        public static function vercontenidos3_3($fecha){
            $sql = "SELECT *
                        FROM (
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre AS tipocompeticiones1,
                                s.competicion AS competicion,
                                s.codigo AS sala_codigo,
                                c.encuentro1_a AS equipo_a,
                                c.estado1_a AS estado_a,
                                c.accion1_a AS resultado_a,
                                c.encuentro1_b AS equipo_b,
                                c.estado1_b AS estado_b,
                                c.accion1_b AS resultado_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre as nombrequipo_a,
                                e1.nombre as nombrequipo_b,
                                c.aprobacion1 as aprobacion,
                                c.firma1_a as firma_a,
                                c.observacion1_b as observacion_b,
                                c.firma1_b as firma_b,
                                u.ci as usuario,
                                s.id,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro1_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro1_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario1

                            WHERE 
                                c.encuentro1_a IS NOT NULL AND c.encuentro1_b IS NOT NULL AND c.encuentro1_a <> '' AND  c.encuentro1_b <> '' AND  
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro2_a,
                                c.estado2_a,
                                c.accion2_a,
                                c.encuentro2_b,
                                c.estado2_b,
                                c.accion2_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion2,
                                c.firma2_a,
                                c.observacion2_b,
                                c.firma2_b,
                                u.ci,
                                s.id,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro2_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro2_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario2
                            WHERE 
                                c.encuentro2_a IS NOT NULL AND c.encuentro2_b IS NOT NULL AND c.encuentro2_a <> '' AND c.encuentro2_b <> '' AND 
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro3_a,
                                c.estado3_a,
                                c.accion3_a,
                                c.encuentro3_b,
                                c.estado3_b,
                                c.accion3_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion3,
                                c.firma3_a,
                                c.observacion3_b,
                                c.firma3_b,
                                u.ci,
                                s.id ,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro3_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro3_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario3
                            WHERE 
                                c.encuentro3_a IS NOT NULL AND c.encuentro3_b IS NOT NULL AND c.encuentro3_a <> '' AND c.encuentro3_b <> '' AND 
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro4_a,
                                c.estado4_a,
                                c.accion4_a,
                                c.encuentro4_b,
                                c.estado4_b,
                                c.accion4_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion4,
                                c.firma4_a,
                                c.observacion4_b,
                                c.firma4_b,
                                u.ci,
                                s.id,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro4_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro4_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario4
                            WHERE 
                                c.encuentro4_a IS NOT NULL AND c.encuentro4_b IS NOT NULL AND c.encuentro4_a <> '' AND c.encuentro4_b <> '' AND 
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro5_a,
                                c.estado5_a,
                                c.accion5_a,
                                c.encuentro5_b,
                                c.estado5_b,
                                c.accion5_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion5,
                                c.firma5_a,
                                c.observacion5_b,
                                c.firma5_b,
                                u.ci,
                                s.id,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro5_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro5_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario5
                            WHERE 
                                c.encuentro5_a IS NOT NULL AND c.encuentro5_b IS NOT NULL AND c.encuentro5_a <> '' AND c.encuentro5_b <> '' AND 
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro6_a,
                                c.estado6_a,
                                c.accion6_a,
                                c.encuentro6_b,
                                c.estado6_b,
                                c.accion6_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion6,
                                c.firma6_a,
                                c.observacion6_b,
                                c.firma6_b,
                                u.ci,
                                s.id,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro6_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro6_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario6
                            WHERE 
                                c.encuentro6_a IS NOT NULL AND c.encuentro6_b IS NOT NULL AND c.encuentro6_a <> '' AND c.encuentro6_b <> '' AND 
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                            
                            UNION ALL
                            
                            SELECT 
                                c.id AS competencia_id,
                                t.nombre,
                                s.competicion,
                                s.codigo,
                                c.encuentro7_a,
                                c.estado7_a,
                                c.accion7_a,
                                c.encuentro7_b,
                                c.estado7_b,
                                c.accion7_b,
                                c.fecha_encuentro,
                                c2.nombregrupo,
                                e.nombre,
                                e1.nombre,
                                c.aprobacion7,
                                c.firma7_a,
                                c.observacion7_b,
                                c.firma7_b,
                                u.ci,
                                s.id,
                                '2' AS adicional
                            FROM 
                                sala s
                            JOIN 
                                competencias c ON s.id = c.sala
                            JOIN 
                                competicion c2 ON c2.id = s.competicion
                            JOIN 
                                tipocompeticiones t ON t.id = c2.tipocompeticion
                            JOIN 
                                equipo e ON e.id = c.encuentro7_a
                            JOIN 
                                equipo e1 ON e1.id = c.encuentro7_b
                            LEFT JOIN 
                                usuario u ON u.id = c.usuario7
                            WHERE 
                                c.encuentro7_a IS NOT NULL AND c.encuentro7_b IS NOT NULL AND c.encuentro7_a <> '' AND c.encuentro7_b <> '' AND 
                                c.estado = 1 AND  DATE(c.fecha_encuentro) = '$fecha'
                        ) AS subquery
                        ORDER BY 
                            tipocompeticiones1, fecha_encuentro, competicion, sala_codigo";
                        
            $query = Executor::doit($sql);
            return Model::many($query[0], new SalaData());
        }
    }
?>