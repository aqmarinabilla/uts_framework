<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pegawai_model');
	}

	public function index()
	{
		$data['data_pegawai'] = $this->pegawai_model->getDataPegawai();
		$this->load->view('pegawai', $data);
	}

	public function create()
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required|alpha'); //nama form, tampilan notif, syarat2 require

		$this->load->model('pegawai_model');

		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_pegawai_view');
			}else{
			$this->pegawai_model->insertPegawai();
			$this->load->view('tambah_pegawai_sukses');
			}
	}

	public function update($id)
	{	//loaad library
		$this->load->helper('url','form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required'); //nama form, tampilan notif, syarat2 require

		//sebelum update data, terlebih dulu diambil data yg lama
		$this->load->model('pegawai_model');
		$data['pegawai']=$this->pegawai_model->getPegawai($id);

		//sekeleton code
		if($this->form_validation->run()==FALSE){

		//controller yg akan dikirim ke view
			$this->load->view('edit_pegawai_view', $data);
		}else{
			$this->pegawai_model->updateById($id);
			//$this->load->view('edit_pegawai_sukses');
			$data['data_pegawai'] = $this->pegawai_model->getDataPegawai();
			$this->load->view('pegawai', $data);
		}
	}

	public function delete($id)
	{
		$this->pegawai_model->delete($id);
		$this->index();
	}

	public function datatables()
	{	
		//$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getDataPegawai();
		$this->load->view('pegawai',$data);
	}

	public function datatables_ajax()
	{
		$this->load->view('pegawai');	
	}
	
	public function data_server()
	{
        $this->load->library('Datatables');
        $this->datatables
                ->select('id,nama')
                ->from('kategori');
        echo $this->datatables->generate();
	}
}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>