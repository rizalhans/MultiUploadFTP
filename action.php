<?php
require_once("config.php");
session_start();
	if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") {
		if(isset($_GET['uploaddata']) && $_GET['uploaddata'] == 1) {
			// upload file standart
			if(isset($_FILES["file"])) {
				// upload ke master
				$destinasi = savefolder."/".$_FILES['file']['name'];
				move_uploaded_file($_FILES["file"]["tmp_name"], $destinasi);
			}
		}
	}
?>