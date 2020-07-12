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
        <h2>Tbl_tindakan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Jenis Tindakan</th>
		<th>Nama Tindakan</th>
		<th>Tindakan Oleh</th>
		<th>Id Poliklinik</th>
		
            </tr><?php
            foreach ($tindakan_data as $tindakan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tindakan->jenis_tindakan ?></td>
		      <td><?php echo $tindakan->nama_tindakan ?></td>
		      <td><?php echo $tindakan->tindakan_oleh ?></td>
		      <td><?php echo $tindakan->id_poliklinik ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>