<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Tbl_perbaikan_gizi Read</h2>
        <table class="table">
	    <tr><td>Nama Anak</td><td><?php echo $nama_anak; ?></td></tr>
	    <tr><td>Nama Tindakan</td><td><?php echo $nama_tindakan; ?></td></tr>
	    <tr><td>Nama Obat</td><td><?php echo $nama_obat; ?></td></tr>
	    <tr><td>Jumlah</td><td><?php echo $jumlah; ?></td></tr>
	    <tr><td>Satuan</td><td><?php echo $satuan; ?></td></tr>
	    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('perbaikangizi') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>