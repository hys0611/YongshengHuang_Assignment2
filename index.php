<?php
// judge the current page
function currentPage() {
	$currentPage = "0";
	if(isset($_SESSION['page'])) {
		$currentPage = $_SESSION['page'];
	}
	return $currentPage;
}

//refresh page
function pageRefresh() {
	echo "<script type='text/javascript'> document.location.href='index.php'</script>";
}

//purify user input
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//judge whether the date contains a number
function hasDigit($date) {
	if(preg_match("/\d/",$date)) {
		return true;
	} else {
		return false;
	}
}

// validate the input of name
function nameValidate($date) {
	if(preg_match("/^[A-Z][a-zA-Z\s]+$/",$date)) {
		return true;
	} else {
		return false;
	}
}

//validate the input of zip and city
function zipValidate($date) {
	if(preg_match("/^[\d]{5}[\s]+[a-zA-Z][a-zA-Z\s]+$/",$date)) {
		return true;
	} else {
		return false;
	}
}

//validate the input of telephone
function teleValidate($date) {
	if(preg_match("/^[\d]{1,}$/",$date)) {
		return true;
	} else {
		return false;
	}
}
?>

<?php /*?> start session <?php */?>
<?php session_start(); ?> 

<?php /*?> Open first page <?php */?>
<?php if(currentPage()=="0"): ?>

<!-- HTML of first page -->
<html>
<head>
<meta charset="UTF-8">
<title>My Wishlist</title>
<script>
//reset the form
function formReset() {
	document.forms["form"]["wish1"].value="";
	document.forms["form"]["wish2"].value="";
	document.forms["form"]["wish3"].value="";
}
</script>
</head>
<body>
<?php 
$wish1 = $wish2 = $wish3 ="";
$p1_error1 = $p1_error2 = $p1_error3 ="";
//validate the form and refresh page
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 //check the input of first wish
	if(empty($_POST["wish1"])) {
		$p1_error1 = "Can not be empty!";
	} else {
		$wish1 = test_input($_POST["wish1"]);
		if(hasDigit($_POST["wish1"])){
		$p1_error1 = "Can not contain any numbers!";
		}
	}
	
	 //check the input of sencond wish
	if(empty($_POST["wish2"])) {
		$p1_error2 = "Can not be empty!";
	} else {
		$wish2 = test_input($_POST["wish2"]);
		if(hasDigit($_POST["wish2"])){
		$p1_error2 = "Can not contain any numbers!";
		}
	}	
	
	 //check the input of third wish
	if(empty($_POST["wish3"])) {
		$p1_error3 = "Can not be empty!";
	} else {
		$wish3 = test_input($_POST["wish3"]);
		if(hasDigit($_POST["wish3"])){
		$p1_error3 = "Can not contain any numbers!";
		}
	}
	
	//save the values of wishes into  global variable sesseion and refresh the page 
	if($p1_error1=="" && $p1_error2=="" && $p1_error3=="" ) {
		$_SESSION['page']=1;
		$_SESSION['w1'] = $_POST["wish1"];
		$_SESSION['w2'] = $_POST["wish2"];
		$_SESSION['w3'] = $_POST["wish3"];
		pageRefresh();
	}
} 

?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form">
<h1 style="padding-left:20px;">My Wishlist</h1>
<ol>
<li>Wish&nbsp;&nbsp;&nbsp;<input type="text" size="30" name="wish1" value="<?php echo $wish1;?>"><span style="color:red;">*</span><span style="color:red;"><?php echo $p1_error1; ?></span></li>
<li>Wish&nbsp;&nbsp;&nbsp;<input type="text" size="30" name="wish2" value="<?php echo $wish2;?>"><span style="color:red;">*</span><span style="color:red;"><?php echo $p1_error2; ?></span></li>
<li>Wish&nbsp;&nbsp;&nbsp;<input type="text" size="30" name="wish3" value="<?php echo $wish3;?>"><span style="color:red;">*</span><span style="color:red;"><?php echo $p1_error3; ?></span></li>
</ol>
<input style="margin-left:22px;" type="button" value="Cancle" onClick="formReset()">
<input type="submit" value="OK">
</form>
</body>
</html>

<?php /*?> Open second page <?php */?>
<?php elseif (currentPage()=="1") : ?>
<!-- HTML of second page -->
<html>
<head>
<meta charset="UTF-8">
<title>Delivery information</title>
<script>
//clear the form
function formReset() {
	document.forms["form"]["name"].value="";
	document.forms["form"]["zip"].value="";
	document.forms["form"]["tele"].value="";
}
</script>
</head>
<body>
<?php 
$name = $zip = $tele ="";
$name_error = $zip_error = $tele_error ="";
//validate the form and refresh page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//check the input of the first and second name
	if(empty($_POST["name"])) {
		$name_error = "Name can not be empty!";
	} else {
		$name = test_input($_POST["name"]);
		if(!nameValidate($_POST["name"])){
		$name_error = "Name must start with a upper case and must cantain letter and space only!";
		}
	}
	
	//check the input of zip and city
	if(empty($_POST["zip"])) {
		$zip_error = "Zip and city can not be empty!";
	} else {
		$zip = test_input($_POST["zip"]);
		if(!zipValidate($_POST["zip"])){
		$zip_error = "Zip should contain 5 numbers and city must cantain letter and space only!";
		}
	}
		
     // check the input of telephone
	if(empty($_POST["tele"])) {
		$tele_error = "Telepgone can not be empty!";
	} else {
		$tele = test_input($_POST["tele"]);
		if(!teleValidate($_POST["tele"])){
		$tele_error = "Telehone must contain numbers only!";
		}
	}
	
	//save the values of user input into  global variable sesseion and refresh the page 
	if($name_error=="" && $zip_error=="" && $tele_error=="" ) {
		$_SESSION['page']=2;
		$_SESSION['name'] = $name;
		$_SESSION['zip'] = $zip;
		$_SESSION['tele'] = $tele;
		pageRefresh();
	}
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form">
<h1 style="padding-left:20px;">Delivery information</h1>
<ol>
<li>Wish&nbsp;&nbsp;&nbsp;<label><?php echo $_SESSION['w1'] ?></label></li>
<li>Wish&nbsp;&nbsp;&nbsp;<label><?php echo $_SESSION['w2'] ?></label></li>
<li>Wish&nbsp;&nbsp;&nbsp;<label><?php echo $_SESSION['w3'] ?></label></li>
</ol>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;First and second name:&nbsp;&nbsp;&nbsp;<input name="name" type="text" size="30" value="<?php echo $name;?>"><span style="color:red;">*</span><span style="color:red;"><?php echo $name_error; ?></span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ZIP and city:&nbsp;&nbsp;&nbsp;<input name="zip" style="margin-left:65px;" type="text" size="30" value="<?php echo $zip;?>"><span style="color:red;">*</span><span style="color:red;"><?php echo $zip_error; ?></span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telephone:&nbsp;&nbsp;&nbsp;<input name="tele" style="margin-left:76px;" type="text" size="30" value="<?php echo $tele;?>"><span style="color:red;">*</span><span style="color:red;"><?php echo $tele_error; ?></span><br>
<br>
<input style="margin-left:22px;" type="button" value="Cancle"  onClick="formReset();">
<input type="submit" value="OK">
</form>
</body>
</html>

<?php /*?> Open the third page <?php */?>
<?php else: ?>
<!-- HTML of third page -->
<html>
<head>
<meta charset="UTF-8">
<title>Wishes overview</title>
</head>
<body>
<form >
<h1 style="padding-left:20px;">Wishes overview</h1>
<ol>
<li>wish:&nbsp;&nbsp;&nbsp;<label><?php echo $_SESSION['w1'] ?></label></li>
<li>wish:&nbsp;&nbsp;&nbsp;<label><?php echo $_SESSION['w2'] ?></label></li>
<li>wish:&nbsp;&nbsp;&nbsp;<label><?php echo $_SESSION['w3'] ?></label></li>
</ol>
<span style="margin-left:20px" >First and second name:</span>&nbsp;&nbsp;&nbsp;<label style="margin-left:10px"><?php echo $_SESSION['name'] ?></label><br>
<span style="margin-left:20px" >ZIP and city:</span>&nbsp;&nbsp;&nbsp;<label style="margin-left:72px"><?php echo $_SESSION['zip'] ?></label><br>
<span style="margin-left:20px" >Telephone:</span>&nbsp;&nbsp;&nbsp;<label style="margin-left:84px"><?php echo $_SESSION['tele'] ?></label><br>
<br>
</form>
</body>
</html>
<?php /*?> destroy the session <?php */?>
<?php session_destroy(); ?>
<?php endif ?>

