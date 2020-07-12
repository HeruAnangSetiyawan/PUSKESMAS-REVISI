<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">BIODATA PASIEN</h3>
                    </div>
        
        <div class="box-body">
            
        
   
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr><td width="200">No Rawat</td><td><?php echo $pendaftaran['no_rawat'] ?></td></tr>
            <tr><td>No Rekamedis</td><td><?php echo $pendaftaran['no_rekamedis'] ?></td></tr>
            <tr><td>Nama Pasien</td><td><?php echo $pendaftaran['nama_pasien'] ?></td></tr>
        </table>
        
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaltindakan">Input Tindakan</button>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalresep">Input Resep Obat</button>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalrujukan">Input Rujukan</button>


        <?php echo anchor('pendaftaran/cetakrekamedis/'.$no_rawat, 'Cetak Rekam Medis', "class='btn btn-danger' target='new'"); ?>
        <?php echo anchor('pendaftaran/cetakresepobat/'.$no_rawat, 'Cetak Resep Obat', "class='btn btn-success' target='new'"); ?>
        <?php echo anchor('pendaftaran/cetakrujukan/'.$no_rawat, 'Cetak Rujukan', "class='btn btn-info' target='new'"); ?>

        </div>
                    </div>
            </div>


    <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">RIWAYAT TINDAKAN</h3>
                    </div>
        
        <div class="box-body">        
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
                <th>Poli</th>
                <th>Penyakit</th>
                <th>Tindakan</th>
                <th>Hasil Periksa</th>
                <th>Nama Obat</th>
            </tr>
            <?php  
            $no = 1;
            foreach ($data_tindakan as $dt){

               echo "<tr>
                                    <td>$no</td>
                                    <td>$dt->nama_poli</td>
                                    <td>$dt->nama_penyakit</td>
                                    <td>$dt->nama_tindakan</td>
                                    <td>$dt->hasil_periksa</td>
                                    <td>$dt->nama_obat</td></tr>";
                                $no++;
            }
            ?>
        </table>  
      </div>
    </div>
   </div>

    <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">RESEP OBAT</h3>
                    </div>
        
        <div class="box-body">
           <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jenis Obat</th>
                <th>Dosis Obat</th>
            </tr>
            <?php  
            $no = 1;
            foreach ($data_resep as $dr) {
                echo "<tr>
                <td>$no</td>
                <td>$dr->nama_obat</td>
                <td>$dr->jenis_obat</td>
                <td>$dr->dosis_aturan_obat</td>
                </tr>";
                $no++;
            }
            ?>
        
        </table>
        
        </div>
                    </div>
            </div>

            </div>
    </section>
</div>

<div class="modal fade" id="modaltindakan" tabindex="-1" role="dialog" aria-labelledby="modaltindakanLabel">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden ="true">&times;</span></button> <!--membuat tombol tutup (close) -->
                <h4 class="modal-title" id="modaltindakanLabel">Input Tindakan</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('pendaftaran/periksa_action'); ?>
                <table class="table table-bordered ">
                    <input value="<?php echo $no_rawat ?>" name="no_rawat" type="hidden">
                    <input value="<?php echo $pendaftaran['no_rekamedis'] ?>" name="no_rekamedis" type="hidden">

                    <tr><td width="200">Poli Tujuan </td>
                    <td>
                        <input type="text" name="nama_poli" id="nama_poli" class="form-control" required  placeholder="Masukkan Nama Poli" value="<?php echo $baca_poli['nama_poli'] ?>" readonly>
                    </td>
                    </tr>
                    <tr><td>Nama Penyakit</td>
                    <td><input type="text" name="nama_penyakit" class="form-control ui-autocomplete-input" placeholder="Masukkan Nama Penyakit" id="nama_penyakit" onkeyup="auto_nama_penyakit()" required></td>
                    </tr>
                    <tr><td>Nama Tindakan</td>
                    <td><input type="text" name="nama_tindakan" class="form-control ui-autocomplete-input" placeholder="Masukkan Nama Tindakan" id="nama_tindakan" onkeyup="auto_nama_tindakan()" required></td>
                    </tr>
                    <tr><td>Hasil Periksa</td>
                    <td><input type="text" name="hasil_periksa"  placeholder="Masukkan Hasil Periksa" id="hasil_periksa" class="form-control"></td>
                    </tr>
                    <tr><td>Nama Obat</td>
                    <td><input type="text" name="nama_obat" class="form-control" id="nama_obat" required placeholder="Masukkan Nama Obat" onkeyup="autonamaobat()"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

    <div class="modal fade" id="modalresep" tabindex="-1" role="dialog" aria-labelledby="modaltindakanLabel">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden ="true">&times;</span></button> <!--membuat tombol tutup (close) -->
                <h4 class="modal-title" id="modaltindakanLabel">Input Resep</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('pendaftaran/resep_action'); ?>
                <table class="table table-bordered ">
                    <input value="<?php echo noResepOtomatis() ?>" name="kode_resep" type="hidden">
                    <input value="<?php echo $no_rawat ?>" name="no_rawat" type="hidden">
                    <input value="<?php echo $pendaftaran['no_rekamedis'] ?>" name="no_rekamedis" type="hidden">
                    <tr><td>Nama Obat</td>
                    <td>
                        <input type="text" name="nama_obats" class="form-control" id="nama_obats" required placeholder="Masukkan Nama Obat" onkeyup="autonamaobats()" > 
                        <!--<?php echo datalist_dinamis('test', 'tbl_obat', 'nama_obat') ?> -->
                    </td>
                    </tr>
                    <tr><td>Jenis Obat</td>
                    <td><input type="text" name="jenis_obat"  placeholder="Masukkan Jenis Obat" id="jenis_obat" class="form-control"></td>
                    </tr>
                    <tr><td>Dosis Obat dan Aturan</td>
                    <td><input type="text" name="dosis_aturan_obat"  placeholder="Masukkan Dosis obat dan Aturan " id="dosis_aturan_obat" class="form-control"></td>
                    </tr>
                    <tr><td>Jumlah Obat</td>
                    <td><input type="text" name="jumlah_obat"  placeholder="Masukkan Jumlah Obat" id="jumlah_obat" class="form-control"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

    <div class="modal fade" id="modalrujukan" tabindex="-1" role="dialog" aria-labelledby="modalrujukanLabel">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden ="true">&times;</span></button> <!--membuat tombol tutup (close) -->
                <h4 class="modal-title" id="modalrujukanLabel">Input Rujukan</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('pendaftaran/rujukan_action'); ?>
                <table class="table table-bordered ">
                    <input value="<?php echo kodeRujukOtomatis() ?>" name="kode_rujukan" type="hidden">
                    <input value="<?php echo $no_rawat ?>" name="no_rawat" type="hidden">
                    <input value="<?php echo "R-".date('Ymd')."-".kodeRujukOtomatis() ?>" name="no_rujukan" type="hidden">
                    <tr><td>Nama Pasien</td>
                    <td>
                        <input type="text" name="nama_pasien" class="form-control" id="nama_pasien" required placeholder="Masukkan Nama Pasien" value="<?php echo $pendaftaran['nama_pasien'] ?>" readonly > 
                    </td>
                    </tr>
                    <tr><td>Nama Penyakit</td>
                    <td><input type="text" name="nama_penyakitz" placeholder="Masukkan Nama Penyakit" id="nama_penyakitz" class="form-control" onkeyup="PenyakitAuto()"></td>
                    </tr>
                    <tr><td>Diagnosa</td>
                    <td><input type="text" name="diagnosa"  placeholder="Masukkan Diagnosa" id="diagnosa" class="form-control"></td>
                    </tr>
                    <tr><td>Nama Rumah Sakit</td>
                    <td><input type="text" name="nama_rumah_sakit"  placeholder="Masukkan Nama Rumah Sakit" id="nama_rumah_sakit" class="form-control"></td>
                    </tr>
                    <tr><td>Poli Tujuan</td>
                    <td><input type="text" name="poli_tujuan"  placeholder="Masukkan Poli Tujuan" id="poli_tujuan" class="form-control"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
   


<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>



<script type="text/javascript">
    
    function auto_nama_penyakit(){
         //autocomplete
        $("#nama_penyakit").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocompletePenyakit",
            minLength: 1
        });
    }

    function PenyakitAuto(){
         //autocomplete
        $("#nama_penyakitz").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/PenyakitAuto",
            minLength: 1
        });
    }

   function autonamaobat(){
        //autocomplete
        $("#nama_obat").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocompletemedicine",
            minLength: 1
        });
    }

    function autonamaobats(){
        //autocomplete
        $("#nama_obats").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocomplate",
            minLength: 1
        });
        autofillobat();
    }
    
   
    function auto_nama_tindakan(){
        //autocomplete
        $("#nama_tindakan").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocompleteTindakan",
            minLength: 1
        });
    }

     function auto_nama_poli(){
        //autocomplete
        $("#nama_poli").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocompletePoli",
            minLength: 1
        });
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
        }); 
    }

    function autofillobat(){

        var nama_obats = $("#nama_obats").val();
        $.ajax({
            url: "<?php echo base_url()?>index.php/pendaftaran/autofillobat",
            data : "nama_obat="+nama_obats,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#jenis_obat').val(obj.jenis_obat);
            $('#dosis_aturan_obat').val(obj.dosis_aturan_obat);
        }); 
    }
    
</script>

<!-- <script type="text/javascript">
    $(function() {
        //autocomplete
        $("#nama_obats").autocomplete({
            source: "<?php echo base_url()?>/index.php/pendaftaran/autocomplate",
            minLength: 1
        });        

    });
</script>-
