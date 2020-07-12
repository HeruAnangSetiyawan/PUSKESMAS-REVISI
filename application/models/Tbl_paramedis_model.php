<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_paramedis_model extends CI_Model
{

    public $table = 'tbl_paramedis';
    public $id = 'kode_paramedis';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('kode_paramedis,nama_paramedis,jenis_kelamin,no_izin_paramedis,tempat_lahir,tanggal_lahir,alamat_tinggal,nama_poli');
        $this->datatables->from('tbl_paramedis');
        //add this line for join
        $this->datatables->join('tbl_poli', 'tbl_paramedis.id_poli = tbl_poli.id_poli');
        $this->datatables->add_column('action', anchor(site_url('paramedis/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('paramedis/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_paramedis');
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
        $this->db->like('kode_paramedis', $q);
	$this->db->or_like('nama_paramedis', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('no_izin_paramedis', $q);
	$this->db->or_like('tempat_lahir', $q);
	$this->db->or_like('tanggal_lahir', $q);
	$this->db->or_like('alamat_tinggal', $q);
	$this->db->or_like('id_poli', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_paramedis', $q);
	$this->db->or_like('nama_paramedis', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('no_izin_paramedis', $q);
	$this->db->or_like('tempat_lahir', $q);
	$this->db->or_like('tanggal_lahir', $q);
	$this->db->or_like('alamat_tinggal', $q);
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

