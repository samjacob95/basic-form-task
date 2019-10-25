CREATE TABLE IF NOT EXISTS `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `email` varchar(50) NOT NULL,
 `password` varchar(50) NOT NULL,
 `trn_date` datetime NOT NULL,
 PRIMARY KEY (`id`)
 );
 
 CREATE TABLE `password_reset_temp` (
  `email` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
);

CREATE TABLE `requests` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id`int(11),
  `title` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `initiator` varchar(250) NOT NULL,
  `initiator_email` varchar(250) NOT NULL,
  `assignee` varchar(250) NOT NULL,
  `priority` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
      FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);
