DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(1) NOT NULL DEFAULT 0,
  `email` varchar(150) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `initials` varchar(8) DEFAULT NULL,
  `created` datetime,
  `modified` datetime,
  `is_active` boolean NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `report_overdue_notification_text` TEXT NOT NULL,
  `report_overdue_frequency_hours` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `projects_users`;
CREATE TABLE IF NOT EXISTS `projects_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `scrum_reports`;
CREATE TABLE IF NOT EXISTS `scrum_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) NOT NULL,
  `deadline_date` date,
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

DROP TABLE IF EXISTS `user_user_scrum_reports`;
CREATE TABLE IF NOT EXISTS `user_user_scrum_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_scrum_report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_seen_date` datetime,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `sprints`;
CREATE TABLE IF NOT EXISTS `sprints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date,
  `end_date` date,
  `report_weekdays` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `sprints_users`;
CREATE TABLE IF NOT EXISTS `sprints_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `password_tokens`;
CREATE TABLE IF NOT EXISTS `password_tokens` (
  `token` char(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY(`token`)
);

DROP TABLE IF EXISTS `account_tokens`;
CREATE TABLE IF NOT EXISTS `account_tokens` (
  `token` char(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY(`token`)
);

DROP TABLE IF EXISTS `app_settings`;
CREATE TABLE IF NOT EXISTS `app_settings` (
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`name`)
);

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `href` varchar(100) NOT NULL,
  `created_time` datetime NOT NULL,
  `read` boolean DEFAULT 0,
  `text` varchar(300) NOT NULL,
  `title` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
);

-- INSERT INTO app_settings
INSERT INTO app_settings (name, value)
    VALUES ('allow_registration', 'True');
