<?php
echo "bismillah";
define("username","");
define("password","");
define("savefolder", "savefolder");
define("max_size", "20mb");
define("emailnotif", "");

$array_typefile		= array("jpg",
							"JPG",
							"JPEG",
							"jpeg",
							"eps",
							"EPS",
							); 

$array_ftp["Fotolia"]  		= array("ftp_server"	=> "submit.fotolia.com",
								   "username"		=> "",
								   "password"		=> "",
								   "zip"			=> 1,
								   "dirname"		=> "fotolia",
								   "status"			=> 1,
								   "link_cek"		=> "",
								   "lokasi_upload"	=> "",
								   "linkweb"		=> "https://au.fotolia.com/Member",
								   );
$array_ftp["Shutterstock"]  = array("ftp_server"	=> "ftp.shutterstock.com",
								   "username"		=> "",
								   "password"		=> "",
								   "zip"			=> 0,
								    "dirname"		=> "shutterstock",
								   "status"			=> 1,
								   "link_cek"		=> "",
								   "lokasi_upload"	=> "",
								   "linkweb"		=> "https://submit.shutterstock.com/dashboard",
								   ); 
$array_ftp["123rf"]  		= array("ftp_server"	=> "ftp.123rf.com",
								   "username"		=> "",
								   "password"		=> "",
								   "zip"			=> 0,
								   "dirname"		=> "folder123rf",
								   "status"			=> 1,
								   "link_cek"		=> "",
								   "lokasi_upload"	=> "",
								   "linkweb"		=> "https://www.123rf.com/contributor/",
								   ); 
?>