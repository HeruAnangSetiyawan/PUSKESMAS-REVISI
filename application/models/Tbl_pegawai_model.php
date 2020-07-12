<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pegawai_model extends CI_Model
{

    public $table = 'tbl_pegawai';
    public $id = 'id_pegawai';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_pegawai,nama_pegawai,jenis_kelamin,npwp,tempat_lahir,tanggal_lahir,nama_jabatan,nama_bidang');
        $this->datatables->from('tbl_pegawai');
        //add this line for join
        $this->datatables->join('tbl_jabatan', 'tbl_pegawai.id_jabatan = tbl_jabatan.id_jabatan');
        $this->datatables->join('tbl_bidang', 'tbl_pegawai.id_bidang = tbl_bidang.id_bidang');
        $this->datatables->add_column('action', anchor(site_url('pegawai/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('pegawai/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_pegawai');
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
        $this->db->like('id_pegawai', $q);
	$this->db->or_like('nama_pegawai', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('npwp', $q);
	$this->db->or_like('tempat_lahir', $q);
	$this->db->or_like('tanggal_lahir', $q);
	$this->db->or_like('id_jabatan', $q);
	$this->db->or_like('id_bidang', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_pegawai', $q);
	$this->db->or_like('nama_pegawai', $q);
	$this->db->or_like('jenis_kelamin', $q);
	$this->db->or_like('npwp', $q);
	$this->db->or_like('tempat_lahir', $q);
	$this->db->or_like('tanggal_lahir', $q);
	$this->db->or_like('id_jabatan', $q);
	$this->db->or_like('id_bidang', $q);
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

