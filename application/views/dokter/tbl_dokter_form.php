<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA DOKTER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

		<tr><td width='200'>Kode Dokter <?php echo form_error('kode_dokter') ?></td><td><input type="text" class="form-control" name="kode_dokter" id="kode_dokter" placeholder="Kode Dokter" value="<?php echo $kode_dokter; ?>" /></td></tr>
	    <tr><td width='200'>Nama Dokter <?php echo form_error('nama_dokter') ?></td><td><input type="text" class="form-control" name="nama_dokter" id="nama_dokter" placeholder="Nama Dokter" value="<?php echo $nama_dokter; ?>" /></td></tr>
	    <tr><td width='200'>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td><td>
		<?php echo form_dropdown('jenis_kelamin', array('Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan'), 'jenis_kelamin', array('class' => 'form-control')); ?>
	    </td></tr>
	    <tr><td width='200'>Nomor Induk Dokter <?php echo form_error('nomor_induk_dokter') ?></td><td><input type="text" class="form-control" name="nomor_induk_dokter" id="nomor_induk_dokter" placeholder="Nomor Induk Dokter" value="<?php echo $nomor_induk_dokter; ?>" /></td></tr>
	    <tr><td width='200'>Tempat Lahir <?php echo form_error('tempat_lahir') ?></td><td><input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $tempat_lahir; ?>" /></td></tr>
	    <tr><td width='200'>Tgl Lahir <?php echo form_error('tgl_lahir') ?></td><td><input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tgl Lahir" value="<?php echo $tgl_lahir; ?>" /></td></tr>
	    <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td><input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" /></td></tr>
	    <tr><td width='200'>Bagian Poli <?php echo form_error('id_poli') ?></td><td>
		<?php echo cmb_dinamis('id_poli', 'tbl_poli', 'nama_poli', 'id_poli', $id_poli) ?>
	    </td></tr>
	    <tr><td></td><td> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('dokter') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>