<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PARAMEDIS</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        

	    <tr><td width='200'>Kode Paramedis <?php echo form_error('id_') ?></td><td><input type="text" class="form-control" name="kode_paramedis" id="kode_paramedis" placeholder="Kode Paramedis" value="<?php echo $kode_paramedis; ?>" /></td></tr>
	    <tr><td width='200'>Nama Paramedis <?php echo form_error('nama_paramedis') ?></td><td><input type="text" class="form-control" name="nama_paramedis" id="nama_paramedis" placeholder="Nama Paramedis" value="<?php echo $nama_paramedis; ?>" /></td></tr>
	    <tr><td width='200'>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td><td>
	    	<?php echo form_dropdown('jenis_kelamin', array('Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan'), $jenis_kelamin, array('class' => 'form-control'));; ?>
	    </td></tr>
	    <tr><td width='200'>No Izin Paramedis <?php echo form_error('no_izin_paramedis') ?></td><td><input type="text" class="form-control" name="no_izin_paramedis" id="no_izin_paramedis" placeholder="No Izin Paramedis" value="<?php echo $no_izin_paramedis; ?>" /></td></tr>
	    <tr><td width='200'>Tempat Lahir <?php echo form_error('tempat_lahir') ?></td><td><input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $tempat_lahir; ?>" /></td></tr>
	    <tr><td width='200'>Tanggal Lahir <?php echo form_error('tanggal_lahir') ?></td><td><input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal Lahir" value="<?php echo $tanggal_lahir; ?>" /></td></tr>
	    
        <tr><td width='200'>Alamat Tinggal <?php echo form_error('alamat_tinggal') ?></td><td> <textarea class="form-control" rows="3" name="alamat_tinggal" id="alamat_tinggal" placeholder="Alamat Tinggal"><?php echo $alamat_tinggal; ?></textarea></td></tr>
	    <tr><td width='200'>Poli <?php echo form_error('id_poli') ?></td><td>
	    	<?php echo cmb_dinamis('id_poli','tbl_poli', 'nama_poli', 'id_poli', $id_poli); ?>
	    </td></tr>
	    <tr><td></td><td>
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('paramedis') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>