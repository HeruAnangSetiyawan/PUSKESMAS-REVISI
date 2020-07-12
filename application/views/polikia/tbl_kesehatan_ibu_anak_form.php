<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA KESEHATAN IBU ANAK</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post"  id="form1" name="form1">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Pasien <?php echo form_error('nama_pasien') ?></td><td><input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" value="<?php echo $pendaftaran['nama_pasien'] ?>" onkeyup="pasienauto()" /></td></tr>
          <tr><td width='200'>No BPJS <?php echo form_error('no_bpjs') ?></td><td><input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="No BPJS" /></td></tr>
        <tr><td width='200'>Status Pasien <?php echo form_error('status_pasien') ?></td><td>
  <select id="status_pasien" name="status_pasien" onchange="tampilkan()" class="form-control">
    <option value='' disabled="disabled" selected/>Pilih</option>
    <option value="BPJS">BPJS</option>
    <option value="Umum">Umum</option>
  </select></tr>
	    <tr><td width='200'>Nama Tindakan <?php echo form_error('nama_operasi') ?></td><td><input type="text" class="form-control" value="<?php echo $nama_operasi ?>" name="nama_operasi" id="nama_operasi" placeholder="Nama Tindakan" onkeyup="tindakanauto()"  /></td></tr>
	    <tr><td width='200'>Biaya <?php echo form_error('biaya') ?></td><td><input type="text" class="form-control" name="biaya" id="biaya" value="<?php echo $biaya ?>" placeholder="Biaya" readonly onkeyup="hitung()" /></td></tr>
	    <tr><td width='200'>Ditangani Oleh <?php echo form_error('ditangani_oleh') ?></td><td>
		<?php echo form_dropdown('ditangani_oleh', array('Dokter' => 'Dokter', 'Petugas' => 'Petugas', 'Dokter dan Petugas' => 'Dokter dan Petugas'), $ditangani_oleh, array('class' => 'form-control')); ?>
	    </td></tr>
	    <tr><td width='200'>Dibayar <?php echo form_error('dibayar') ?></td><td><input type="text" class="form-control" name="dibayar" id="dibayar" value="<?php echo $dibayar ?>" placeholder="Dibayar" onkeyup="hitung()" /></td></tr>
	    <tr><td width='200'>Kembalian <?php echo form_error('kembalian') ?></td><td><input type="text" class="form-control" name="kembalian" id="kembalian" value="<?php echo $kembalian
         ?>" placeholder="Kembalian" readonly="" /></td></tr>
                 <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" readonly="" /></td></tr>
	    <tr><td width='200'>Tgl Tindakan <?php echo form_error('tgl_tindakan') ?></td><td><input type="date" class="form-control" name="tgl_tindakan" value="<?php echo date('Y-m-d') ?>" id="tgl_tindakan" placeholder="Tgl Tindakan" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_kia" value="<?php echo $id_kia; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('polikia') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

<script type="text/javascript">
	
	function hitung(){

		var a = parseInt($("#biaya").val());
		var b = parseInt($("#dibayar").val());
		c = b - a;

		if (!isNaN(c) && (c) >= 0) {
			$("#kembalian").val(c);
		}
	}

	function pasienauto(){
         //autocomplete
        $("#nama_pasien").autocomplete({
            source: "<?php echo base_url() ?>index.php/polikia/pasienauto",
            minLength: 1
        });

        autoisi();
    }

    function tindakanauto(){
    var id_user=document.getElementById("form1").status_pasien.value;
     
    if (id_user=="BPJS")
    {
         //autocomplete
        $("#nama_operasi").autocomplete({
            source: "<?php echo base_url() ?>index.php/polikia/tindakanauto",
            minLength: 1
        });
        document.getElementById("biaya").value = "0";
        document.getElementById("dibayar").readOnly = true;
    } else if (id_user=="Umum")
    {
         autofill();
        $("#nama_operasi").autocomplete({
            source: "<?php echo base_url() ?>index.php/penangananoperasi/autooperasi",
            minLength: 1
        });
    }
    }

    function autoisi(){

        var nama_pasien = $("#nama_pasien").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/polikia/autoisi",
            data : "nama_pasien="+nama_pasien,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#no_bpjs').val(obj.no_bpjs);
        }); 
    }


    function autofill(){

        var nama_operasi = $("#nama_operasi").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/penangananoperasi/autofill",
            data : "nama_operasi="+nama_operasi,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#biaya').val(obj.biaya);
        }); 
    }


function tampilkan(){
  var id_user=document.getElementById("form1").status_pasien.value;
  if (id_user=="BPJS")
    {
        
        document.getElementById("no_bpjs").readOnly = false;
        document.getElementById("biaya").readOnly = true;
        document.getElementById("biaya").value = "0";
        document.getElementById("dibayar").readOnly = true;
        document.getElementById("dibayar").value = "0";
        document.getElementById("kembalian").readOnly = true;
        document.getElementById("kembalian").value = "0";
        document.getElementById("keterangan").readOnly = true;
        document.getElementById("keterangan").value = "Gratis";
        document.getElementById("autofill").disabled = true;
    }
  else if (id_user=="Umum")
    {
       document.getElementById("biaya").readonly = false;
        document.getElementById("dibayar").readOnly = false;
        document.getElementById("dibayar").value = "";
        document.getElementById("keterangan").readOnly = true;
        document.getElementById("keterangan").value = "Berbayar";
        document.getElementById("no_bpjs").readOnly = true;
        autofill();


    }
}
</script>