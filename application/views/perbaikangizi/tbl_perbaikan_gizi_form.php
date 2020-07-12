<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PERBAIKAN GIZI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Anak <?php echo form_error('nama_anak') ?></td><td><input type="text" class="form-control" name="nama_anak" id="nama_anak" placeholder="Nama Anak" value="<?php echo $nama_anak ?>" onkeyup="anakauto()" /></td></tr>
	    <tr><td width='200'>Nama Tindakan <?php echo form_error('nama_tindakan') ?></td><td><input type="text" class="form-control" name="nama_tindakan" id="nama_tindakan" value="<?php echo $nama_tindakan ?>" placeholder="Nama Tindakan" onkeyup="tindakanauto()" /></td></tr>
	    <tr><td width='200'>Nama Obat <?php echo form_error('nama_obat') ?></td><td><input type="text" class="form-control" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat ?>" placeholder="Nama Obat" onkeyup="obatauto()" /></td></tr>
	    <tr><td width='200'>Jumlah <?php echo form_error('jumlah') ?></td><td><input type="text" class="form-control" name="jumlah" value="<?php echo $jumlah?>" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" /></td></tr>
	    <tr><td width='200'>Satuan <?php echo form_error('satuan') ?></td><td><input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan ?>"  /></td></tr>
	    <tr><td width='200'>Tanggal <?php echo form_error('tanggal') ?></td><td><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_gizi" value="<?php echo $id_gizi; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('perbaikangizi') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>

<script type="text/javascript">
	
	function anakauto(){
         //autocomplete
        $("#nama_anak").autocomplete({
            source: "<?php echo base_url() ?>index.php/perbaikangizi/anakauto",
            minLength: 1
        });
    }

    function tindakanauto(){
         //autocomplete
        $("#nama_tindakan").autocomplete({
            source: "<?php echo base_url() ?>index.php/perbaikangizi/tindakanauto",
            minLength: 1
        });
    }

     function obatauto(){
         //autocomplete
        $("#nama_obat").autocomplete({
            source: "<?php echo base_url() ?>index.php/perbaikangizi/obatauto",
            minLength: 1
        });
        autofill();
    }
    function autofill(){

        var nama_obat = $("#nama_obat").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/perbaikangizi/autofill",
            data : "nama_obat="+nama_obat,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#satuan').val(obj.satuan);
        }); 
    }
</script>