CREATE TABLE `carritocompra` (
  `usuario_id` int NOT NULL,
  `comic_id` int NOT NULL,
  `prod_cantidad` int NOT NULL,
  `comic_precio_venta` decimal(9,2) NOT NULL,
  `prod_fecha_ingreso` datetime NOT NULL,
  PRIMARY KEY (`UsuarioId`,`LibrodId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;