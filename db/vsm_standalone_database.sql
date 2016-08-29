DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`( `id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(150) NOT NULL, `password` varchar(64) DEFAULT NULL, `name` varchar(150) NOT NULL, `last_name` varchar(100) DEFAULT NULL, `short_name` varchar(8) DEFAULT NULL, created datetime, modified datetime, PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `scrum_reports`;
CREATE TABLE IF NOT EXISTS `scrum_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `deadline_date` datetime,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `user_scrum_reports`;
CREATE TABLE IF NOT EXISTS `user_scrum_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scrum_report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime,
  `modified` datetime,
  `q1_ans` TEXT NOT NULL,
  `q2_ans` TEXT NOT NULL,
  `q3_ans` TEXT NOT NULL,
  PRIMARY KEY (`id`)
);
