<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_stok_obat_model extends CI_Model
{

    public $table = 'tbl_stok_obat';
    public $id = 'kode_obat';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
   function get_all()
    {
    $this->db->select('tbl_pengadaan_obat.nama_obat,tbl_pengadaan_obat.jenis_obat,tbl_pengadaan_obat.jumlah, tbl_stok_obat.kode_obat,tbl_stok_obat.jumlah,tbl_obat.satuan');
    $this->db->join('tbl_pengadaan_obat','tbl_stok_obat.kode_obat = tbl_pengadaan_obat.kode_obat');
    $this->db->join('tbl_obat','tbl_stok_obat.kode_obat = tbl_obat.kode_obat');
    $this->db->group_by('tbl_stok_obat.kode_obat');
    return $this->db->get($this->table)->result();
    }

    public function get_data_total_stok(){

    $this->db->select_sum('jumlah');
    $query = $this->db->get($this->table);

    return $query->row()->jumlah;
  }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('kode_obat', $q);
	$this->db->or_like('jumlah', $q);
    $this->db->or_like('satuan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
    
    /*$this->db->like('kode_obat', $q);
	$this->db->or_like('jumlah', $q); */
    
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

