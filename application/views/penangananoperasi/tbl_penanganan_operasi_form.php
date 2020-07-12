<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PENANGANAN OPERASI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" id="form1" name="form1">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Pasien <?php echo form_error('nama_pasien') ?></td><td><input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" onkeyup="autopasien()" /></td></tr>
         <tr><td width='200'>No BPJS <?php echo form_error('no_bpjs') ?></td><td><input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="No BPJS" /></td></tr>
        <tr><td width='200'>Status Pasien<?php echo form_error('status_pasien') ?></td><td>
  <select id="status_pasien" name="status_pasien" onchange="tampilkan()" class="form-control">
    <option value='' disabled="disabled" selected/>Pilih</option>
    <option value="BPJS">BPJS</option>
    <option value="Umum">Umum</option>
  </select></tr>
	    <tr><td width='200'>Nama Operasi <?php echo form_error('nama_operasi') ?></td><td><input type="text" class="form-control" name="nama_operasi" id="nama_operasi" placeholder="Nama Operasi" onkeyup="autooperasi()" /></td></tr>
	    <tr><td width='200'>Biaya <?php echo form_error('biaya') ?></td><td><input type="text" class="form-control" name="biaya" id="biaya" placeholder="Biaya" readonly onkeyup="hitung()" /></td></tr>
	    <tr><td width='200'>Ditangani Oleh <?php echo form_error('ditangani_oleh') ?></td><td>
        <?php echo form_dropdown('ditangani_oleh', array('Dokter' => 'Dokter', 'Petugas' => 'Petugas', 'Dokter dan Petugas' => 'Dokter dan Petugas'), $ditangani_oleh, array('class' => 'form-control')); ?>
        </td></tr>
	    <tr><td width='200'>Dibayar <?php echo form_error('dibayar') ?></td><td><input type="text" class="form-control" name="dibayar" id="dibayar" placeholder="Dibayar" onkeyup="hitung()" /></td></tr>
	    <tr><td width='200'>Kembalian <?php echo form_error('kembalian') ?></td><td><input type="text" class="form-control" name="kembalian" id="kembalian" placeholder="Kembalian" readonly="" /></td></tr>
        <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" readonly="" /></td></tr>
	    <tr><td width='200'>Tgl Operasi <?php echo form_error('tgl_operasi') ?></td><td><input type="date" class="form-control" name="tgl_operasi" id="tgl_operasi" placeholder="Tgl Operasi" value="<?php echo date('Y-m-d') ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_penanganan" value="<?php echo $id_penanganan; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('penangananoperasi') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
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

	function autopasien(){
         //autocomplete
        $("#nama_pasien").autocomplete({
            source: "<?php echo base_url() ?>index.php/penangananoperasi/autopasien",
            minLength: 1
        });

        autoisi();
    }

    function autooperasi(){
    var id_user=document.getElementById("form1").status_pasien.value;
    if (id_user=="BPJS")
    {
         //autocomplete
        $("#nama_operasi").autocomplete({
            source: "<?php echo base_url() ?>index.php/penangananoperasi/autooperasi",
            minLength: 1
        });
        document.getElementById("biaya").value = "0";
        document.getElementById("dibayar").readOnly = true;
    } else if (id_user=="Umum")
    {
        $("#nama_operasi").autocomplete({
            source: "<?php echo base_url() ?>index.php/penangananoperasi/autooperasi",
            minLength: 1
        });
        autofill();
    }

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

     function autoisi(){

        var nama_pasien = $("#nama_pasien").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/penangananoperasi/autoisi",
            data : "nama_pasien="+nama_pasien,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#no_bpjs').val(obj.no_bpjs);
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
        autopasien();

    }
  else if (id_user=="Umum")
    {
       document.getElementById("biaya").readonly = false;
        document.getElementById("dibayar").readOnly = false;
        document.getElementById("dibayar").value = "";
        document.getElementById("keterangan").readOnly = true;
        document.getElementById("keterangan").value = "Berbayar";
        document.getElementById("no_bpjs").readOnly = true;
        document.getElementById("no_bpjs").value = "-";

        autofill();


    }
}
</script>