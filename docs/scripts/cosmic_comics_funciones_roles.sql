CREATE TABLE `funcionesroles` (
  `rol_id` varchar(15) NOT NULL,
  `funcion_id` varchar(255) NOT NULL,
  `funcion_rol_est` char(3) NOT NULL,
  `funcion_exp` datetime NOT NULL,
  PRIMARY KEY (`rol_id`,`funcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;