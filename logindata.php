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
			    <button type="submit" name="uploadtoftp" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-open"></span> Upload Via FTP</button>
			</div>
		</div>
	</form>
<h3>Queue Data files </h3>
<div class="row">
	<div class="col-sm-3">
		<ul class="nav nav-pills nav-stacked">
		<?php $no=0;
		if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") {		
			if(isset($array_ftp) && $array_ftp != "") { 
				foreach($array_ftp as $ftp => $value) {
					if($ftp && $value['status'] == 1) { 
						$no++;?>
		 	<li role="presentation" class="<?php if($no==1) { echo "active"; } ?>"><a href="#<?php echo $value['dirname']; ?>" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $ftp; ?></a></li>
		 			<?php }		
				}
			}
		} ?>
		</ul>
	</div>
	<div class="col-sm-9">
		<div class="tab-content">
		<?php if(isset($_SESSION['logged']) && $_SESSION['logged'] != "") {		
				if(isset($array_ftp) && $array_ftp != "") { 
					$no=0;
					foreach($array_ftp as $ftp => $value) {
						if($ftp && $value['status'] == 1) { 
							$no++; ?>
			<div role="tabpanel" class="tab-pane <?php if($no==1) { echo "active"; } ?>" id="<?php echo $value['dirname']; ?>">
				<h4 class="text-center"><?php echo $ftp; ?></h4>
				<table class="table table-striped datatable" style="width:100%">
					<thead>
						<tr>
							<th>Nama</th>
							<th width="150">Tipe</th>
							<th width="150">Tgl Upload</th>
							<th width="100">Aksi</th>
						</tr>
					</thead>
				<?php 
				if(is_dir($value['dirname'])) {
					if($handle = opendir($value['dirname'])) {
						while(($file = readdir($handle)) !== false) {
							if($file != "." and $file != "..") { ?>
						<tr>
							<td><a data-tgl="<?php echo date ("Y-m-d H:i:s", filemtime($value['dirname']."/".$file)); ?>" data-type="<?php echo pathinfo($value['dirname']."/".$file,PATHINFO_EXTENSION); ?>" data-src="<?php echo $value['dirname']."/".$file; ?>" data-toggle="modal" href="#modal_detail"><?php echo $file; ?></a></td>
							<td><?php echo pathinfo($value['dirname']."/".$file,PATHINFO_EXTENSION); ?></td>
							<td><?php echo date ("Y-m-d H:i:s", filemtime($value['dirname']."/".$file)); ?></td>
							<td><a class="btn btn-primary btn-block" target="_blank" href="<?php echo$value['dirname']."/".$file; ?>"><span class="glyphicon glyphicon-save"></span> Unduh</a></td>
						</tr>
							<?php }
					    }
						closedir($handle);
					}
				}
				?>
				</table>
			</div>
				<?php }		
					}
				}
			} ?>
			<script type="text/javascript">
				$(".datatable").DataTable({
			        "order": [ 0, "desc" ]
			    });
			</script>
		</div>
	</div>
</div>
<div id="modal_detail" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detail File</h4>
      </div>
      <div class="modal-body">
        <div id="detail_area"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	$(document).ready(function(e) {
		$('#modal_detail').on('show.bs.modal', function (e) {
		  var button = $(e.relatedTarget) // Button that triggered the modal
		  var srcdata = button.data('src') // Extract info from data-* attributes
		  var typedata = button.data('type'); 
		  var namadata = button.text();
		  var tgldata = button.data('tgl');
		  var modal = $(this);
		  var detaildata = '<h2>'+namadata+'</h2>';
		  if(typedata == 'jpg' || typedata == 'JPG' || typedata == 'jpeg' || typedata == "JPEG") {
		  	detaildata += '<img src="'+srcdata+'" class="img-responsive"><br>';
		  }
		  detaildata += 'Type Data : '+typedata+'<br>';
		  detaildata += 'Tgl Upload : '+tgldata+'<br>';

		  modal.find('#detail_area').html(detaildata);
		})

	})
</script>
<?php } else { ?>
<?php if(isset($_GET['page']) && $_GET['page'] != "" && isset($_GET['folder']) && $_GET['folder'] != "") { 
	if(is_dir($_GET['folder']) && is_file($_GET['page'].".php")) {
		include($_GET['page'].".php");
	} else {
		include("error404.php");
	}
} else { ?>
<div class="alert alert-info">
	File dengan nama yang sama akan otomatis di zip.
</div>
<p>Aplikasi ini tidak diperjual belikan mohon menghargai developer untuk tidak menjual belikan aplikasi ini. Untuk pengembangan, kritik dan saran silahkan hubungi saya di <a href="mailto:ask@rizalhans.com">ask@rizalhans.com</a>. Terima kasih.</p>
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
<div class="alert alert-warning text-center"> Anda memiliki <?php echo $no; ?> File diserver. Sebaiknya <b><a href='index.php?bersihkanfile=1'>Arsipkan</a></b> dahulu file yang sudah ada di server atau <a href="index.php?fileready=true"><b>Kirim Ulang</b></a>
</div>
<?php } ?>
<div id="draguploader">Broser tidak suppoer html5</div>
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
<?php } ?>