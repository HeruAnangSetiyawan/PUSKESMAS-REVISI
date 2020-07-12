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
        <h2>Tbl_penanganan_operasi List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Pasien</th>
		<th>Nama Operasi</th>
		<th>Biaya</th>
		<th>Ditangani Oleh</th>
		<th>Dibayar</th>
		<th>Kembalian</th>
		<th>Tgl Operasi</th>
		
            </tr><?php
            foreach ($penangananoperasi_data as $penangananoperasi)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $penangananoperasi->nama_pasien ?></td>
		      <td><?php echo $penangananoperasi->nama_operasi ?></td>
		      <td><?php echo $penangananoperasi->biaya ?></td>
		      <td><?php echo $penangananoperasi->ditangani_oleh ?></td>
		      <td><?php echo $penangananoperasi->dibayar ?></td>
		      <td><?php echo $penangananoperasi->kembalian ?></td>
		      <td><?php echo $penangananoperasi->tgl_operasi ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>