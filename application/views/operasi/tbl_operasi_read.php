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
        <h2 style="margin-top:0px">Tbl_operasi Read</h2>
        <table class="table">
	    <tr><td>Nama Operasi</td><td><?php echo $nama_operasi; ?></td></tr>
	    <tr><td>Biaya</td><td><?php echo $biaya; ?></td></tr>
	    <tr><td>Tindakan Oleh</td><td><?php echo $tindakan_oleh; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('operasi') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>