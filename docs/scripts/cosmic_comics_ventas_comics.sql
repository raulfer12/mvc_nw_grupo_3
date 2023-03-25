CREATE TABLE `ventascomics` (
  `comics_id` int NOT NULL,
  `venta_id` int NOT NULL,
  `ventas_prod_cantidad` int NOT NULL,
  `ventas_prod_precio_venta` decimal(9,2) NOT NULL,
  PRIMARY KEY (`comics_id`,`venta_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;