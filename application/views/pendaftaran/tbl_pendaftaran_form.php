<div class="content-wrapper">
    
    <section class="content">

    <div class="col-md-6">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">DATA PENDAFTARAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" id="form1" name="form1">
            
<table class='table table-bordered'>        

        <tr><td width='200'>No Rawat <?php echo form_error('no_rawat') ?></td><td><input type="text" class="form-control" name="no_rawat" id="no_rawat" value="<?php echo date('Y-m-d-').noRegistrasiotomatis(); ?>" readonly /></td></tr>
        <tr><td width='200'>Dokter Penanggung Jawab <?php echo form_error('kode_dokter_penanggung_jawab') ?></td><td><input type="text" class="form-control" onkeyup="auto_nama_dokter()" name="kode_dokter_penanggung_jawab" id="kode_dokter_penanggung_jawab" placeholder="Dokter Penanggung Jawab" value="<?php echo $kode_dokter_penanggung_jawab; ?>"/></td></tr>
        <tr><td width='200'>Poli Tujuan <?php echo form_error('id_poli') ?></td><td>
        <?php echo cmb_dinamis('id_poli', 'tbl_poli', 'nama_poli', 'id_poli', $id_poli) ?>
        </td></tr>
        <tr><td></td><td><input type="hidden" class="form-control" name="tanggal_daftar" id="tanggal_daftar" placeholder="Tanggal Daftar" value="<?php echo date('Y-m-d'); ?>" /> 
        <input type="hidden" class="form-control" name="no_registrasi" id="no_registrasi" placeholder="No Registrasi" value="<?php echo noRegistrasiotomatis(); ?>" readonly /> 
        <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
        <a href="<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
    </table>       </div>
    </div>

    <div class="col-md-6">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">DATA PASIEN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        

        <tr><td width='200'>No Rekamedis <?php echo form_error('no_rekamedis') ?></td><td><input type="text" class="form-control" name="no_rekamedis" id="no_rekamedis" placeholder="Masukkan No Rekamedis" value="<?php echo $no_rekamedis; ?>" onkeyup="autocomplete_norekmedis()" /></td></tr>
        <tr><td width='200'>Nama Pasien <?php echo form_error('nama_pasien') ?></td><td><input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien"  /></td></tr>
        <tr><td width='200'>Tanggal Lahir <?php echo form_error('tanggal_lahir') ?></td><td><input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal Lahir"/></td></tr>
        <tr><td width='200'>Nama Penanggung Jawab <?php echo form_error('nama_penanggung_jawab') ?></td><td><input type="text" class="form-control" name="nama_penanggung_jawab" id="nama_penanggung_jawab" placeholder="Nama Penanggung Jawab" value="<?php echo $nama_penanggung_jawab; ?>" /></td></tr>
        <tr><td width='200'>Hubungan Dengan Penanggung Jawab <?php echo form_error('hubungan_dengan_penanggung_jawab') ?></td><td>
        <?php echo form_dropdown('hubungan_dengan_penanggung_jawab', array('Saudara Kandung' => 'Saudara Kandung', 'Orang Tua' => 'Orang Tua'), $hubungan_dengan_penanggung_jawab, array('class' => 'form-control')); ?>
        </td></tr>
        <tr><td width='200'>Alamat Penanggung Jawab <?php echo form_error('alamat_penanggung_jawab') ?></td><td> <textarea class="form-control" rows="3" name="alamat_penanggung_jawab" id="alamat_penanggung_jawab" placeholder="Alamat Penanggung Jawab" value="<?php echo $alamat_penanggung_jawab ?>"></textarea></td></tr>
         <tr><td width='200'>Status Pasien <?php echo form_error('status_pasien') ?></td><td>
    <select id="status_pasien" name="status_pasien" onchange="tampilkan()" class="form-control">
        <option value="" disabled="disabled" selected/>Pilih</option>
        <option value="BPJS">BPJS</option>
        <option value="Umum">Umum</option>
  </select></tr>
         <tr><td width='200'>No BPJS <?php echo form_error('no_bpjs') ?></td><td><input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="No BPJS"/></td></tr>

    </table></form>        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>



<script type="text/javascript">
    
    function auto_nama_dokter(){
         //autocomplete
        $("#kode_dokter_penanggung_jawab").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocompleteDokter",
            minLength: 1
        });
    }
    
   
    function autocomplete_norekmedis(){
        //autocomplete
        $("#no_rekamedis").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autonorekamedis",
            minLength: 1
        });
        autofill();
    }

    function autofill(){

        var no_rekamedis = $("#no_rekamedis").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/pendaftaran/autofill",
            data : "no_rekamedis="+no_rekamedis,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#nama_pasien').val(obj.nama_pasien);
            $('#tanggal_lahir').val(obj.tanggal_lahir);
            $('#no_bpjs').val(obj.no_bpjs);
        }); 
    }

    function tampilkan(){
  var id_user=document.getElementById("form1").status_pasien.value;
  if (id_user=="BPJS")
    {
        document.getElementById("no_bpjs").readOnly = false;
        autocomplete_norekmedis();
        
    }
  else if (id_user=="Umum")
    {
       document.getElementById("no_bpjs").readOnly = true;
       document.getElementById("no_bpjs").value = "-";



    }
    else if (id_user=="")
    {


    }
}
   
</script>
