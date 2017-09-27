<?php

define('VERSION', '1.0');
require_once("config.php");
session_start();
if(!is_dir("savefolder")) {
	mkdir("savefolder",0777);
}
if(!is_dir("arsip")) {
	mkdir("arsip",0777);
}
$error[] = "";
$pesan_error = "";

if (!class_exists("ZipArchive")) {
    print("fitur ZipArchive, belum di aktifkan, gunakan ssh <b>apt-get install php7.0-zip</b> untuk megaktifkan");
    exit;
}
if(isset($_GET['logout']) && $_GET['logout'] == 1) {
	$_SESSION['logged'] = "";
	$_SESSION['logged'] = NULL;
	header("Location: index.php");
}
if(isset($array_ftp) && $array_ftp != "") { 
	foreach($array_ftp as $ftp => $value) {
		if($ftp) {
			if(!is_dir($value['dirname'])) {
				mkdir($value['dirname'], 0777);
			}
			if(!is_dir("arsip/".$value['dirname'])) {
				mkdir("arsip/".$value['dirname'], 0777);
			}
		}
	}
}
if(isset($_POST['logindata']) && $_POST['logindata'] == 1) {
	if(isset($_POST['username']) && $_POST['username'] == username) {
		$username = true;
	} else {
		$error[]	= "Username Salah";
		$username = false;
	}

	if(isset($_POST['password']) && md5($_POST['password']) == md5(password)) {
		$pswd = true;
	} else {
		$error[]	= "Password Salah";
		$pswd = true;
	}

	if($username == true && $pswd == true) {
		$_SESSION['logged'] = md5(date("Y-m-d H:i:s"));
		header("Location: index.php");
	} else {
		$pesan_error = implode(",",$error);
	}
}
	if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") {	
		if(isset($_GET['bersihkanfile']) && $_GET['bersihkanfile'] == true) {
			if(is_dir(savefolder)) {
				if($handle = opendir(savefolder)) {
					while(($file = readdir($handle)) !== false) {
						if($file != "." and $file != "..") {
							unlink(savefolder."/".$file);	
						}
				    }
				    closedir($handle);
				}
			}
			if(isset($array_ftp) && $array_ftp != "") { 
				foreach($array_ftp as $ftp => $value) {
					if($value['dirname']) {
						if(is_dir($value['dirname'])) {
							if($handle = opendir($value['dirname'])) {
								while(($file = readdir($handle)) !== false) {
									if($file != "." and $file != "..") {
										if(copy($value['dirname']."/".$file, "arsip/".$value['dirname']."/".date("YmdHis")."-".$file)) {
											unlink($value['dirname']."/".$file);
										}
									}
							    }
							    closedir($handle);
							}
						}
					}
				}
			}
			$pesan_error = "Arsipkan file di server berhasil.";
		}
		if(isset($_POST['uploadtoftp']) && $_POST['uploadtoftp'] == 1) {
			if(isset($array_ftp) && $array_ftp != "") { 
				foreach($array_ftp as $ftp => $value) {
					if(isset($_POST[$ftp]) && $_POST[$ftp] ==1) {
						echo "<h1>$ftp</h1>";
						if(is_dir($value['dirname'])) {
						        if($handle = opendir($value['dirname']))
						        {
						        	
						            while(($file = readdir($handle)) !== false)
						            {
										if($file != "." and $file != "..") {
											$src_file 		= $value['dirname']."/".$file;
											$remote_file 	= $file;
											// set up basic connection
											$conn_id = ftp_connect($value['ftp_server'],21);

											// login with username and password
											$login_result = ftp_login($conn_id, $value['username'], $value['password']);

											// upload a file
											if($value['link_cek']) {
												$link = "<a href='$value[link_cek]/$file' target='blank'>Cek File</a>";
											} else {
												$link = "";
											}

											if (ftp_put($conn_id, "$value[lokasi_upload].$remote_file", "$src_file", FTP_BINARY)) {
											 echo "Upload file : $file sukses. $link<br>";
											} else {
											 echo "Upload file : $file GAGAL folder $src_file tidak ditemukan<br>";
											}

											// close the connection
											ftp_close($conn_id);	
										}
						            }
						            closedir($handle);
						        }
						}
					}
				}
			}
			echo "<hr>
			<h4>Terkadang microstock membutuhkan waktu cukup lama untuk membaca file yang kita upload dengan ftp, tergantung dari kualitas file yang diunggah, apakah sudah sesuai standart microstock tersebut. Biasanya saya tinggal mengerjakan hal lain sebelum mengindex file yang telah di upload.</h4>
			<p>Kembali ke <a href='index.php'>Halaman awal</a></p>";
			exit;
		}
		if(isset($_GET['fileready']) && $_GET['fileready'] == true) {
			if(isset($array_ftp) && $array_ftp != "") { 
				foreach($array_ftp as $ftp => $value) {
					if($ftp) {
						if(!is_dir($value['dirname'])) {
							mkdir($value['dirname'], 0777);
						}

						// jika minta di zip di zip dahulu
						if($value['zip'] == true) {

							$nama_folder_zip = array();
							if(is_dir(savefolder))
						    {
						        if($handle = opendir(savefolder))
						        {
						        	
						            while(($file = readdir($handle)) !== false)
						            {
										if($file != "." and $file != "..") {
											$nama_folder_zip[]	= pathinfo(savefolder."/".$file,PATHINFO_FILENAME);	
										}
						            }
						            closedir($handle);
						        }
							}

							$nama_folder_zip = array_unique($nama_folder_zip);
							$zip = new ZipArchive();
							foreach ($nama_folder_zip as $folder) {
								if($folder) {
    								if(is_dir(savefolder))
									    {
									        if($handle = opendir(savefolder))
									        {
									        	
									            while(($file = readdir($handle)) !== false)
									            {
													if(pathinfo(savefolder."/".$file,PATHINFO_FILENAME) == $folder) {
    													$zip->open($value['dirname']."/".$folder.".zip", ZipArchive::CREATE);
							        
												        $download_file = file_get_contents(savefolder."/".$file);
												        $zip->addFromString($file,$download_file);
    													$zip->close();
							        				}
								            }
								            closedir($handle);
								        }
									}
    								
								}
							}
						} else {							
							if(is_dir(savefolder))
						    {
						        if($handle = opendir(savefolder))
						        {
						        	
						            while(($file = readdir($handle)) !== false)
						            {
										if($file != "." and $file != "..") {		
											copy(savefolder."/".$file, $value['dirname']."/".$file);
										}
						            }
						            closedir($handle);
						        }
							}
						}
					}
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
  	<title>Multiupload FTP</title>
  	<script src="library/jquery.min.js"></script>
  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="library/bootstrap/css/bootstrap.min.css">
  	<meta name="author" content="Rizal Hans">
	<!-- Optional theme -->
	<link rel="stylesheet" href="library/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="library/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css?v=4">
	<link rel="stylesheet" href="library/table/css/jquery.dataTables.min.css?v=5">
	<!-- Latest compiled and minified JavaScript -->
	<script src="library/bootstrap/js/bootstrap.min.js"></script>
	<script src="library/plupload/plupload.full.min.js?v=4"></script>
	<script src="library/plupload/jquery.plupload.queue/jquery.plupload.queue.js?v=4"></script>
	<script src="library/table/js/jquery.dataTables.min.js?v=5"></script>
	<script src="library/plupload/i18n/id.js?v=4"></script>
</head>
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-open"></span> MULTIUPLOAD FTP</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">
	    	<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-folder-open"></span> Arsip <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	          <?php if(isset($array_ftp) && $array_ftp != "") {
	          	foreach ($array_ftp as $ftp => $data) {
	          		if($ftp) { ?>
	            <li><a href="<?php echo "index.php?page=arsip&folder=".$data['dirname']; ?>"><?php echo $ftp; ?></a></li>
	            <?php }
	        		}
	            } ?>
	          </ul>
	        </li>
	    	<li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-new-window"></span> Kunjungi <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	          <?php if(isset($array_ftp) && $array_ftp != "") {
	          	foreach ($array_ftp as $ftp => $data) {
	          		if($ftp) { ?>
	            <li><a href="<?php echo $data['linkweb']; ?>" target="_blank"><?php echo $ftp; ?></a></li>
	            <?php }
	        		}
	            } ?>
	            <li class="divider"></li>
	            <li><a href="https://github.com/rizalhans/MultiUploadFTP" target="_blank">GitHub</a></li>
	            <li><a href="http://rizalhans.com" target="_blank">www.rizalhans.com</a></li>
	          </ul>
	        </li>
	    <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") { ?>
	        <li><a href="index.php?logout=1"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
	    <?php } ?>
	      </ul>
	  </div>
	</nav>
<div class="container">
	<?php if($pesan_error != "") { ?>
	<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $pesan_error; ?></div>
	<?php } ?>
	<?php if(empty($_SESSION['logged'])) { 
		include("login.php");
	} else {
		include("logindata.php");
	} ?>
</div>