CREATE TABLE IF NOT EXISTS `#__somosmaestros_premios` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`premio` VARCHAR(255)  NOT NULL ,
`descripcion` TEXT NOT NULL ,
`puntos` VARCHAR(255)  NOT NULL ,
`imagen` VARCHAR(255)  NOT NULL ,
`destacado` BOOLEAN NOT NULL ,
`cantidad` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_capanas` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`tipo` VARCHAR(255)  NOT NULL ,
`fecha_inicio` DATE NOT NULL ,
`fecha_fin` DATE NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`segmento` VARCHAR(255)  NOT NULL ,
`nivel` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`area` VARCHAR(255)  NOT NULL ,
`proyecto` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
`publicacion` VARCHAR(255)  NOT NULL ,
`puntos` VARCHAR(255)  NOT NULL ,
`meta` VARCHAR(255)  NOT NULL ,
`meta_reservas` VARCHAR(255)  NOT NULL ,
`tipo_institucion` VARCHAR(255)  NOT NULL ,
`idtipopuntos` INT(11)  NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_tipo_institucion` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`tipo` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_articulos` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`contenido` TEXT NOT NULL ,
`imagen_grande` VARCHAR(255)  NOT NULL ,
`imagen_pequena` VARCHAR(255)  NOT NULL ,
`categoria` INT NOT NULL ,
`destacado` BOOLEAN NOT NULL ,
`publico` BOOLEAN NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`tipo_institucion` VARCHAR(255)  NOT NULL ,
`segmento` VARCHAR(255)  NOT NULL ,
`nivel` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`area` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
`proyecto` VARCHAR(255)  NOT NULL ,
`fuente` VARCHAR(255)  NOT NULL ,
`preview` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_categorias_articulos` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`categoria` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_blogs` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`contenido` TEXT NOT NULL ,
`imagen_grande` VARCHAR(255)  NOT NULL ,
`imagen_pequena` VARCHAR(255)  NOT NULL ,
`categoria` INT NOT NULL ,
`destacado` BOOLEAN NOT NULL ,
`publico` BOOLEAN NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`tipo_institucion` VARCHAR(255)  NOT NULL ,
`segmento` VARCHAR(255)  NOT NULL ,
`nivel` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`area` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
`proyecto` VARCHAR(255)  NOT NULL ,
`fuente` VARCHAR(255)  NOT NULL ,
`preview` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_categorias_blog` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`categoria` VARCHAR(255)  NOT NULL ,
`imagen` VARCHAR(255)  NOT NULL ,
`icono` VARCHAR(255)  NOT NULL ,
`descripcion` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_agenda` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`contenido` TEXT NOT NULL ,
`imagen_grande` VARCHAR(255)  NOT NULL ,
`imagen_pequena` VARCHAR(255)  NOT NULL ,
`categoria` INT NOT NULL ,
`publico` BOOLEAN NOT NULL ,
`destacado` BOOLEAN NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`tipo_institucion` VARCHAR(255)  NOT NULL ,
`segmento` VARCHAR(255)  NOT NULL ,
`nivel` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`area` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
`proyecto` VARCHAR(255)  NOT NULL ,
`asistentes` VARCHAR(255)  NOT NULL ,
`disponibilidad` VARCHAR(255)  NOT NULL ,
`fuente` VARCHAR(255)  NOT NULL ,
`preview` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_categorias_agenda` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`categoria` VARCHAR(255)  NOT NULL ,
`imagen` VARCHAR(255)  NOT NULL ,
`color` VARCHAR(255)  NOT NULL ,
`ancho` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_formacion` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`contenido` TEXT NOT NULL ,
`imagen_grande` VARCHAR(255)  NOT NULL ,
`imagen_pequena` VARCHAR(255)  NOT NULL ,
`destacado` BOOLEAN NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`tipo_institucion` VARCHAR(255)  NOT NULL ,
`segmento` VARCHAR(255)  NOT NULL ,
`nivel` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`area` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
`proyecto` VARCHAR(255)  NOT NULL ,
`publico` BOOLEAN NOT NULL ,
`asistentes` VARCHAR(255)  NOT NULL ,
`disponibilidad` VARCHAR(255)  NOT NULL ,
`fuente` VARCHAR(255)  NOT NULL ,
`preview` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_slider_publico` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`descripcion` VARCHAR(255)  NOT NULL ,
`imagen_publico` VARCHAR(255)  NOT NULL ,
`link` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_slider_interno` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
`descripcion` VARCHAR(255)  NOT NULL ,
`imagen_interno` VARCHAR(255)  NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`tipo_institucion` VARCHAR(255)  NOT NULL ,
`segmento` VARCHAR(255)  NOT NULL ,
`nivel` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`area` VARCHAR(255)  NOT NULL ,
`rol` VARCHAR(255)  NOT NULL ,
`proyecto` VARCHAR(255)  NOT NULL ,
`publico` BOOLEAN NOT NULL ,
`link` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_asistentes_agenda` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` BIGINT(20)  NOT NULL ,
`agenda` INT NOT NULL ,
`fecha` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`asistio` BOOLEAN NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_asistentes_formacion` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` INT(11)  NOT NULL ,
`formacion` INT NOT NULL ,
`fecha` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`asistio` BOOLEAN NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_comentarios_blog` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`comentario` TEXT NOT NULL ,
`cedula` BIGINT(20)  NOT NULL ,
`blog` INT NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_video` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`url` VARCHAR(255)  NOT NULL ,
`imagen` VARCHAR(255)  NOT NULL ,
`titulo` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_sm_personas` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`nombre` VARCHAR(255)  NOT NULL ,
`usuario` VARCHAR(255)  NOT NULL ,
`perfil` VARCHAR(255)  NOT NULL ,
`password` VARCHAR(255)  NOT NULL ,
`delegacion` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_sm_registro` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` VARCHAR(255)  NOT NULL ,
`fecha` VARCHAR(255)  NOT NULL ,
`nombres` VARCHAR(255)  NOT NULL ,
`apellidos` VARCHAR(255)  NOT NULL ,
`telefono` VARCHAR(255)  NOT NULL ,
`correo` VARCHAR(255)  NOT NULL ,
`departamento` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`genero` VARCHAR(255)  NOT NULL ,
`institucion` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_sm_actualizacion` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` VARCHAR(255)  NOT NULL ,
`fecha` VARCHAR(255)  NOT NULL ,
`nombres` VARCHAR(255)  NOT NULL ,
`apellidos` VARCHAR(255)  NOT NULL ,
`telefono` VARCHAR(255)  NOT NULL ,
`correo` VARCHAR(255)  NOT NULL ,
`departamento` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`genero` VARCHAR(255)  NOT NULL ,
`institucion` VARCHAR(255)  NOT NULL ,
`observaciones` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_logs` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`date` VARCHAR(255)  NOT NULL ,
`time` VARCHAR(255)  NOT NULL ,
`vista` VARCHAR(255)  NOT NULL ,
`cedula` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_campana_blog` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` BIGINT(20)  NOT NULL ,
`blog` INT NOT NULL ,
`fecha` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`campana` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_campana_perfil` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` BIGINT(20)  NOT NULL ,
`fecha` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`campana` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__somosmaestros_sm_brujula` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`cedula` VARCHAR(255)  NOT NULL ,
`fecha` VARCHAR(255)  NOT NULL ,
`nombres` VARCHAR(255)  NOT NULL ,
`apellidos` VARCHAR(255)  NOT NULL ,
`telefono` VARCHAR(255)  NOT NULL ,
`correo` VARCHAR(255)  NOT NULL ,
`departamento` VARCHAR(255)  NOT NULL ,
`ciudad` VARCHAR(255)  NOT NULL ,
`genero` VARCHAR(255)  NOT NULL ,
`institucion` VARCHAR(255)  NOT NULL ,
`observaciones` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

