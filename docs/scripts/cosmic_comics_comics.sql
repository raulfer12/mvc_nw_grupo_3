CREATE TABLE `comics` (
  `comic_id` int NOT NULL AUTO_INCREMENT,
  `comic_nombre` varchar(120) NOT NULL,
  `comic_descripcion` varchar(1000) NOT NULL,
  `comic_precio_venta` decimal(9,2) NOT NULL,
  `comic_precio_compra` decimal(9,2) NOT NULL,
  `comic_est` char(3) NOT NULL,
  `comic_stock` int NOT NULL,
  PRIMARY KEY (`comic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;