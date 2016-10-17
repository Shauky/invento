<?php
require 'config.php';
require 'inc/session.php';
require 'inc/home_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 1;

$role = $_session->get_user_role();
if($role != 1 && $role != 2)
	header('Location: items.php');

if(isset($_POST['act']) && $_POST['act'] == 'reqinfo') {
	$interval = $_POST['int'];

	$res = array(
		$_home->get_new_items($interval),
		$_home->get_checked_in($interval),
		$_home->get_checked_out($interval),
	);

	//$_check_in_price = $_home->get_checked_in_price($interval);
	//$_check_out_price = $_home->get_checked_out_price($interval);

	//$res[] = '$'.$_check_in_price;
	//$res[] = '$'.$_check_out_price;

	$res = implode('|', $res);

	echo $res;
	die();
}
?>
<!DOCTYPE HTML>
<html>
<?php require 'inc/head.php'; ?>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>

		<div class="wrapper-pad">
			<h2>Home</h2>
			<ul id="selectors">
				<li class="selected" value="today">TODAY</li>
				<li value="this_week">THIS WEEK</li>
				<li value="this_month">THIS MONTH</li>
				<li value="this_year">THIS YEAR</li>
				<li value="all_time">ALL TIME</li>
			</ul>

			<div id="fdetails">
				<div class="element">
					<span><?php echo $_home->get_new_items('today'); ?></span><br />
					NEW<br />
					ITEMS
				</div>
				<div class="element">
					<span><?php echo $_home->get_checked_in('today'); ?></span><br />
					CHECKED-IN<br />
					(QTY TOTAL)
				</div>
				<div class="element">
					<span><?php echo $_home->get_checked_out('today'); ?></span><br />
					CHECKED-OUT<br />
					(QTY TOTAL)
				</div>
				<!-- <div class="element">
					<span>$<?php // echo $_check_in_price = $_home->get_checked_in_price('today'); ?></span><br />
					CHECKED-IN
				</div>
				<div class="element">
					<span>$<?php // echo $_check_out_price = $_home->get_checked_out_price('today'); ?></span><br />
					CHECKED-OUT
				</div> -->
			</div>
		</div>

		<div class="clear" style="margin-bottom:40px;height:1px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>

		<div class="wrapper-pad">
			<h3>GENERAL STATS</h3>
			<div id="f2details">
				<div class="element">
					<span><?php echo $_home->general_registered_items(); ?></span><br />
					REGISTERED<br />
					ITEMS
				</div>
				<div class="element">
					<span><?php echo $_home->general_warehouse_items(); ?></span><br />
					WAREHOUSE<br />
					ITEMS (QTY)
				</div>
				<!-- <div class="element">
					<span>$<?php // echo $_home->general_warehouse_value(); ?></span><br />
					VALUE IN WAREHOUSE
				</div>
				<div class="element">
					<span>$<?php // echo $_home->general_warehouse_checked_out(); ?></span><br />
					VALUE CHECKED OUT
				</div> -->
			</div>
		</div>

		<div class="clear" style="height:50px;"></div>
	</div>
</body>
</html>
