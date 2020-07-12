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
        <h2>Daftar Dokter</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Dokter</th>
		<th>Jenis Kelamin</th>
		<th>Nomor Induk Dokter</th>
		<th>Tempat Lahir</th>
		<th>Tgl Lahir</th>
		<th>Alamat</th>
		<th>Id Poli</th>
		
            </tr><?php
            foreach ($dokter_data as $dokter)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $dokter->nama_dokter ?></td>
		      <td><?php echo $dokter->jenis_kelamin ?></td>
		      <td><?php echo $dokter->nomor_induk_dokter ?></td>
		      <td><?php echo $dokter->tempat_lahir ?></td>
		      <td><?php echo $dokter->tgl_lahir ?></td>
		      <td><?php echo $dokter->alamat ?></td>
		      <td><?php echo $dokter->id_poli ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>