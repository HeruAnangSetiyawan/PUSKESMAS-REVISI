<?php
function cmb_dinamis($name,$table,$field,$pk,$selected=null){
    $ci = get_instance();
    $cmb = "<select name='$name' class='form-control'>"."<option value=''>--Silakan Pilih--</option>";
    $data = $ci->db->get($table)->result();
    foreach ($data as $d){
        $cmb .="<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":'';
        $cmb .=">".  strtoupper($d->$field)."</option>";
    }
    $cmb .="</select>";
    return $cmb;  
}

function select2_dinamis($name,$table,$field,$placeholder){
    $ci = get_instance();
    $select2 = '<select name="'.$name.'" class="form-control select2 select2-hidden-accessible" multiple="" 
               data-placeholder="'.$placeholder.'" style="width: 100%;" tabindex="-1" aria-hidden="true">';
    $data = $ci->db->get($table)->result();
    foreach ($data as $row){
        $select2.= ' <option>'.$row->$field.'</option>';
    }
    $select2 .='</select>';
    return $select2;
}

function datalist_dinamis($name,$table,$field,$value=null){
    $ci = get_instance();
    $string = '<input value="'.$value.'" name="'.$name.'" list="'.$name.'" class="form-control">
    <datalist id="'.$name.'">';
    $data = $ci->db->get($table)->result();
    foreach ($data as $row){
        $string.='<option value="'.$row->$field.'">';
    }
    $string .='</datalist>';
    return $string;
}

function rename_string_is_aktif($string){
        return $string=='y'?'Aktif':'Tidak Aktif';
    }
    

function is_login(){
    $ci = get_instance();
    if(!$ci->session->userdata('id_users')){
        redirect('auth');
    }else{
        $modul = $ci->uri->segment(1);
        
        $id_user_level = $ci->session->userdata('id_user_level');
        // dapatkan id menu berdasarkan nama controller
        $menu = $ci->db->get_where('tbl_menu',array('url'=>$modul))->row_array();
        $id_menu = $menu['id_menu'];
        // chek apakah user ini boleh mengakses modul ini
        $hak_akses = $ci->db->get_where('tbl_hak_akses',array('id_menu'=>$id_menu,'id_user_level'=>$id_user_level));
        if($hak_akses->num_rows()<1){
            redirect('blokir');
            exit;
        }
    }
}

function alert($class,$title,$description){
    return '<div class="alert '.$class.' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> '.$title.'</h4>
                '.$description.'
              </div>';
}

// untuk chek akses level pada modul peberian akses
function checked_akses($id_user_level,$id_menu){
    $ci = get_instance();
    $ci->db->where('id_user_level',$id_user_level);
    $ci->db->where('id_menu',$id_menu);
    $data = $ci->db->get('tbl_hak_akses');
    if($data->num_rows()>0){
        return "checked='checked'";
    }
}


function autocomplate_json($table,$field){
    $ci = get_instance();
    $ci->db->like($field, $_GET['term']);
    $ci->db->select($field);
    $collections = $ci->db->get($table)->result();
    foreach ($collections as $collection) {
        $return_arr[] = $collection->$field;
    }
    echo json_encode($return_arr);
}

function noRekammedisOtomatis(){
    $ci = get_instance();
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(no_rekamedis) as maxKode FROM tbl_pasien";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxKode'];
    $noUrut = (int) substr($kode, 0, 6);
    $noUrut++;
    $kodeBaru = sprintf("%06s", $noUrut);
    return $kodeBaru;
}

function noRegistrasiotomatis(){
    $ci = get_instance();
    $today = date('Y-m-d');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(no_registrasi) as maxKode FROM tbl_pendaftaran where tanggal_daftar='$today'";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxKode'];
    $noUrut = (int) substr($kode, 0, 6);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut);//sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}

function noTransOtomatis(){
    $ci = get_instance();
    $today = date('Y-m-d');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(no_trans) as maxTrans FROM tbl_pengadaan_obat where tgl_transaksi = '$today'";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxTrans'];
    $noUrut = (int) substr($kode, 0, 6);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}

function noResepOtomatis(){
    $ci = get_instance();
    
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(kode_resep) as maxResep FROM tbl_resep_obat";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxResep'];
    $noUrut = (int) substr($kode, 0, 4);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}

function noadaOtomatis(){
    $ci = get_instance();
    $today = date('Y-m-d');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(id_pengadaan) as maxPengadaan FROM tbl_pengadaan_obat where tgl_transaksi = '$today'";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxPengadaan'];
    $noUrut = (int) substr($kode, 0, 4);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}

function noPengadaOtomatis(){
    $ci = get_instance();
    $today = date('Y-m-d');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(id_pengadaan) as maxPengadaan FROM tbl_pengadaan_obat where tgl_transaksi = '$today'";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxPengadaan'];
    $noUrut = (int) substr($kode, 0, 4);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}

function noPengeluaranOtomatis(){
    $ci = get_instance();
    $today = date('d-m-Y');

    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(id_pengeluaran) as maxPengeluaran FROM tbl_pengeluaran_obat where tgl_serah_obat = '$today'";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxPengeluaran'];
    $noUrut = (int) substr($kode, 0, 4);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}

function kodeRujukOtomatis(){
    $ci = get_instance();
    $today = date('d-m-Y');

    // mencari kode barang dengan nilai paling besar
    $query = "SELECT max(kode_rujukan) as maxRujukan FROM tbl_rujukan where tgl_rujukan = '$today'";
    $data = $ci->db->query($query)->row_array();
    $kode = $data['maxRujukan'];
    $noUrut = (int) substr($kode, 0, 4);
    $noUrut++;
    $kodeBaru = sprintf("%04s", $noUrut); //sprintf berfungsi untuk menampilkan kodebaru yang diambil
                                          //berdasarkan no_urut, "%04s" berfungsi untuk menampilkan berapa karakter yang ingin ditampilkan kalau %04s berarti yang ditampilkan hanya 4 karakter
    return $kodeBaru;
}