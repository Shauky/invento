/* Roles:
1 = Administrator
2 = General Supervisor
3 = Supervisor
4 = Employee
*/
CREATE TABLE `invento_users`(
`id` INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(`id`),
`username` VARCHAR(100) NOT NULL,
`password` CHAR(32) NOT NULL,
`name` VARCHAR(300) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`role` INT(1) NOT NULL,
`date_added` DATE DEFAULT '0000-00-00' /* YYYY-MM-DD */
);

CREATE TABLE `invento_categories`(
`id` INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(`id`),
`name` VARCHAR(200) NOT NULL,
`place` VARCHAR(200) NOT NULL,
`descrp` VARCHAR(400) NOT NULL,
`date_added` DATE DEFAULT '0000-00-00' /* YYYY-MM-DD */
);


CREATE TABLE `invento_items`(
`id` INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(`id`),
`name` VARCHAR(200) NOT NULL,
`descrp` VARCHAR(400) NOT NULL,
`category` INT NOT NULL,
`qty` INT NOT NULL,
`price` DECIMAL(15,2) NOT NULL,
`date_added` DATE DEFAULT '0000-00-00' /* YYYY-MM-DD */
);

/* Types:
1 = Check-In
2 = Check-Out
3 = Price change

(for home) When check-in or check-out, TOTAL price will be saved in "fromprice"
*/
CREATE TABLE `invento_logs`(
`id` INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(`id`),
`type` INT(1) NOT NULL,
`item` INT NOT NULL,
`fromqty` INT NOT NULL,
`toqty` INT NOT NULL,
`fromprice` DECIMAL(15,2) NOT NULL,
`toprice` DECIMAL(15,2) NOT NULL,
`date_added` DATE DEFAULT '0000-00-00', /* YYYY-MM-DD */
`user` INT NOT NULL
);


CREATE TABLE `invento_settings`(
`id` INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(`id`),
`name` VARCHAR(80) NOT NULL,
`val` TEXT NOT NULL
);

/* Title of the site */
INSERT INTO `invento_settings`(`name`,`val`) VALUES('site_title', 'Invento - %page%');

/* Site Logo URL */
INSERT INTO `invento_settings`(`name`,`val`) VALUES('site_logo', 'media/img/logo3x.png');

/* Allow users to change their names? */
INSERT INTO `invento_settings`(`name`,`val`) VALUES('allow_namechange', 'y');

/* Allow users to change their email? */
INSERT INTO `invento_settings`(`name`,`val`) VALUES('allow_emailchange', 'y');

/* Default user */
INSERT INTO `invento_users`(`username`,`password`,`name`,`email`,`role`) VALUES('Sourcegeek', '9d38f11be6e0a8b9da2a9dfd8ed0d6f5', 'Ricardo Yubal', 'tecnovirtu@gmail.com', 1);