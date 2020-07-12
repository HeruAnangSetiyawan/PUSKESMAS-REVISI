<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA OBAT</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

		<tr><td width='200'>Kode Obat <?php echo form_error('kode_obat') ?></td><td><input type="text" class="form-control" name="kode_obat" id="kode_obat" placeholder="Kode Obat" value="<?php echo $kode_obat; ?>" /></td></tr>
	    <tr><td width='200'>Nama Obat <?php echo form_error('nama_obat') ?></td><td><input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="<?php echo $nama_obat; ?>" /></td></tr>
	    <tr><td width='200'>Jenis Obat <?php echo form_error('jenis_obat') ?></td><td><input type="text" class="form-control" name="jenis_obat" id="jenis_obat" placeholder="Jenis Obat" value="<?php echo $jenis_obat; ?>" /></td></tr>
	    <tr><td width='200'>Dosis Aturan Obat <?php echo form_error('dosis_aturan_obat') ?></td><td><input type="text" class="form-control" name="dosis_aturan_obat" id="dosis_aturan_obat" placeholder="Dosis Aturan Obat" value="<?php echo $dosis_aturan_obat; ?>" /></td></tr>
		<tr><td width='200'>Jenis Satuan <?php echo form_error('satuan') ?></td><td><input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" /></td></tr>

	    <tr><td></td><td> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('dataobat') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>