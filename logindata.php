<?php if(isset($_GET['fileready']) && $_GET['fileready'] == true) { ?>
	<p>Pilih FTP tujuan untuk di upload secara bersamaan</p>
	<form class="form-horizontal" action="index.php" method="post">
		<div class="form-group">
		    <label class="col-sm-3 control-label">Upload ke FTP : </label>
		    <div class="col-sm-9">
		    	<?php if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") {		
					if(isset($array_ftp) && $array_ftp != "") { 
						foreach($array_ftp as $ftp => $value) {
							if($ftp && $value['status'] == 1) { ?>
					<div class="checkbox">
						<label><input type="checkbox" name="<?php echo $ftp; ?>" value="1"> <?php echo $ftp; ?> </label>
					</div>	
					<?php }		
					}
					}
				} ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-9">
			    <button type="submit" name="uploadtoftp" value="1" class="btn btn-primary">Kirim Ke FTP</button>
			</div>
		</div>
	</form>
<?php } else { ?>
<div class="alert alert-info">
	File dengan nama yang sama akan otomatis di zip.
</div>
<p>Aplikasi ini tidak diperjual belikan mohon menghargai develeloper untuk tidak menjual belikan aplikasi ini. Untuk pengembangan, kritik dan saran silahkan hubungi saya di <a href="mailto:ask@rizalhans.com">ask@rizalhans.com</a>. Terima kasih.</p>
<div id="draguploader">Broser tidak suppoer html5</div>
<?php $no =0; 
	if(is_dir(savefolder)){
		if($handle = opendir(savefolder))    {
		    while(($file = readdir($handle)) !== false) {
		    	if($file != "." and $file != "..") {
		    		$no++;
		    	}
			}
		    closedir($handle);
		}
	}
?>
<?php if($no > 0) { ?> 
<div class="alert alert-warning text-center"> Anda memiliki <?php echo $no; ?> File diserver. Sebaiknya <b><a href='index.php?bersihkanfile=1'>hapus</a></b> dahulu file yang sudah ada di server.
</div>
<?php } ?>
<script type="text/javascript">
	$("#draguploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : 'action.php?uploaddata=1',
		filters : {
			max_file_size: "<?php echo max_size; ?>",
			mime_types: [
			<?Php foreach ($array_typefile as $ext) {
				if($ext) { ?>
				{extensions : "<?php echo $ext; ?>"},
				<?php }
			} ?>
			]
		},
		init : {
      UploadComplete: function(up, files) {
        location.href='index.php?fileready=true';
      },
		},
	});
</script>
<?php } ?>