<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {

		public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}	

		public function getDataPegawai()
		{	
			$this->db->select('*');
			$query = $this->db->get('kategori');
			return $query->result();
		}

		public function getJabatanByPegawai($idKategori)
		{
			$this->db->select('kategori.id as id, kategori.nama as Nama_Kategori, barang.nama as Nama_Barang, barang.kode as Kode_Barang, barang.tanggal_beli as Tanggal_Beli, barang.foto as Foto');
			$this->db->from('barang');
			$this->db->join('kategori', 'barang.fk_kategori = kategori.id');
			$this->db->where('kategori.id', $idKategori);
			$query = $this->db->get();
			return $query->result_array();

		}

		public function insertPegawai()
		{
			$object = array(
				'nama' => $this->input->post('nama'),
				
				);
			$this->db->insert('kategori', $object);
		}

		public function getPegawai($id)
		{
			$this->db->where('id', $id);
			$query=$this->db->get('kategori',1);
			return $query->result();
		}

		public function getJabatan($idKategori)
		{
			$this->db->where('id', $idKategori);
			$query=$this->db->get('barang',1);
			return $query->result();
		}

		public function updateById($id)
		{
			$data = array(
				'nama' => $this->input->post('nama'),
			 	);
			$this->db->where('id',$id);
			$this->db->update('kategori', $data);

		}

		public function updateJabatan($idKategori)
		{
			$data = array(
				'nama' => $this->input->post('nama'),
				'kode' => $this->input->post('kode'),
				'tanggal_beli' => $this->input->post('tanggal_beli'),
				'foto' => $this->upload->data('file_name'),
			 	);
			$this->db->where('id',$idKategori);
			$this->db->update('barang', $data);

		}

		public function delete($id){
			$this->db->where('id',$id);
			$this->db->delete('kategori');
		}

		public function deleteJabatan($idKategori){
			$this->db->where('id',$idKategori);
			$this->db->delete('barang');
		}

		public function insertJabatan($idKategori)
		{
			$object = array(
			'nama' => $this->input->post('nama'),
			'kode' => $this->input->post('kode'),
			'tanggal_beli' => $this->input->post('tanggal_beli'),
			'foto' => $this->upload->data('file_name'),
			'fk_kategori' => $idKategori,
			);
			$this->db->insert('barang',$object);
		}

}

/* End of file Pegawai_Model.php */
/* Location: ./application/models/Pegawai_Model.php */
 ?>