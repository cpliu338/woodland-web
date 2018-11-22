DROP TABLE IF EXISTS `umb_skeletons`;
CREATE TABLE `umb_skeletons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
INSERT INTO `umb_skeletons` VALUES (1,'688','7.75\" - 6.25\" - 6.5\"\r\n全：5，部分：6\r\n19.5-19.75\r\n上幼3.5\"\r\n','2018-11-22 18:50:36'),(2,'802','7.75\" - 6.75\" - 7\"\r\n20\" 上粗3.75\"\r\n全身\r\n','2018-11-21 21:45:35'),(3,'S123','尾8-5/8 6.55 主6.65\r\n3-5/8  3-1/4\r\n','2018-11-22 18:52:20'),(4,'1-3-114','全新遮骨','2018-11-19 19:39:59'),(5,'378','9.85\" - 8.65\" - 8.75\"\r\n全長26.25\"\r\n靚 上粗4.5\" 橫4.15\"','2018-11-22 18:55:43');
DROP TABLE IF EXISTS `umb_tags`;
CREATE TABLE `umb_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `modified` datetime DEFAULT NULL,
  `type` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
INSERT INTO `umb_tags` VALUES (1,'土作','{\"type\":\"store location\"}','2018-11-21 20:54:31',1),(2,'銀','{\"type\":\"color\"}','2018-11-21 20:55:37',4),(3,'大 O','{\"type\":\"o-ring\"}','2018-11-21 20:59:24',5),(4,'無 O','{\"type\":\"o-ring\"}','2018-11-21 21:05:42',5),(5,'有勾','{type:hook}','2018-11-21 21:06:19',2),(6,'反骨','{type:structure}','2018-11-21 21:12:41',6),(7,'彈弓','{type:structure}','2018-11-21 21:13:02',6),(8,'黑','{\"type\":\"color\"}','2018-11-21 21:37:38',4),(9,'纖維','{\"type\":\"color\"}','2018-11-21 21:38:11',4);
DROP TABLE IF EXISTS `skeletons_tags`;
CREATE TABLE `skeletons_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skeleton_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
INSERT INTO `skeletons_tags` VALUES (8,2,4),(11,2,5),(15,3,2),(16,3,6),(17,3,7),(18,1,1),(19,1,2),(20,1,3),(21,5,1),(22,5,2),(23,5,5),(24,5,7);
