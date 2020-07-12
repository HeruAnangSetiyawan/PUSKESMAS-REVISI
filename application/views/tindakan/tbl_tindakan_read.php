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
        <h2 style="margin-top:0px">Tbl_tindakan Read</h2>
        <table class="table">
	    <tr><td>Jenis Tindakan</td><td><?php echo $jenis_tindakan; ?></td></tr>
	    <tr><td>Nama Tindakan</td><td><?php echo $nama_tindakan; ?></td></tr>
	    <tr><td>Tindakan Oleh</td><td><?php echo $tindakan_oleh; ?></td></tr>
	    <tr><td>Id Poliklinik</td><td><?php echo $id_poliklinik; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('tindakan') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>