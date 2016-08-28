DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`( `id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(150) NOT NULL, `password` varchar(64) DEFAULT NULL, `name` varchar(150) NOT NULL, `last_name` varchar(100) DEFAULT NULL, `short_name` varchar(8) DEFAULT NULL, created datetime, modified datetime, PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
);
