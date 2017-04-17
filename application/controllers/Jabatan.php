<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pegawai_model');
	}
	
	public function index($idKategori)
	{
		$this->load->model('pegawai_model');
		$data['jabatan_list'] = $this->pegawai_model->getJabatanByPegawai($idKategori);
		$this->load->view('jabatan', $data);
	}

	public function create($idKategori)
	{

		$this->load->helper('url','form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nama', 'Nama Barang', 'trim|required|alpha'); //nama form, tampilan notif, syarat2 require
		$this->form_validation->set_rules('kode', 'Kode', 'trim|required|numeric');
		$this->form_validation->set_rules('tanggal_beli', 'Tanggal Beli', 'trim|required');

		$this->load->model('pegawai_model');

		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_jabatan_view');
		}else{
			$config['upload_path']		= './assets/uploads';
			$config['allowed_types']		= 'gif|jpg|png';
			$config['max_size']		= 1000000000;
			$config['max_width']		= 10240;
			$config['max_height']		= 7680;

			$this->load->library('upload', $config);

			if(! $this->upload->do_upload('userfile')){
				$error = array('error' => $this->upload->display_errors());
				//1
				$this->load->view('tambah_jabatan_view', $error);
			}else{
			$this->pegawai_model->insertJabatan($idKategori);
			$this->load->view('tambah_pegawai_sukses');
			}
		}
		
	}

	public function datatables()
	{	
		//$this->load->model('pegawai_model');
		$data["jabatan_list"] = $this->pegawai_model->getJabatanByPegawai($idKategori);
		$this->load->view('jabatan',$data);
	}

	public function delete($idKategori)
	{
		$this->pegawai_model->deleteJabatan($idKategori);
		$this->index($idKategori);
	}

	public function update($idKategori)
	{	//loaad library
		$this->load->helper('url','form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nama', 'Nama Barang', 'trim|required'); //nama form, tampilan notif, syarat2 require
		$this->form_validation->set_rules('kode', 'Kode', 'trim|required');
		$this->form_validation->set_rules('tanggal_beli', 'Tanggal Beli', 'trim|required');
		$this->form_validation->set_rules('foto', 'Foto', 'trim|required');

		//sebelum update data, terlebih dulu diambil data yg lama
		$this->load->model('pegawai_model');
		$data['jabatan']=$this->pegawai_model->getJabatan($idKategori);

		//sekeleton code
		if($this->form_validation->run()==FALSE){

		//controller yg akan dikirim ke view
			$this->load->view('edit_jabatan_view', $data);
		}else{
			$this->pegawai_model->updateJabatan($idKategori);
			//$this->load->view('edit_pegawai_sukses');
			$data['jabatan_list'] = $this->pegawai_model->getJabatanByPegawai($idKategori);
			$this->load->view('jabatan', $data);
		}
	}
}

/* End of file Jabatan.php */
/* Location: ./application/controllers/Jabatan.php */

 ?>