/* Comentarios */
/* Esta es una version Inicial de la base de datos, Utilicela para resestablecer los parametros iniciales de la aplicacion cuando sea necesario */

CREATE DATABASE rehabdb CHARACTER SET utf8;

USE rehabdb;

/* Pacientes */

CREATE TABLE pacientes (
	id_paciente INT NOT NULL AUTO_INCREMENT,
	ci_paciente VARCHAR (12) NOT NULL,
	nombre_paciente VARCHAR (15) NOT NULL,
	apellido_paciente VARCHAR (15) NOT NULL,
	edad_paciente VARCHAR (3) NOT NULL,
	telefono_paciente VARCHAR (15) NOT NULL,
	email_paciente VARCHAR (50),
	id_estatus INT NOT NULL,
	PRIMARY KEY (id_paciente)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE estatus_pacientes(
	id_estatus_paciente INT NOT NULL AUTO_INCREMENT,
	letra_estatus_paciente VARCHAR (2) NOT NULL,
	nombre_estatus_paciente VARCHAR (20) NOT NUll, 
	desc_estatus_paciente TEXT,
	PRIMARY KEY (id_estatus_paciente)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE ingresos_pacientes(
	id_ingreso_paciente INT NOT NULL AUTO_INCREMENT,
	hora_ingreso_paciente DATETIME,
	tipo_ingreso_paciente CHAR (1) NOT NULL,
	ci_paciente VARCHAR (12) NOT NULL,
	PRIMARY KEY (id_ingreso_paciente)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

/* historial medico del paciente */
CREATE TABLE historiales_medicos (
	id_historial_medico INT NOT NULL AUTO_INCREMENT,
	fecha_creacion_historial_medico DATETIME NOT NULL,
	id_paciente INT NOT NULL,
	PRIMARY KEY (id_historial_medico)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE consultas (
	id_consulta INT NOT NULL AUTO_INCREMENT,
	fecha_consulta DATETIME NOT NULL,
	desc_informe_medico TEXT,
	desc_examen_fisico TEXT,
	desc_diagnostico TEXT,
	id_tipo_consulta INT NOT NULL,
	id_historial_medico INT NOT NULL,
	PRIMARY KEY (id_consulta)
)ENGINE=MyISAM DEFAULT CHARSET = utf8; 

CREATE TABLE tipos_consultas(
	id_tipo_consulta INT NOT NULL AUTO_INCREMENT,
	nombre_tipo_consulta VARCHAR (20) NOT NULL,
	desc_tipo_consulta TEXT,
	PRIMARY KEY (id_tipo_consulta)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE pagos (
	id_pago INT NOT NULL AUTO_INCREMENT,
	fecha_pago DATETIME NOT NULL,
	id_tipo_pago INT NOT NULL,
	entidad_pago VARCHAR (20) NOT NULL,
	desc_pago TEXT,
	id_historial_medico INT NOT NULL,
	PRIMARY KEY (id_pago)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE tipos_pagos(
	id_tipo_pago INT NOT NULL AUTO_INCREMENT,
	nombre_tipo_pago VARCHAR (20) NOT NULL,
	desc_tipo_pago TEXT,
	PRIMARY KEY (id_tipo_pago)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

/* Indicaciones del historial medico */
CREATE TABLE indicaciones (
	id_indicacion INT NOT NULL AUTO_INCREMENT,
	fecha_consulta_control DATE NOT NULL,
	id_consulta INT NOT NULL,
	PRIMARY KEY (id_indicacion)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

/* Tabalas que alimentan las indicaciones */

	/*Farmacologicas*/
CREATE TABLE indicaciones_farmacologicas (
	id_indicacion_farmacologica INT NOT NULL AUTO_INCREMENT,
	id_indicacion INT NOT NULL,
	id_farmaco INT NOT NULL,
	intervalo_horas INT NOT NULL,
	duracion INT NOT NULL,
	PRIMARY KEY (id_indicacion_farmacologica)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE farmacos (
	id_farmaco INT NOT NULL AUTO_INCREMENT,
	complejo_activo_farmaco VARCHAR (15) NOT NULL,
	desc_farmaco TEXT,
	nombre_comercial_farmaco TEXT,
	PRIMARY KEY (id_farmaco)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

	/*Examenes a realizar*/
CREATE TABLE examenes (
	id_examen INT NOT NULL AUTO_INCREMENT,
	id_indicacion INT NOT NULL,
	nombre_examen VARCHAR (80) NOT NULL,
	PRIMARY KEY (id_examen)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;


	/*Fisioterapeuticas*/
CREATE TABLE indicaciones_fisioterapias (
	id_indicacion_fisioterapia INT NOT NULL AUTO_INCREMENT,
	id_indicacion INT NOT NULL,
	fecha_inicio_fisioterapia DATE NOT NULL,
	numero_sesiones INT NOT NULL,
	PRIMARY KEY (id_indicacion_fisioterapia)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE fisioterapias (
	id_fisioterapia INT NOT NULL AUTO_INCREMENT,
	id_especialista INT,
	ejercicios_fisioterapia TEXT,
	horario_fisioterapia DATETIME,
	sesion_fisioterapia INT NOT NULL,
	id_estatus_fisioterapia INt NOT NULL,
	id_indicacion_fisioterapia INT NOT NULL,
	PRIMARY KEY (id_fisioterapia)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE especialistas (
	id_especialista INT NOT NULL AUTO_INCREMENT,
	ci_especialista VARCHAR (12) NOT NULL,
	nombre_especialista VARCHAR (15) NOT NULL,
	apellido_especialista VARCHAR (15) NOT NULL,
	telefono_especialista VARCHAR (15) NOT NULL,
	email_especialista VARCHAR (50) NOT NULL,
	PRIMARY KEY (id_especialista)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE estatus_fisioterapias (
	id_estatus_fisioterapia INT NOT NULL AUTO_INCREMENT,
	simbolo_estatus_fisioterapia VARCHAR (2) NOT NULL,
	nombre_estatus_fisioterapia VARCHAR (20) NOT NULL,
	desc_estatus_fisioterapia TEXT,
	PRIMARY KEY (id_estatus_fisioterapia)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;




/*Usuarios*/

CREATE TABLE usuarios (
	id_usuario INT NOT NULL AUTO_INCREMENT,
	nombre_usuario VARCHAR (15) NOT NUll,
	pw_usuario VARCHAR (10) NOT NULL,
	id_permiso INT NOT NULL,
	PRIMARY KEY (id_usuario)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE permisos (
	id_permiso INT NOT NULL AUTO_INCREMENT,
	nombre_permiso VARCHAR (15) NOT NULL,
	desc_permiso VARCHAR (50) NOT NULL,
	PRIMARY KEY (id_permiso)
)ENGINE=MyISAM DEFAULT CHARSET = utf8;

/**/

/*Inserciones Usuarios*/
INSERT INTO
 `usuarios`(
 	`id_usuario`,
 	`nombre_usuario`,
 	`pw_usuario`,
 	`id_permiso`
 	)
 VALUES
 	(NULL, 'admin','admin',1),
 	(NULL, 'user','user',2);

INSERT INTO
 `permisos` (
 	`id_permiso`,
 	`nombre_permiso`,
 	`desc_permiso`
 	)
 VALUES
 	(NULL,'Administrador','Acceso Total'),
 	(NULL,'Usuario','Acceso Parcial');

 /*Inserciones Consultas*/
INSERT INTO
`tipos_consultas`(
	`id_tipo_consulta`,
	`nombre_tipo_consulta`,
	`desc_tipo_consulta`
	)
VALUES
	(NULL,'Diagnostico','La consulta de diagnostico se realiza cuando el paciente asiste por primera vez al recinto'),
	(NULL,'Control','La consulta de control se realiza cuando es necesario analizar la evolucion del tratamiento del paciente');

INSERT INTO
`consultas`(
	`id_consulta`,
	`fecha_consulta`,
	`desc_informe_medico`,
	`desc_examen_fisico`,
	`desc_diagnostico`,
	`id_tipo_consulta`,
	`id_historial_medico`)
VALUES
	(NULL,'2016-09-19 07:00:00','Informe Medico','Examen Fisico','Diagnostico',1,1),
	(NULL,'2016-09-19 08:00:00','Informe Medico','Examen Fisico','Diagnostico',1,2),
	(NULL,'2016-09-19 09:00:00','Informe Medico','Examen Fisico','Diagnostico',1,3),
	(NULL,'2016-09-19 10:00:00','Informe Medico','Examen Fisico','Diagnostico',1,4),
	(NULL,'2016-09-19 11:00:00','Informe Medico','Examen Fisico','Diagnostico',1,5),
	(NULL,'2016-09-19 13:00:00','Informe Medico','Examen Fisico','Diagnostico',1,6),
	(NULL,'2016-09-19 14:00:00','Informe Medico','Examen Fisico','Diagnostico',1,7),
	(NULL,'2016-09-19 15:00:00','Informe Medico','Examen Fisico','Diagnostico',1,8);

/*nserciones de pagos*/
INSERT INTO
`tipos_pagos`(
	`id_tipo_pago`,
	`nombre_tipo_pago`,
	`desc_tipo_pago`)
VALUES
	(NULL,'Convenio', 'Este es el pago que se raliza por medio de un convenio'),
	(NULL,'Seguros', 'Este es el pago que se raliza con seguro');

INSERT INTO
`pagos`(
	`id_pago`,
	`fecha_pago`,
	`id_tipo_pago`,
	`entidad_pago`,
	`desc_pago`,
	`id_historial_medico`)
VALUES
	(NULL,'2016-09-19 07:00:00',1,'Seguros Caracas','Descripcion del pago',1),
	(NULL,'2016-09-19 08:00:00',2,'Seguros Caracas','Descripcion del pago',2),
	(NULL,'2016-09-19 09:00:00',1,'Seguros Caracas','Descripcion del pago',3),
	(NULL,'2016-09-19 10:00:00',2,'Seguros Caracas','Descripcion del pago',4),
	(NULL,'2016-09-19 11:00:00',1,'Seguros Caracas','Descripcion del pago',5),
	(NULL,'2016-09-19 13:00:00',2,'Seguros Caracas','Descripcion del pago',6),
	(NULL,'2016-09-19 14:00:00',1,'Seguros Caracas','Descripcion del pago',7),
	(NULL,'2016-09-19 15:00:00',2,'Seguros Caracas','Descripcion del pago',8);


/*Isercion Historiales Medicos*/
INSERT INTO
`historiales_medicos`(
	`id_historial_medico`,
	`fecha_creacion_historial_medico`,
	`id_paciente`)
VALUES
	(NULL,'2016-09-19 07:00:00',1),
	(NULL,'2016-09-19 08:00:00',2),
	(NULL,'2016-09-19 09:00:00',3),
	(NULL,'2016-09-19 10:00:00',4),
	(NULL,'2016-09-19 11:00:00',5),
	(NULL,'2016-09-19 13:00:00',6),
	(NULL,'2016-09-19 14:00:00',7),
	(NULL,'2016-09-19 15:00:00',8);

/*Inserciones Pacientes*/
INSERT INTO
`pacientes`(
	`id_paciente`,
	`ci_paciente`,
	`nombre_paciente`,
	`apellido_paciente`,
	`edad_paciente`,
	`telefono_paciente`,
	`email_paciente`,
	`id_estatus`)
VALUES
	(NULL,'1234','Paciente','Uno','20','0123-4567890','pueba@email.com',1),
	(NULL,'1235','Paciente','Dos','21','0123-4567890','pueba@email.com',1),
	(NULL,'1236','Paciente','Tres','22','0123-4567890','pueba@email.com',1),
	(NULL,'1237','Paciente','Cuatro','23','0123-4567890','pueba@email.com',1),
	(NULL,'1238','Paciente','Cinco','24','0123-4567890','pueba@email.com',1),
	(NULL,'1239','Paciente','Seis','25','0123-4567890','pueba@email.com',1),
	(NULL,'12310','Paciente','Siete','26','0123-4567890','pueba@email.com',1),
	(NULL,'12311','Paciente','Ocho','27','0123-4567890','pueba@email.com',1);

INSERT INTO
`estatus_pacientes`(
	`id_estatus_paciente`,
	`letra_estatus_paciente`,
	`nombre_estatus_paciente`,
	`desc_estatus_paciente`)
VALUES
	(NUll,'I','Ingreso','Este estatus se le da a los pacientes que solicitan un diagnóstico para alguna afección, significa que debe asistir a la consulta de diagnpostico con el especialista'),
	(NUll,'T','Tratamiento','Este estatus se le asigna a los pacientes que ya pasaron por una consulta de diagnostico y han sido asignados a tratamientos repetitvos que requieren la asistencia al resinto diariamente (fisioterapia)'),
	(NUll,'C','Control','Este estatus se le asigna a los pacientes que han cumplido determinada cantidad de tratamientos y necesitan una revision para determinar la evolución de la afección'),
	(NULL,'A','Alta','El Paciente ya no necesita tratamiento alguno para su afeccion');

/*Inserciones Farmacos*/
INSERT INTO
`farmacos`(
	`id_farmaco`,
	`complejo_activo_farmaco`,
	`desc_farmaco`,
	`nombre_comercial_farmaco`)
VALUES
	(NULL,'Ibuprofeno','El ibuprofeno es un antiinflamatorio no esteroideo (AINE), utilizado frecuentemente como antipirético, analgésico y antiinflamatorio. Se utiliza para el alivio sintomático de la fiebre, dolor de cabeza (cefalea), dolor dental (odontalgia), dolor muscular o mialgia, molestias de la menstruación (dismenorrea), dolor neurológico de carácter leve o moderado y dolor postquirúrgico. También se usa para tratar cuadros inflamatorios, como los que se presentan en artritis, artritis reumatoide (AR) y artritis gotosa.','Advil,Algiasdin,Algidrin,Alogesia,Altior,Babypiril,Dadosel,Dalsy,Diltix,Doctril');


/*Iserciones Fisioterapias*/
INSERT INTO
`estatus_fisioterapias`(
	`id_estatus_fisioterapia`,
	`simbolo_estatus_fisioterapia`,
	`nombre_estatus_fisioterapia`,
	`desc_estatus_fisioterapia`)
VALUES
	(NULL,'S','Sin Asignar','El tratamiento fue creado pero aun no se ha idicado el horario a cumplir ni el especialista que lo aplicara'),
	(NULL,'A','Asignado','El tratamiento fue creado y le fue asignado un horario y un especialista que lo aplicara'),
	(NULL,'C','Completado','El tratamiento fue aplicado al paciente con exito'),
	(NULL,'F','Falla','El tratamiento no fue aplicado al paciente con exito');

/*Inserciones Especialistas*/
INSERT INTO 
	`especialistas`(
		`id_especialista`, 
		`ci_especialista`, 
		`nombre_especialista`, 
		`apellido_especialista`, 
		`telefono_especialista`, 
		`email_especialista`) 
VALUES 
	(NULL, '1234','especialista','Uno','0414-12341','prueba@ejemplo.com'),
	(NULL, '1235','especialista','Dos','0414-12352','prueba@ejemplo.com'),
	(NULL, '1236','especialista','Tres','0414-12363','prueba@ejemplo.com'),
	(NULL, '1237','especialista','Cuatro','0414-12374','prueba@ejemplo.com'),
	(NULL, '1238','especialista','Cinco','0414-12385','prueba@ejemplo.com');