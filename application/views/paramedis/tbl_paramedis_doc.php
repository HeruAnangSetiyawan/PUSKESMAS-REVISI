<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Tbl_paramedis List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Paramedis</th>
		<th>Jenis Kelamin</th>
		<th>No Izin Paramedis</th>
		<th>Tempat Lahir</th>
		<th>Tanggal Lahir</th>
		<th>Alamat Tinggal</th>
		<th>Id Poli</th>
		
            </tr><?php
            foreach ($paramedis_data as $paramedis)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $paramedis->nama_paramedis ?></td>
		      <td><?php echo $paramedis->jenis_kelamin ?></td>
		      <td><?php echo $paramedis->no_izin_paramedis ?></td>
		      <td><?php echo $paramedis->tempat_lahir ?></td>
		      <td><?php echo $paramedis->tanggal_lahir ?></td>
		      <td><?php echo $paramedis->alamat_tinggal ?></td>
		      <td><?php echo $paramedis->id_poli ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>