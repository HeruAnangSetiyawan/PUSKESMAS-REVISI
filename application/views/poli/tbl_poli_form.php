<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA POLI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Poli <?php echo form_error('nama_poli') ?></td><td><input type="text" class="form-control" name="nama_poli" id="nama_poli" placeholder="Nama Poli" value="<?php echo $nama_poli; ?>" /></td></tr>
	    <tr><td width='200'>Ruang Poli <?php echo form_error('ruang_poli') ?></td><td><input type="text" class="form-control" name="ruang_poli" id="ruang_poli" placeholder="Ruang Poli" value="<?php echo $ruang_poli; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_poli" value="<?php echo $id_poli; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('poli') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>