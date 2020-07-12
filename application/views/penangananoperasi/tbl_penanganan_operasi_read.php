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
        <h2 style="margin-top:0px">Tbl_penanganan_operasi Read</h2>
        <table class="table">
	    <tr><td>Nama Pasien</td><td><?php echo $nama_pasien; ?></td></tr>
	    <tr><td>Nama Operasi</td><td><?php echo $nama_operasi; ?></td></tr>
	    <tr><td>Biaya</td><td><?php echo $biaya; ?></td></tr>
	    <tr><td>Ditangani Oleh</td><td><?php echo $ditangani_oleh; ?></td></tr>
	    <tr><td>Dibayar</td><td><?php echo $dibayar; ?></td></tr>
	    <tr><td>Kembalian</td><td><?php echo $kembalian; ?></td></tr>
	    <tr><td>Tgl Operasi</td><td><?php echo $tgl_operasi; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('penangananoperasi') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>