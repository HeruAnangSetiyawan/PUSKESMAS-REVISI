<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA OPERASI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

 		<tr><td width='200'>Kode Operasi <?php echo form_error('kode_operasi') ?></td><td><input type="text" class="form-control" name="kode_operasi" id="kode_operasi" placeholder="Kode Operasi" value="<?php echo $kode_operasi; ?>" /></td></tr>
	    <tr><td width='200'>Nama Operasi <?php echo form_error('nama_operasi') ?></td><td><input type="text" class="form-control" name="nama_operasi" id="nama_operasi" placeholder="Nama Operasi" value="<?php echo $nama_operasi; ?>" /></td></tr>
	    <tr><td width='200'>Biaya <?php echo form_error('biaya') ?></td><td><input type="text" class="form-control" name="biaya" id="biaya" placeholder="Biaya" value="<?php echo $biaya; ?>" /></td></tr>
	    <tr><td width='200'>Tindakan Oleh <?php echo form_error('tindakan_oleh') ?></td><td>
		<?php echo form_dropdown('tindakan_oleh', array('Dokter' => 'Dokter', 'Petugas' => 'Petugas', 'Dokter dan Petugas' => 'Dokter dan Petugas'), $tindakan_oleh, array('class' => 'form-control')); ?>
	    </td></tr>
	    <tr><td></td><td> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('operasi') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>