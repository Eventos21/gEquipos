create database chessmaster;
	use chessmaster;
	set sql_mode='';

	create table cargo(
		id int primary key auto_increment not null,
		sucursal int,
		duplicidad text,
		nombre varchar(500));
	insert into cargo (nombre,duplicidad) values 
		("Federacion","Federacion"),
		("Club","Club"),
		("Arbitro","Arbitro"),
		("Capitan","Capitan"),
		("Jugador","Jugador");
	create table tipocompeticiones(
		id int primary key auto_increment not null,
		duplicidad text,
		nombre varchar(500));
	insert into tipocompeticiones (nombre,duplicidad) values 
		("Round Robin","Round Robin"),
		("Suizo ","Suizo ");
	create table club(
		id int primary key not null auto_increment,
		nombre text,
		telefono varchar(200),
		correo varchar(200),
		direccion text,
		responsable int,
		estado boolean default 0,
		codigo text,
		cantidadequipo int,
		usuario int,
		fecha datetime);

	create table equipo(
		id int primary key not null auto_increment,
		club int,
		liga int,
		nombre text,
		capitan varchar(255),
		nacimiento1 date,
		subcapitan varchar(255),
		nacimiento2 date,
		descripcion text,
		mensajefederacion text,
		duplicidad text,
		usuario int,
		estado boolean default 0,
		condicion boolean default 0,
		competicion int default null,
		fecha datetime);

	create table temporada(
		id int primary key not null auto_increment,
		nombre text,
		inicio date,
		limite date,
		fin date,
		usuario int,
		estado boolean default 0,
		archivado int default 0,
		archivado1 int default 0,
		fecha datetime,
		duplicidad text,
		actualizacion datetime);

	create table liga(
		id int primary key not null auto_increment,
		codigo varchar(20), /* nuevo*/
		temporada int,
		nombre text,
		fechainicio datetime,
		fechafinal datetime,
		fechafinalmodificacion datetime,
		responsable int,
		minimo float,
		maximo float,
		categoria text,
		grupo text,
		edad text,
		orden text,
		estado boolean default 0,
		usuario int,
		fecha datetime,
		foreign key (temporada) references temporada(id));

	create table jugador(
		id int primary key not null auto_increment,
		equipo int,
		apellido1 text,
		apellido2 text,
		nombre text,
		nacimiento date,
		numlicencia varchar(100),
		club varchar(100),
		codigofide varchar(100),
		elo varchar(100),
		telefono varchar(50),
		duplicidad text,
		usuario int,
		users text,
		password text,
		estado boolean default 0,
		cargo int default 5,
		imagen text,
		fecha datetime);
	create table jugador_elo(
		id int primary key auto_increment not null,
		jugador int,
		club int,
		temporada int,
		liga int,
		elo varchar(100),
		duplicidad varchar(250),
		foreign key (club) references club(id),
		foreign key (liga) references liga(id),
		foreign key (temporada) references temporada(id));

	create table equipo_jugador(
		id int primary key not null auto_increment,
		jugador int,
		equipo int,
		estado boolean default 0,
		duplicidad text,
		orden varchar(200),
		nuevo int default 0,
		elo varchar(250),
		fecha datetime);

	create table usuario(
		id int primary key auto_increment not null,
		nombre varchar(200),
		apellido varchar(255),
		ci varchar(20),
		telefono varchar(15),
		fecha_nacimiento date,
		imagen text,
		sexo varchar(20),
		email varchar(255),
		usuario varchar(255),
		password varchar(255),
		fecha datetime,
		fecha_modificacion datetime,
		estado boolean default 0,
		cargo int,
		club int,
		token text,
		foreign key (cargo) references cargo(id));
	insert into usuario(nombre,apellido,usuario,password,estado,cargo) value("admin","admin","admin","$2y$10$8asrZfSaluo8qKPoMaGdcuEeDucF9ue21hcD820LPLW36q/6gtYMm","1","1");
	
	create table liga_club(
		id int primary key auto_increment not null,
		liga int,
		club int,
		cantidad int,
		foreign key (liga) references liga(id),
		foreign key (club) references club(id));

	create table padre_competicion(
		id int primary key auto_increment not null,
		tipoascenso varchar(200),
		liga int,
		cantidad int,
		fecha datetime,
		foreign key (liga) references liga(id));

	create table competicion(
		id int primary key auto_increment not null,
		padre_competicion int,
		tipocompeticion int,
		nombregrupo varchar(200),
		tipoascenso varchar(200),
		rondas varchar(200),
		jornadas varchar(200),
		cantidajugadores varchar(200),
		grupo varchar(200),
		foreign key (tipocompeticion) references tipocompeticiones(id),
		foreign key (padre_competicion) references padre_competicion(id));

	create table sala(
		id int primary key auto_increment not null,
		codigo int,
		liga int,
		competicion int,
		personalizada boolean default 0,
		foreign key (liga) references liga(id),
		foreign key (competicion) references competicion(id)
		);
	create table sala_personalizada(
		id int primary key auto_increment not null,
		sala int,
		ronda int,
		encuentro int,
		equipo_competidor int,
		id_competidor int,
		equipo_rival int,
		id_rival int,
		fecha date,

		puntajea varchar(250),
		observaciona text,
		firmaa text,
		archivoa text,
		puntajeb varchar(250),
		observacionb text,
		firmab text,
		archivob text,
		usuario int,
		arbitro int,
		observacion_arbitro text,
		firma_arbitro text,
		obervacion_fma text,
		aprobacion varchar(100) default "N",
		foreign key (sala) references sala(id)
		);
	create table valor_equipo(
		id int primary key auto_increment not null,
		sala int,
		liga int,
		competicion int,
		equipo int,
		valor int,
		foreign key (sala) references sala(id),
		foreign key (liga) references liga(id),
		foreign key (competicion) references competicion(id),
		foreign key (equipo) references equipo(id));
	create table competencias(
		id int primary key auto_increment not null,
		encuentro1_a int,
		estado1_a int default 1,
		accion1_a varchar(200),
		observacion1_a text,
		firma1_a text,
		archivo1_a text,

		encuentro1_b int,
		estado1_b int default 1,
		accion1_b varchar(200),
		observacion1_b text,
		firma1_b text,
		archivo1_b text,
usuario1 int,
arbitro1 int,
observacion_arbitro1 text,
firma_arbitro1 text,
obervacion_fma1 text,
aprobacion1 varchar(100) default "N",

		encuentro2_a int,
		estado2_a int default 1,
		accion2_a varchar(200),
		observacion2_a text,
		firma2_a text,
		archivo2_a text,

		encuentro2_b int,
		estado2_b int default 1,
		accion2_b varchar(200),
		observacion2_b text,
		firma2_b text,
		archivo2_b text,
usuario2 int,
arbitro2 int,
observacion_arbitro2 text,
firma_arbitro2 text,
obervacion_fma2 text,
aprobacion2 varchar(100) default "N",

		encuentro3_a int,
		estado3_a int default 1,
		accion3_a varchar(200),
		observacion3_a text,
		firma3_a text,
		archivo3_a text,

		encuentro3_b int,
		estado3_b int default 1,
		accion3_b int default 0,
		observacion3_b text,
		firma3_b text,
		archivo3_b text,
usuario3 int,
arbitro3 int,
observacion_arbitro3 text,
firma_arbitro3 text,
obervacion_fma3 text,
aprobacion3 varchar(100) default "N",

		encuentro4_a int,
		estado4_a int default 1,
		accion4_a varchar(200),
		observacion4_a text,
		firma4_a text,
		archivo4_a text,

		encuentro4_b int,
		estado4_b int default 1,
		accion4_b varchar(200),
		observacion4_b text,
		firma4_b text,
		archivo4_b text,
usuario4 int,
arbitro4 int,
observacion_arbitro4 text,
firma_arbitro4 text,
obervacion_fma4 text,
aprobacion4 varchar(100) default "N",

		encuentro5_a int,
		estado5_a int default 1,
		accion5_a varchar(200),
		observacion5_a text,
		firma5_a text,
		archivo5_a text,

		encuentro5_b int,
		estado5_b int default 1,
		accion5_b varchar(200),
		observacion5_b text,
		firma5_b text,
		archivo5_b text,
usuario5 int,
arbitro5 int,
observacion_arbitro5 text,
firma_arbitro5 text,
obervacion_fma5 text,
aprobacion5 varchar(100) default "N",

		encuentro6_a int,
		estado6_a int default 1,
		accion6_a varchar(200),
		observacion6_a text,
		firma6_a text,
		archivo6_a text,

		encuentro6_b int,
		estado6_b int default 1,
		accion6_b varchar(200),
		observacion6_b text,
		firma6_b text,
		archivo6_b text,
usuario6 int,
arbitro6 int,
observacion_arbitro6 text,
firma_arbitro6 text,
obervacion_fma6 text,
aprobacion6 varchar(100) default "N",

		encuentro7_a int,
		estado7_a int default 1,
		accion7_a varchar(200),
		observacion7_a text,
		firma7_a text,
		archivo7_a text,

		encuentro7_b int,
		estado7_b int default 1,
		accion7_b varchar(200),
		observacion7_b text,
		firma7_b text,
		archivo7_b text,
usuario7 int,
arbitro7 int,
observacion_arbitro7 text,
firma_arbitro7 text,
obervacion_fma7 text,
aprobacion7 varchar(100) default "N",
		sala int,
		fecha_encuentro date,
		estado int default 1
		);
	create table acta(
		id int primary key auto_increment not null,
		competencias int,
		equipo int,
		jugador int,
		resultado varchar(200),
		sala_personalizada int,
		foreign key (sala_personalizada) references sala_personalizada(id),
		foreign key (competencias) references competencias(id),
		foreign key (equipo) references equipo(id),
		foreign key (jugador) references jugador(id)
		);
	create table sancion(
		id int primary key auto_increment not null,
		sala int,
		equipo int,
		sancion float,
		foreign key (sala) references sala(id),
		foreign key (equipo) references equipo(id)
		);
	create table valor(
		id int primary key auto_increment not null,
		sala int,
		equipo int,
		valor varchar(250),
		foreign key (sala) references sala(id),
		foreign key (equipo) references equipo(id)
		);
	create table resultado(
		id int primary key auto_increment not null,
		fecha date,
		tipo varchar(250)
		);
	create table detalleresultado(
		id int primary key auto_increment not null,
		resultado int,
		numero varchar(255),
		equipo varchar(255),
		puntos varchar(255),
		progresivo text,
		buchholz_1 varchar(255),
		buchholz varchar(255),
		mediano_buchholz varchar(255),
		olimpico varchar(255),
		foreign key (resultado) references resultado(id)
		);