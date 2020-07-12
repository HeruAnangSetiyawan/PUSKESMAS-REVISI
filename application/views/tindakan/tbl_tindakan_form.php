<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA TINDAKAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

		<tr><td width='200'>Kode Tindakan <?php echo form_error('kode_tindakan') ?></td><td><input type="text" class="form-control" name="kode_tindakan" id="kode_tindakan" placeholder="Kode Tindakan" value="<?php echo $kode_tindakan; ?>" /></td></tr>
	    <tr><td width='200'>Nama Tindakan <?php echo form_error('nama_tindakan') ?></td><td><input type="text" class="form-control" name="nama_tindakan" id="nama_tindakan" placeholder="Nama Tindakan" value="<?php echo $nama_tindakan; ?>" /></td></tr>
	    <tr><td width='200'>Tindakan Oleh <?php echo form_error('tindakan_oleh') ?></td><td>
		<?php echo form_dropdown('tindakan_oleh', array('dokter' => 'Dokter', 'petugas' => 'Petugas', 'dokter_dan_petugas' => 'Dokter Dan Petugas'), $tindakan_oleh, array('class' => 'form-control')); ?>
	    </td></tr>
	    <tr><td width='200'>Nama Poli <?php echo form_error('id_poliklinik') ?></td><td>
		<?php echo cmb_dinamis('id_poliklinik', 'tbl_poli', 'nama_poli', 'id_poli', $id_poliklinik) ?>
	    </td></tr>
	    <tr><td></td><td>
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('tindakan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>