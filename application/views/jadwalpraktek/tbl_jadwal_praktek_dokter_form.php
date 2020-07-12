<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA JADWAL PRAKTEK DOKTER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Dokter <?php echo form_error('kode_dokter') ?></td><td>
	    <input type="text" class="form-control" name="kode_dokter" id="kode_dokter" placeholder="Nama Dokter" value="<?php echo $kode_dokter; ?>" /></td></tr>
	    <tr><td width='200'>Hari <?php echo form_error('hari') ?></td><td>
		<?php echo form_dropdown('hari', array('Senin' => 'Senin', 'Selasa' => 'Selasa', 'Rabu' => 'Rabu', 'Kamis' => 'Kamis', 'Jumat' => 'Jumat', 'Sabtu' => 'Sabtu'), $hari, array('class' => 'form-control')); ?>
	    </td></tr>
	    <tr><td width='200'>Jam Mulai <?php echo form_error('jam_mulai') ?></td><td><input type="text" class="form-control" name="jam_mulai" id="jam_mulai" placeholder="Jam Mulai" value="<?php echo $jam_mulai; ?>" /></td></tr>
	    <tr><td width='200'>Jam Selesai <?php echo form_error('jam_selesai') ?></td><td><input type="text" class="form-control" name="jam_selesai" id="jam_selesai" placeholder="Jam Selesai" value="<?php echo $jam_selesai; ?>" /></td></tr>
	    <tr><td width='200'>Poli <?php echo form_error('id_poli') ?></td><td>
	    <?php echo cmb_dinamis('id_poli', 'tbl_poli', 'nama_poli', 'id_poli', $id_poli) ?></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('jadwalpraktek') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>

<script type="text/javascript">
    $(function() {
        //autocomplete
        $("#kode_dokter").autocomplete({
            source: "<?php echo base_url()?>/index.php/jadwalpraktek/autocomplete",
            minLength: 1
        });				
    });
</script>