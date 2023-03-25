CREATE TABLE `ventas` (
  `venta_id` int NOT NULL AUTO_INCREMENT,
  `venta_date` datetime NOT NULL,
  `venta_ISV` decimal(9,2) NOT NULL,
  `venta_est` varchar(10) NOT NULL,
  `venta_link_devolucion` varchar(100) DEFAULT NULL,
  `venta_link_orden` varchar(100) DEFAULT NULL,
  `venta_cantidad_total` decimal(9,2) DEFAULT NULL,
  `venta_comision_PayPal` decimal(9,2) DEFAULT NULL,
  `venta_cantidad_neta` decimal(9,2) DEFAULT NULL,
  `cliente_tel` char(20) DEFAULT NULL,
  `cliente_dir` char(180) DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`venta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;