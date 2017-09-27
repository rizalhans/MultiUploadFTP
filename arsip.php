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
			<td><?php echo $file; ?></td>
			<td><?php echo pathinfo("arsip/".$_GET['folder']."/".$file,PATHINFO_EXTENSION); ?></td>
			<td><?php echo date ("Y-m-d H:i:s", filemtime("arsip/".$_GET['folder']."/".$file)); ?></td>
			<td><a class="btn btn-primary btn-block" target="_blank" href="<?php echo "arsip/".$_GET['folder']."/".$file; ?>"><span class="glyphicon glyphicon-save"></span> Unduh</a></td>
		</tr>
			<?php }
	    }
		closedir($handle);
	}
}
?>
</table>
<script type="text/javascript">
	$(".datatable").DataTable();
</script>