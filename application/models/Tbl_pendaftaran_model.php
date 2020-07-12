<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pendaftaran_model extends CI_Model
{

    public $table = 'tbl_pendaftaran';
    public $id = 'no_rawat';
    public $order = 'DESC';
    public $no_rekamedis = 'no_rekamedis';
    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
     $this->db->join('tbl_pasien', 'tbl_pendaftaran.no_rekamedis = tbl_pasien.no_rekamedis');
        $this->db->join('tbl_dokter', 'tbl_pendaftaran.kode_dokter_penanggung_jawab = tbl_dokter.kode_dokter');
        $this->db->join('tbl_poli', 'tbl_pendaftaran.id_poli = tbl_poli.id_poli');
        return $this->db->get($this->table)->result();
    }

    
    function getdata(){
             $this->db->select('*');
         $this->db->order_by($this->id, $this->order);
        $this->db->join('tbl_pasien', 'tbl_pendaftaran.no_rekamedis = tbl_pasien.no_rekamedis');
        $this->db->join('tbl_dokter', 'tbl_pendaftaran.kode_dokter_penanggung_jawab = tbl_dokter.kode_dokter');
        $this->db->join('tbl_poli', 'tbl_pendaftaran.id_poli = tbl_poli.id_poli');
        return $this->db->get($this->table)->result(); 
    }

    

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->join('tbl_pasien', 'tbl_pendaftaran.no_rekamedis = tbl_pasien.no_rekamedis');
        $this->db->join('tbl_dokter', 'tbl_pendaftaran.kode_dokter_penanggung_jawab = tbl_dokter.kode_dokter');
        $this->db->join('tbl_poli', 'tbl_pendaftaran.id_poli = tbl_poli.id_poli');
        return $this->db->get($this->table)->row(); 
    }

    function get_by_no_rekammedis($no_rekamedis)
    {
         $this->db->where($this->no_rekamedis, $no_rekamedis);
        $this->db->join('tbl_pasien', 'tbl_pendaftaran.no_rekamedis = tbl_pasien.no_rekamedis');
        $this->db->join('tbl_dokter', 'tbl_pendaftaran.kode_dokter_penanggung_jawab = tbl_dokter.kode_dokter');
        $this->db->join('tbl_poli', 'tbl_pendaftaran.id_poli = tbl_poli.id_poli');
        return $this->db->get($this->table)->row(); 
    }

    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('no_rawat', $q);
	$this->db->or_like('no_registrasi', $q);
	$this->db->or_like('no_rekamedis', $q);
	$this->db->or_like('tanggal_daftar', $q);
	$this->db->or_like('kode_dokter_penanggung_jawab', $q);
	$this->db->or_like('id_poli', $q);
	$this->db->or_like('nama_penanggung_jawab', $q);
	$this->db->or_like('hubungan_dengan_penanggung_jawab', $q);
	$this->db->or_like('alamat_penanggung_jawab', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
    

        $this->db->where('tbl_pendaftaran.tanggal_daftar', date('Y-m-d'));
        $this->db->order_by('tbl_pendaftaran.no_rawat', 'ASC');
        $this->db->join('tbl_pasien', 'tbl_pendaftaran.no_rekamedis = tbl_pasien.no_rekamedis');
        $this->db->join('tbl_dokter', 'tbl_pendaftaran.kode_dokter_penanggung_jawab = tbl_dokter.kode_dokter');
        $this->db->join('tbl_poli', 'tbl_pendaftaran.id_poli = tbl_poli.id_poli');
	   $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result(); 
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

