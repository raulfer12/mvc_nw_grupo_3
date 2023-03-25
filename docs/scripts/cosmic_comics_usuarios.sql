CREATE TABLE `usuarios` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(80) NOT NULL,
  `usuario_email` varchar(80) NOT NULL,
  `usuario_pswd` varchar(128) NOT NULL,
  `usuario_fching` datetime NOT NULL,
  `usuario_pswd_est` char(3) NOT NULL,
  `usuario_pswd_exp` datetime NOT NULL,
  `usuario_est` char(3) NOT NULL,
  `usuario_act_cod` varchar(128) NOT NULL,
  `usuario_tipo` char(3) NOT NULL,
  `usuario_pswd_chg` varchar(128) NOT NULL,
  `cliente_tel` varchar(20) DEFAULT NULL,
  `cliente_dir` varchar(180) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_email_UNIQUE` (`usuario_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;