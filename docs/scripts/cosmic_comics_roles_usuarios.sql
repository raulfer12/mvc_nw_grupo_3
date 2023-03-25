CREATE TABLE `rolesusuario` (
  `usuario_id` int NOT NULL,
  `rol_id` varchar(15) NOT NULL,
  `rol_usuario_est` char(3) NOT NULL,
  `rol_usuario_date` datetime NOT NULL,
  `rol_usuario_exp` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;