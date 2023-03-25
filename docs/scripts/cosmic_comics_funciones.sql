CREATE TABLE `funciones` (
  `funcion_id` varchar(255) NOT NULL,
  `funcion_dsc` varchar(45) NOT NULL,
  `funcion_est` char(3) NOT NULL,
  `funcion_tipo` char(3) NOT NULL,
  PRIMARY KEY (`funcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;