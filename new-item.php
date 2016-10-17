<?php
require 'config.php';
require 'inc/session.php';
require 'inc/items_core.php';
require 'inc/categories_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 2;

$role = $_session->get_user_role();
if($role==4)
	header('Location: items.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		if(!isset($_POST['name']) || !isset($_POST['descrp']) || !isset($_POST['cat']) || !isset($_POST['qty']) || !isset($_POST['price']))
			die('wrong');
		if($_POST['name'] == '' || $_POST['cat'] == '' || $_POST['price'] == '')
			die('wrong');

		$name = $_POST['name'];
		$descrp = $_POST['descrp'];
		$cat = $_POST['cat'];
		$qty = $_POST['qty'];
		$price = $_POST['price'];

		// Fix price
		$price = (string)$price;
		if(strpos($price, '.') === false) {
			$price = $price.'.00';
		}else{
			$pos = strpos($price, '.');
			if($price{$pos+1} == null)
				$price = $price.'00';
			elseif(!isset($price{$pos+2}))
				$price = $price.'0';
			else
				$price = substr($price,0,$pos+3);
		}

		if(substr_count($price, '.') > 1)
			die('wrong');

		if($_items->new_item($name, $descrp, $cat, $qty, $price) == false)
			die('wrong');
		die('1');
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<?php require 'inc/head.php'; ?>
</head>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>

		<div class="wrapper-pad">
			<h2>New Item</h2>
			<div class="center">
				<div class="new-item form">
					<form method="post" action="" name="new-item">
						Item Name:<br />
						<div class="ni-cont">
							<input type="text" name="item-name" class="ni" />
						</div>
						<span class="item-desc-left">Description (400 characters):</span><br />
						<div class="ni-cont">
							<textarea name="item-descrp" class="ni"></textarea>
						</div>
						Category:<br />
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							if($_cats->count_cats() == 0)
								echo '<select name="item-category" disabled><option value="no">You need to create a category first</option></select>';
							else{
								echo '<select name="item-category">';
								$cats = $_cats->get_cats_dropdown();
								while($catt = $cats->fetch_object()) {
									echo "<option value=\"{$catt->id}\">{$catt->name}</option>";
								}
								echo '</select>';
							}
							?>
						</div>
						Quantity:<br />
						<input type="text" name="item-qty" class="ni-small" placeholder="0" />
						<!-- Price of each item:<br /> -->
						<input type="hidden" name="item-price" class="ni-small" value="0.00" placeholder="0.00" />
						<input type="submit" name="item-submit" class="ni btn blue" value="Create new item" />
					</form>
				</div>
			</div>
		</div>

		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
	</div>
</body>
</html>
