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
        <h2>Tbl_operasi List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Operasi</th>
		<th>Biaya</th>
		<th>Tindakan Oleh</th>
		
            </tr><?php
            foreach ($operasi_data as $operasi)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $operasi->nama_operasi ?></td>
		      <td><?php echo $operasi->biaya ?></td>
		      <td><?php echo $operasi->tindakan_oleh ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>