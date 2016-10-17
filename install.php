<?php
$noredir = true;
require 'config.php';

if($dbhost == 'localhost' && $dbuser == 'MYSQL USERNAME' && $dbpass == 'MYSQL PASSWORD')
	die('<h3 style="color:#555;">Please open the <i>config.php</i> file and change the first 4 variables with your
	MySQL Details. For further information, please read the documentation (/documentation/index.html)</h3>');

// Check Connection
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($mysqli->connect_errno)
	die('<h3 style="color:#555;">Config.php - Unable to create connection. Please check your MySQL Details</h3>');

$res = $mysqli->query("SHOW TABLES FROM `{$dbname}` WHERE `tables_in_{$dbname}` LIKE '%invento_users%' OR 
`tables_in_{$dbname}` LIKE '%invento_categories%' OR `tables_in_{$dbname}` LIKE '%invento_items%' OR 
`tables_in_{$dbname}` LIKE '%invento_logs%' OR `tables_in_{$dbname}` LIKE '%invento_settings%'");
if($res->num_rows == 5)
	header('Location: index.php');
elseif($res->num_rows == 0) {	
	// No tables exist. Proceed with installation
	$tables = "CREATE TABLE `invento_users`(`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(`id`), `username` VARCHAR(100) NOT NULL, `password` CHAR(32) NOT NULL, `name` VARCHAR(300) NOT NULL, `email` VARCHAR(255) NOT NULL, `role` INT(1) NOT NULL, `date_added` DATE); 
	CREATE TABLE `invento_categories`(`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(`id`), `name` VARCHAR(200) NOT NULL, `place` VARCHAR(200) NOT NULL, `descrp` VARCHAR(400) NOT NULL, `date_added` DATE); 
	CREATE TABLE `invento_items`(`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(`id`), `name` VARCHAR(200) NOT NULL, `descrp` VARCHAR(400) NOT NULL, `category` INT NOT NULL, `qty` INT NOT NULL, `price` DECIMAL(15,2) NOT NULL, `date_added` DATE); 
	CREATE TABLE `invento_logs`(`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(`id`), `type` INT(1) NOT NULL, `item` INT NOT NULL, `fromqty` INT NOT NULL, `toqty` INT NOT NULL, `fromprice` DECIMAL(15,2) NOT NULL, `toprice` DECIMAL(15,2) NOT NULL, `date_added` DATE, `user` INT NOT NULL); 
	CREATE TABLE `invento_settings`(`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(`id`), `name` VARCHAR(80) NOT NULL, `val` TEXT NOT NULL);";
	
	$insert = "INSERT INTO `invento_settings`(`name`,`val`) VALUES('site_title', 'Invento - %page%'); 
	INSERT INTO `invento_settings`(`name`,`val`) VALUES('site_logo', 'media/img/logo3x.png'); 
	INSERT INTO `invento_settings`(`name`,`val`) VALUES('allow_userchange', 'y'); 
	INSERT INTO `invento_settings`(`name`,`val`) VALUES('allow_namechange', 'y'); 
	INSERT INTO `invento_settings`(`name`,`val`) VALUES('allow_emailchange', 'y'); 
	INSERT INTO `invento_settings`(`name`,`val`) VALUES('installed', 'n'); 
	INSERT INTO `invento_users`(`username`,`password`,`name`,`email`,`role`,`date_added`) VALUES('admin', '".md5('invento1234')."', 'Admin Account', 'admin@admin.com', 1, '".date('Y-m-d')."');";
	
	// Create tables
	if($mysqli->multi_query($tables) == false) {
		var_dump($mysqli);
		die('<h3 style="color:#555;">Invento instalation failed. Please try again</h3>');}
	
	while($mysqli->more_results())
		$mysqli->next_result();
	
	// Insert new data
	if($mysqli->multi_query($insert) == false)
		die('<h3 style="color:#555;">Invento instalation failed. Please try againnn</h3>');

// All good. Done :)
?>
<!DOCTYPE html>
<html>
<head>
	<title>Invento Installation</title>
	<style>
		body,html { padding:0; margin:0; }
	</style>
</head>
<body style="width:100%; height:100%; text-align:center; background-color:#f5f5f5;color:#555;font-family:Arial;">
	<div style="margin:auto;width:500px;background-color:#FFF;padding:10px;">
		<span style="font-size:18px;color:#888;">
			Hi. The Invento installation has been completed successfully. An account has been
			automatically created for you. The login credentials are:<br /><br />
			<strong>Username:</strong> admin<br />
			<strong>Password:</strong> invento1234
			<br /><br />
			<strong>You MUST change your password immediately. To do this, log into your account and go
			to Settings.</strong><br />
			<strong>Also, you MUST delete this file.</strong>
		</span>
	</div>
</body>
</html>
<?php
}else{
	// Some of the tables exist. Give instructions
	die('<h3 style="color:#555;">A corrupt Invento installation has been detected. Please go ahead and delete all
	<i>invento_</i> tables existing in your database and reload this file.</h3>');
}
?>
</body>
</html>
