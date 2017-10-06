<h2><?php echo ucwords($_GET['folder']); ?></h2>
<table class="table table-striped datatable">
	<thead>
		<tr>
			<th>Nama</th>
			<th width="200">Tipe</th>
			<th width="200">Tgl Upload</th>
			<th width="100">Aksi</th>
		</tr>
	</thead>
<?php 
if(is_dir("arsip/".$_GET['folder'])) {
	if($handle = opendir("arsip/".$_GET['folder'])) {
		while(($file = readdir($handle)) !== false) {
			if($file != "." and $file != "..") { ?>
		<tr>
			<td><a data-tgl="<?php echo date ("Y-m-d H:i:s", filemtime("arsip/".$_GET['folder']."/".$file)); ?>" data-type="<?php echo pathinfo("arsip/".$_GET['folder']."/".$file,PATHINFO_EXTENSION); ?>" data-src="<?php echo "arsip/".$_GET['folder']."/".$file; ?>" data-toggle="modal" href="#modal_detail"><?php echo $file; ?></a></td>
			<td><?php echo pathinfo("arsip/".$_GET['folder']."/".$file,PATHINFO_EXTENSION); ?></td>
			<td><?php echo date ("Y-m-d H:i:s", filemtime("arsip/".$_GET['folder']."/".$file)); ?></td>
			<td><div class="btn-group">
			  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			    Action <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
			    <li><a href="<?php echo "arsip/".$_GET['folder']."/".$file; ?>" target="_blank"><span class="glyphicon glyphicon-save"></span> Unduh</a></li>
			    <li><a href="index.php?page=arsip&folder=<?php echo $_GET['folder']; ?>&reupload=<?php echo $file; ?>"><span class="glyphicon glyphicon-open"></span> Upload Ulang</a></li>
			    <li class="divider"></li>
			    <li><a href="index.php?page=arsip&folder=<?php echo $_GET['folder']; ?>&delete=<?php echo $file; ?>"><span class="glyphicon glyphicon-trash"></span> Hapus</a></li>
			  </ul>
			</div>
		</tr>
			<?php }
	    }
		closedir($handle);
	}
}
?>
</table>
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
	$(".datatable").DataTable({
		"order": [ 0, "desc" ]
	});
	$(document).ready(function(e) {
		$('#modal_detail').on('show.bs.modal', function (e) {
		  var button = $(e.relatedTarget) // Button that triggered the modal
		  var srcdata = button.data('src') // Extract info from data-* attributes
		  var typedata = button.data('type'); 
		  var namadata = button.text();
		  var tgldata = button.data('tgl');
		  var modal = $(this);
		  var detaildata = '<h3>'+namadata+'</h3>';
		  if(typedata == 'jpg' || typedata == 'JPG' || typedata == 'jpeg' || typedata == "JPEG") {
		  	detaildata += '<img src="'+srcdata+'" class="img-responsive"><br>';
		  }
		  detaildata += 'Type Data : '+typedata+'<br>';
		  detaildata += 'Tgl Upload : '+tgldata+'<br>';

		  modal.find('#detail_area').html(detaildata);
		})

	})
</script>