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
        <h2>Tbl_perbaikan_gizi List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Anak</th>
		<th>Nama Tindakan</th>
		<th>Nama Obat</th>
		<th>Jumlah</th>
		<th>Satuan</th>
		
            </tr><?php
            foreach ($perbaikangizi_data as $perbaikangizi)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $perbaikangizi->nama_anak ?></td>
		      <td><?php echo $perbaikangizi->nama_tindakan ?></td>
		      <td><?php echo $perbaikangizi->nama_obat ?></td>
		      <td><?php echo $perbaikangizi->jumlah ?></td>
		      <td><?php echo $perbaikangizi->satuan ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>