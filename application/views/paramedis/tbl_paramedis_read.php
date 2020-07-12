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
        <h2 style="margin-top:0px">Tbl_paramedis Read</h2>
        <table class="table">
	    <tr><td>Nama Paramedis</td><td><?php echo $nama_paramedis; ?></td></tr>
	    <tr><td>Jenis Kelamin</td><td><?php echo $jenis_kelamin; ?></td></tr>
	    <tr><td>No Izin Paramedis</td><td><?php echo $no_izin_paramedis; ?></td></tr>
	    <tr><td>Tempat Lahir</td><td><?php echo $tempat_lahir; ?></td></tr>
	    <tr><td>Tanggal Lahir</td><td><?php echo $tanggal_lahir; ?></td></tr>
	    <tr><td>Alamat Tinggal</td><td><?php echo $alamat_tinggal; ?></td></tr>
	    <tr><td>Id Poli</td><td><?php echo $id_poli; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('paramedis') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>