<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PENGADAAN OBAT</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        


		<tr><td width='200'>No Trans <?php echo form_error('no_trans') ?></td><td><input type="text" class="form-control" name="no_trans" id="no_trans" placeholder="Nomor Transaksi" value="<?php echo "B-".date("ymd")."-".noPengadaOtomatis();?>" readonly  /></td></tr>
	    <tr><td width='200'>Supplier <?php echo form_error('supplier') ?></td><td><input type="text" class="form-control" name="supplier" id="supplier" placeholder="Supplier" onkeyup="autosupplier()" required="" /></td></tr>
	    <tr><td width='200'>Nama Obat <?php echo form_error('nama_obat') ?></td><td><input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" onkeyup="autoobat()" required="" /></td></tr>
	    <tr><td width='200'>Kode Obat <?php echo form_error('kode_obat') ?></td><td><input type="text" class="form-control" name="kode_obat" id="kode_obat" placeholder="Kode Obat" required="" readonly /></td></tr>
	    <tr><td width='200'>Jenis Obat <?php echo form_error('jenis_obat') ?></td><td><input type="text" class="form-control" name="jenis_obat" id="jenis_obat" placeholder="Jenis Obat" required="" readonly=""  /></td></tr>
	    <tr><td width='200'>Harga Beli <?php echo form_error('harga_beli') ?></td><td><input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga Beli" onkeyup="count()" required="" /></td></tr>
	    <tr><td width='200'>Jumlah <?php echo form_error('jumlah') ?></td><td><input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah"  onkeyup="count()" /></td></tr>
	    <tr><td width='200'>Satuan <?php echo form_error('satuan') ?></td><td><input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" /></td></tr>
	    <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" /></td></tr>
	    <tr><td width='200'>Total <?php echo form_error('total') ?></td><td><input type="text" class="form-control" name="total" id="total" placeholder="Total" readonly /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_pengadaan" value="<?php echo noPengadaOtomatis() ; ?>" /> 

	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('pengadaanobat') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

<script type="text/javascript">
	function count(){

		var a = parseInt($("#harga_beli").val());
		var b = parseInt($("#jumlah").val());
		c = a * b;

		if (!isNaN(c)) {
			$("#total").val(c);
		}
	}

	function autosupplier(){

		$("#supplier").autocomplete({
			source: "<?php echo base_url() ?>index.php/pengadaanobat/autosupplier",
			minLength: 1
		});
	}

	function autoobat(){
         //autocomplete
        $("#nama_obat").autocomplete({
            source: "<?php echo base_url() ?>index.php/pengadaanobat/autoobat",
            minLength: 1
        });
        autofill();
    }

    function autofill(){

        var nama_obat = $("#nama_obat").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/pengadaanobat/autofill",
            data : "nama_obat="+nama_obat,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#kode_obat').val(obj.kode_obat);
            $('#jenis_obat').val(obj.jenis_obat);
            $('#satuan').val(obj.satuan);

        }); 
    }
</script>