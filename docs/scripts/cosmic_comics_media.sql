CREATE TABLE `media` (
  `media_id` int NOT NULL AUTO_INCREMENT,
  `media_doc` varchar(80) NOT NULL,
  `media_path` varchar(150) NOT NULL,
  `comic_id` int DEFAULT NULL,
  PRIMARY KEY (`MediaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;