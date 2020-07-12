<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PASIEN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" id="form1" name="form1">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>No Ktp <?php echo form_error('no_ktp') ?></td><td><input type="text" class="form-control" name="no_ktp" id="no_ktp" placeholder="No Ktp" value="<?php echo $no_ktp; ?>" /></td></tr>
	    <tr><td width='200'>No Bpjs <?php echo form_error('no_bpjs') ?></td><td><input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="No Bpjs" value="<?php echo $no_bpjs; ?>" /></td></tr>
	    <tr><td width='200'>No Rekamedis <?php echo form_error('no_rekamedis') ?></td><td><input type="text" class="form-control" name="no_rekamedis" id="no_rekamedis" placeholder="No Rekamedis" value="<?php echo $no_rekamedis; ?>" readonly /></td></tr>
	    <tr><td width='200'>Nama Pasien <?php echo form_error('nama_pasien') ?></td><td><input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" value="<?php echo $nama_pasien; ?>" /></td></tr>
	     <tr><td width='200'>Status Pasien <?php echo form_error('status_pasien') ?></td><td>
    <select id="status_pasien" name="status_pasien" onchange="tampilkan()" class="form-control">
        <option value="" disabled="disabled" selected/>Pilih</option>
        <option value="BPJS">BPJS</option>
        <option value="Umum">Umum</option>
  </select></tr>
	    <tr><td width='200'>Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></td><td>
		<?php echo form_dropdown('jenis_kelamin', array('L' => 'Laki-Laki', 'P' => 'Perempuan'), $jenis_kelamin, array('class' => 'form-control')); ?>
	    </td></tr>
	    <tr><td width='200'>Tempat Lahir <?php echo form_error('tempat_lahir') ?></td><td><input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $tempat_lahir; ?>" /></td></tr>
	    <tr><td width='200'>Tanggal Lahir <?php echo form_error('tanggal_lahir') ?></td><td><input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal Lahir" selected="<?php echo $tanggal_lahir ?>" /></td></tr>
	    
        <tr><td width='200'>Alamat <?php echo form_error('alamat') ?></td><td> <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea></td></tr>
	    <tr><td></td><td> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('pasien') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>


<script type="text/javascript">
    
    function tampilkan(){
  var id_user=document.getElementById("form1").status_pasien.value;
  if (id_user=="BPJS")
    {
        document.getElementById("no_bpjs").readOnly = false;
        document.getElementById("no_bpjs").value = "";

        
    }
  else if (id_user=="Umum")
    {
       document.getElementById("no_bpjs").readOnly = true;
       document.getElementById("no_bpjs").value = "-";

    }
    
}
   
</script>
