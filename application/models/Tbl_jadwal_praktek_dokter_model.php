<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_jadwal_praktek_dokter_model extends CI_Model
{

    public $table = 'tbl_jadwal_praktek_dokter';
    public $id = 'id_jadwal';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_jadwal,nama_dokter,hari,jam_mulai,jam_selesai,nama_poli');
        $this->datatables->from('tbl_jadwal_praktek_dokter');
        //add this line for join
        $this->datatables->join('tbl_poli', 'tbl_jadwal_praktek_dokter.id_poli = tbl_poli.id_poli');
        $this->datatables->join('tbl_dokter', 'tbl_jadwal_praktek_dokter.kode_dokter = tbl_dokter.kode_dokter');
        $this->datatables->add_column('action', anchor(site_url('jadwalpraktek/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('jadwalpraktek/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_jadwal');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_jadwal', $q);
	$this->db->or_like('kode_dokter', $q);
	$this->db->or_like('hari', $q);
	$this->db->or_like('jam_mulai', $q);
	$this->db->or_like('jam_selesai', $q);
	$this->db->or_like('id_poli', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_jadwal', $q);
	$this->db->or_like('kode_dokter', $q);
	$this->db->or_like('hari', $q);
	$this->db->or_like('jam_mulai', $q);
	$this->db->or_like('jam_selesai', $q);
	$this->db->or_like('id_poli', $q);
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

