drop database deinacridaDB;
create database deinacridaDB;
use deinacridaDB;

create table usuario(
	id int not null auto_increment,
    tipo_usuario varchar(20) not null,
    nombre varchar(45) not null,
    correo varchar(45) not null,
    contrasena varchar(20) not null,
    primary key(id)
);

create table administrador(
	rut varchar(9) not null,
    usuario_id int not null,
    primary key(rut),
    foreign key(usuario_id) references usuario(id) on delete cascade on update cascade
);

create table profesor(
	rut varchar(9) not null,
	usuario_id int not null,
    primary key(rut),
    foreign key(usuario_id) references usuario(id) on delete cascade on update cascade
);

create table estudiante(
	rut varchar(9) not null,
    huella_dactilar int,
	usuario_id int not null,
    primary key(rut),
    foreign key(usuario_id) references usuario(id) on delete cascade on update cascade
);


create table clase(
	id int not null auto_increment,
    profesor_rut varchar(9) not null,
    sala varchar(10) not null,
    fecha date not null,
    horario_inicio time not null,
    horario_fin time not null,
    semestre tinyint not null,
    iniciada tinyint not null,
    primary key(id),
    foreign key(profesor_rut) references profesor(rut) on delete cascade on update cascade
);

/*
create table horario(
	id int not null,
    fecha date not null,
    horario_inicio time not null,
    horario_fin time not null,
    semestre int not null,
    primary key(id)
);*/

/*
create table curso_tiene_horario(
	curso_id int not null,
    horario_id int not null,
    primary key(curso_id, horario_id),
    foreign key(curso_id) references curso(id) on delete cascade on update cascade,
    foreign key(horario_id) references horario(id) on delete cascade on update cascade
);*/


create table asistencia(
	id int not null auto_increment,
	fecha datetime not null,
	clase_id int not null,
    estudiante_rut varchar(9) not null,
    asistencia tinyint not null,
    atraso tinyint not null,
    primary key(id),
    foreign key(clase_id) references clase(id) on delete cascade on update cascade,
    foreign key(estudiante_rut) references estudiante(rut) on delete cascade on update cascade
);



insert into usuario (tipo_usuario, nombre, correo, contrasena) values
	("administrador", "wiwi", "wiwi@gmail.com", "wiwi123"),
    ("docente", "tuki", "tuki@gmail.com", "tuki123"),
    ("estudiante", "Omero", "omero@gmail.com", "omero123"),
    ("docente", "tukiki", "tuki2@gmail.com", "tuki321"),
    ("estudiante", "mocoso", "mocoso@gmail.com", "mocoso123"),
    ("estudiante", "Omero2", "omero2@gmail.com", "omero2123"),
    ("estudiante", "Omero3", "omero3@gmail.com", "omero3123"),
    ("estudiante", "Omero4", "omero4@gmail.com", "omero4123"),
    ("estudiante", "Omero5", "omero5@gmail.com", "omero5123"),
    ("estudiante", "Omero6", "omero6@gmail.com", "omero6123")
    ;
    
insert into administrador values
	("123456789",1);
    
insert into profesor values
	("123456778",2),
    ("111111111", 4);
    
insert into estudiante values
	("123456777", 1, 3),
    ("123456779", 2, 5);
    
insert into clase (profesor_rut, sala, fecha, horario_inicio, horario_fin, semestre, iniciada) values
	("123456778", "Sala 1", "2023-10-17", "08:15", "10:10", 2, 0),
    ("123456778", "Sala 1", "2023-10-18", "10:10", "12:10", 2, 0),
    ("123456778", "Sala 1", "2023-10-24", "08:15", "10:10", 2, 0),
    ("123456778", "Sala 1", "2023-10-25", "10:10", "12:10", 2, 0),
    ("123456778", "Sala 1", "2023-10-31", "08:15", "10:10", 2, 0),
    ("123456778", "Sala 1", "2023-11-01", "10:10", "12:10", 2, 0),
    ("123456778", "Sala 1", "2023-11-07", "08:15", "10:10", 2, 0),
    ("123456778", "Sala 1", "2023-10-29", "18:15", "20:00", 2, 0);

  
insert into asistencia (fecha, clase_id, estudiante_rut, asistencia, atraso) values
    ("2023-10-17 08:40:00", 1, "123456777", 1, 1),
    ("2023-10-18 10:10:20", 1, "123456777", 0, 0),
    ("2023-10-24 08:15:00", 2, "123456777", 1, 0),
    ("2023-10-25 10:10:00", 2, "123456777", 0, 0),
    ("2023-10-31 09:05:00", 2, "123456777", 1, 1),
    ("2023-11-01 10:12:20", 2, "123456777", 1, 0),
    ("2023-11-07 08:15:00", 3, "123456777", 0, 0);
    
-- insert into asistencia values
	-- ();
-- show tables;
select count(*) from asistencia
where estudiante_rut = "123456777" and asistencia = 1;


Select nombre from usuario where id = 3;
SELECT count(*) from clase;

select count(*) from asistencia
where estudiante_rut = "123456777" and asistencia = 1;

SELECT * FROM clase WHERE fecha = '2023-10-29' AND horario_inicio <= "18:43:18" AND horario_fin > "18:43:18";

INSERT INTO asistencia (fecha, clase_id, estudiante_rut, asistencia, atraso) VALUES ('2023-10-29',8,'123456777',1,0);

select * from asistencia;