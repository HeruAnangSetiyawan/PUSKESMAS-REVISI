<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PENGELUARAN OBAT</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>No Terima Obat <?php echo form_error('no_terima_obat') ?></td><td><input type="text" class="form-control" name="no_terima_obat" id="no_terima_obat" placeholder="No Terima Obat" value="<?php echo "S-".date('ymd')."-".noPengeluaranOtomatis(); ?>" readonly /></td></tr>
	    <tr><td width='200'>Nama Pasien <?php echo form_error('nama_pasien') ?></td><td><input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" onkeyup="autoPasien()" /></td></tr>
	    <tr><td width='200'>Nama Obat <?php echo form_error('nama_obat') ?></td><td><input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" onkeyup="obatAuto()" /></td></tr>
	    <tr><td width='200'>Kode Obat <?php echo form_error('kode_obat') ?></td><td><input type="text" class="form-control" name="kode_obat" id="kode_obat" placeholder="Kode Obat" readonly="" /></td></tr>
	    <tr><td width='200'>Jenis Obat <?php echo form_error('jenis_obat') ?></td><td><input type="text" class="form-control" name="jenis_obat" id="jenis_obat" placeholder="Jenis Obat" readonly=""  /></td></tr>
	    <tr><td width='200'>Dosis Aturan Obat <?php echo form_error('dosis_aturan_obat') ?></td><td><input type="text" class="form-control" name="dosis_aturan_obat" id="dosis_aturan_obat" placeholder="Dosis Aturan Obat" readonly="" /></td></tr>
	    <tr><td width='200'>Jumlah <?php echo form_error('jumlah') ?></td><td><input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" /></td></tr>
        <tr><td width='200'>Satuan <?php echo form_error('satuan') ?></td><td><input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" /></td></tr>
	    <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_pengeluaran" value="<?php echo noPengeluaranOtomatis(); ?>" />
        <tr><td></td><td><input type="hidden" name="tgl_serah_obat" id="tgl_serah_obat" value="<?php echo date('d-m-Y'); ?>" />

	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('pengeluaranobat') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

<script type="text/javascript">
	function autoPasien(){

		$("#nama_pasien").autocomplete({
			source: "<?php echo base_url() ?>index.php/pengeluaranobat/autopasien",
			minLength: 1
		});
	}

	function obatAuto(){
         //autocomplete
        $("#nama_obat").autocomplete({
            source: "<?php echo base_url() ?>index.php/pengeluaranobat/obatauto",
            minLength: 1
        });
        autofill();
    }

    function autofill(){

        var nama_obat = $("#nama_obat").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/pengeluaranobat/autofill",
            data : "nama_obat="+nama_obat,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#kode_obat').val(obj.kode_obat);
            $('#jenis_obat').val(obj.jenis_obat);
            $("#dosis_aturan_obat").val(obj.dosis_aturan_obat);
            $("#satuan").val(obj.satuan);
        }); 
    }
</script>