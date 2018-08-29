<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __Construct()
    {
        parent ::__construct();
        $this->load->model("home_model");
        $this->load->library("pagination");
    }

	/*
     * Helper Function
     *
     * */

	function href ($route) {
		echo "<script>
         	window.location.href='".base_url()."$route';</script>";
	}

	function alert ($message) {
		echo "<script>         	
         	alert($message);</script>";
	}

	public function login() {
		$sql = "select * from admin where nama = ? and password = ?";
		$query = $this->db->query($sql, array($this->input->post('name'), $this->input->post('password')));
		if($query->num_rows()> 0) {
			$_SESSION['success'] = [ 'Berhasil login!', 'Selamat datang'];
			$this->href("home/beranda/");
		} else {
			$_SESSION['error'] = 'Username atau password salah';
         	$this->href("");
		}
	}

	/*
	 * Main Funtion Mnagement
	 *
	 *  */

	public function index()
	{
		$this->load->view('layouts/navlogin');
		$this->load->view('layouts/header');
		$this->load->view('login');
		$this->load->view('layouts/footer3');
	}

	public function beranda()
	{
			$this->load->view('layouts/nav');
			$this->load->view('layouts/header');
	        $this->load->view('beranda');
	        $this->load->view('layouts/footer2');

    } 	

	/*
	 * Surat Management
	 */
	public function lihat_surat() {
		$data['surat'] = $this->home_model->get_surat();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('lihat_surat', $data);
		// $this->load->view('layouts/footer');
	}

	/*
	 * CRUD Biaya Penginapan
	 *
	 * */

	public function biaya_penginapan()
	{
		$data['penginapan'] = $this->home_model->get_biaya_penginapan();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('biaya_penginapan', $data);
		// $this->load->view('layouts/footer');
	}

	public function tambah_penginapan() {
		$provinsi = $this->input->post('provinsi');
		$eselon_1 = $this->input->post('eselon_1');
		$eselon_2 = $this->input->post('eselon_2');
		$eselon_3 = $this->input->post('eselon_3');
		$eselon_4 = $this->input->post('eselon_4');
		$eselon_5 = $this->input->post('eselon_5');
		$data = array(
			'provinsi' => $provinsi,
			'eselon_1' => $eselon_1,
			'eselon_2' => $eselon_2,
			'eselon_3' => $eselon_3,
			'eselon_4' => $eselon_4,
			'eselon_5' => $eselon_5,
		);
		$this->db->insert('biaya_penginapan', $data);
		$this->href('home/biaya_penginapan');
	}

	function edit_penginapan_page($id) {
		$data['biaya_penginapan'] = $this->db->get_where('biaya_penginapan',  array('id' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_penginapan', $data);
		$this->load->view('layouts/footer');
	}

	function edit_penginapan($id) {
		$provinsi = $this->input->post('provinsi');
		$eselon_1 = $this->input->post('eselon_1');
		$eselon_2 = $this->input->post('eselon_2');
		$eselon_3 = $this->input->post('eselon_3');
		$eselon_4 = $this->input->post('eselon_4');
		$eselon_5 = $this->input->post('eselon_5');
		$data = array(
			'provinsi' => $provinsi,
			'eselon_1' => $eselon_1,
			'eselon_2' => $eselon_2,
			'eselon_3' => $eselon_3,
			'eselon_4' => $eselon_4,
			'eselon_5' => $eselon_5,
		);
		$this->db->where('id', $id);
		$this->db->update('biaya_penginapan', $data);
		$this->href('home/biaya_penginapan');
	}

	function delete_penginapan($id) {
		$where = array('id' => $id );
		$this->db->delete('biaya_penginapan', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/biaya_penginapan');
	}

	/*
	 * CRUD Biaya Transport
	 *
	 * */

	public function biaya_transport()
	{
		$data['transport'] = $this->home_model->get_biaya_transport();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('biaya_transport', $data);
		// $this->load->view('layouts/footer');
	}

	public function tambah_transport() {
		$provinsi = $this->input->post('provinsi');
		$besaran = $this->input->post('besaran');

		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('biaya_transport');
		$this->load->view('layouts/footer');
		$data = array(
			'provinsi' => $provinsi,
			'besaran' => $besaran,
		);
		$this->db->insert('biaya_transport', $data);
		$this->href('home/biaya_transport');
	}

	function edit_transport_page($id) {
		$data['biaya_transport'] = $this->db->get_where('biaya_transport',  array('id' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_transport', $data);
		$this->load->view('layouts/footer2');
	}

	function edit_transport($id) {
		$provinsi = $this->input->post('provinsi');
		$besaran = $this->input->post('besaran');
		$data = array(
			'provinsi' => $provinsi,
			'besaran' => $besaran,
		);
		$this->db->where('id', $id);
		$this->db->update('biaya_transport', $data);
		$this->href('home/biaya_transport');
	}

	function delete_transport($id) {
		$where = array('id' => $id );
		$this->db->delete('biaya_transport', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/biaya_transport');
	}

	/*
	 * CRUD Transport Lokal
	 *
	 * */

	public function transport_lokal()
	{
		$data['transport'] = $this->home_model->get_transport_lokal();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('transport_lokal', $data);
		// $this->load->view('layouts/footer');
	}

	public function tambah_transport_lokal() {
		$ibukota = $this->input->post('ibukota');
		$kabupaten = $this->input->post('kabupaten');
		$besaran = $this->input->post('besaran');

		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('transport_lokal');
		// $this->load->view('layouts/footer');
		$data = array(
			'ibukota' => $ibukota,
			'kabupaten' => $kabupaten,
			'besaran' => $besaran,
		);
		$this->db->insert('transportasi_lokal', $data);
		$this->href('home/transport_lokal');
	}

	function edit_transport_lokal_page($id) {
		$data['transport_lokal'] = $this->db->get_where('transportasi_lokal',  array('id' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_lokal', $data);
		// $this->load->view('layouts/footer2');
	}

	function edit_transport_lokal($id) {
		$ibukota = $this->input->post('ibukota');
		$kabupaten = $this->input->post('kabupaten');
		$besaran = $this->input->post('besaran');
		$data = array(
			'ibukota' => $ibukota,
			'kabupaten' => $kabupaten,
			'besaran' => $besaran,
		);
		$this->db->where('id', $id);
		$this->db->update('transportasi_lokal', $data);
		$this->href('home/transport_lokal');
	}

	function delete_transport_lokal($id) {
		$where = array('id' => $id );
		$this->db->delete('transportasi_lokal', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/transport_lokal');
	}

	/*
	 * CRUD Tiket Pesawat
	 *
	 * */

	public function tiket_pesawat()
	{
		$data['pesawat'] = $this->home_model->get_tiket_pesawat();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('tiket_pesawat', $data);
		// $this->load->view('layouts/footer');
	}

	public function tambah_tiket() {
		$rute = $this->input->post('rute');
		$biaya_tiket = $this->input->post('biaya_tiket');

		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('tiket_pesawat');
		// $this->load->view('layouts/footer');
		$data = array(
			'rute' => $rute,
			'biaya_tiket' => $biaya_tiket,
		);
		$this->db->insert('tiket_pesawat', $data);
		$this->href('home/tiket_pesawat');
	}

	function edit_tiket_page($id) {
		$data['tiket_pesawat'] = $this->db->get_where('tiket_pesawat',  array('id' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_tiket', $data);
		$this->load->view('layouts/footer2');
	}

	function edit_tiket($id) {
		$rute = $this->input->post('rute');
		$biaya_tiket = $this->input->post('biaya_tiket');
		$data = array(
			'rute' => $rute,
			'biaya_tiket' => $biaya_tiket,
		);
		$this->db->where('id', $id);
		$this->db->update('tiket_pesawat', $data);
		$this->href('home/tiket_pesawat');
	}

	function delete_tiket($id) {
		$where = array('id' => $id );
		$this->db->delete('tiket_pesawat', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/tiket_pesawat');
	}

	/*
	 * CRUD Uang Harian
	 *
	 * */

	public function uang_harian()
	{
		$data['harian'] = $this->home_model->get_uang_harian();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('uang_harian', $data);
		// $this->load->view('layouts/footer');
	}

	public function tambah_harian() {
		$provinsi = $this->input->post('provinsi');
		$luar_kota = $this->input->post('luar_kota');
		$dalam_kota = $this->input->post('dalam_kota');
		$diklat = $this->input->post('diklat');

		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('uang_harian');
		// $this->load->view('layouts/footer');
		$data = array(
			'provinsi' => $provinsi,
			'luar_kota' => $luar_kota,
			'dalam_kota' => $dalam_kota,
			'diklat' => $diklat,
		);
		$this->db->insert('uang_harian', $data);
		$this->href('home/uang_harian');
	}

	function edit_harian_page($id) {
		$data['uang_harian'] = $this->db->get_where('uang_harian',  array('id' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_harian', $data);
		// $this->load->view('layouts/footer');
	}

	function edit_harian($id) {
		$provinsi = $this->input->post('provinsi');
		$luar_kota = $this->input->post('luar_kota');
		$dalam_kota = $this->input->post('dalam_kota');
		$diklat = $this->input->post('diklat');
		$data = array(
			'provinsi' => $provinsi,
			'luar_kota' => $luar_kota,
			'dalam_kota' => $dalam_kota,
			'diklat' => $diklat,
		);
		$this->db->where('id', $id);
		$this->db->update('uang_harian', $data);
		$this->href('home/uang_harian');
	}

	function delete_harian($id) {
		$where = array('id' => $id );
		$this->db->delete('uang_harian', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/uang_harian');
	}

	/*
	 * CRUD Uang Representasi
	 *
	 * */

	public function uang_representasi()
	{
		$data['representasi'] = $this->home_model->get_uang_representasi();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('uang_representasi', $data);
		// $this->load->view('layouts/footer2');
	}

	public function tambah_representasi() {
		$uraian = $this->input->post('uraian');
		$luar_kota = $this->input->post('luar_kota');
		$dalam_kota = $this->input->post('dalam_kota');
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('uang_representasi');
		// $this->load->view('layouts/footer');
		$data = array(
			'uraian' => $uraian,
			'luar_kota' => $luar_kota,
			'dalam_kota' => $dalam_kota,
		);
		$this->db->insert('uang_representasi', $data);
		$this->href('home/uang_representasi');
	}

	function edit_representasi_page($id) {
		$data['uang_representasi'] = $this->db->get_where('uang_representasi',  array('id' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_representasi', $data);
		$this->load->view('layouts/footer2');
	}

	function edit_representasi($id) {
		$uraian = $this->input->post('uraian');
		$luar_kota = $this->input->post('luar_kota');
		$dalam_kota = $this->input->post('dalam_kota');
		$data = array(
			'uraian' => $uraian,
			'luar_kota' => $luar_kota,
			'dalam_kota' => $dalam_kota,
		);
		$this->db->where('id', $id);
		$this->db->update('uang_representasi', $data);
		$this->href('home/uang_representasi');
	}

	function delete_representasi($id) {
		$where = array('id' => $id );
		$this->db->delete('uang_representasi', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/uang_representasi');
	}

	public function layout_biaya()
	{
		$this->load->view('layouts/header');
		$this->load->view('layout_biaya');
	}

	public function layout_perhitungan()
	{
		$this->load->view('layouts/header');
		$this->load->view('layout_perhitungan');
	}

	/*
	 * Pegawai Management
	 */

	public function pegawai()
	{
		$data['pegawai'] = $this->home_model->get_pegawai();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('pegawai', $data);
		// $this->load->view('layouts/footer');
	}
	public function tambah_pegawai() {
		$name = $this->input->post('nama');
		$nip = $this->input->post('nip');
		$jabatan = $this->input->post('jabatan');
		$golongan = $this->input->post('gol');
		$data = array(
			'nama_pegawai' => $name,
			'nip_pegawai' => $nip,
			'jabatan_pegawai' => $jabatan,
			'golongan_pegawai' => $golongan
		);
		$this->db->insert('pegawai', $data);
		$this->href('home/pegawai');

	}

	function delete_pegawai($id) {
		$where = array('id_pegawai' => $id );
		$this->db->delete('pegawai', $where);
		$_SESSION['berhasil'] = "Berhasil menghapus";
		$this->href('home/pegawai');
	}

	function edit_pegawai_page($id) {
		$data['pegawai'] = $this->db->get_where('pegawai',  array('id_pegawai' => $id) )->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_pegawai', $data);
		// $this->load->view('layouts/footer');
	}

	function edit_pegawai($id) {
		$name = $this->input->post('nama');
		$nip = $this->input->post('nip');
		$jabatan = $this->input->post('jabatan');
		$golongan = $this->input->post('gol');
		$data = array(
			'nama_pegawai' => $name,
			'nip_pegawai' => $nip,
			'jabatan_pegawai' => $jabatan,
			'golongan_pegawai' => $golongan
		);
		$this->db->where('id_pegawai', $id);
		$this->db->update('pegawai', $data);
		$this->href('home/pegawai');
	}


	//Edit PPK
	public function ppk() 
	{
		$data['ppk'] = $this->home_model->get_ppk();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('pejabat', $data);
	}

	function edit_ppk_page($id){
		$data['ppk'] = $this->db->get_where('pejabat_administratif', array('id' => $id))->result();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('edit_ppk', $data);
	}

	function edit_ppk($id) {
		$jabatan = $this ->input->post('jabatan');
		$nama = $this->input->post('nama');
		$nip = $this ->input->post('nip');
		$data = array(
			'jabatan' => $jabatan,
			'nama' => $nama,
			'nip' => $nip
		);
		$this->db->where('id', $id);
		$this->db->update('pejabat_administratif', $data);
		$this->href('home/ppk');
	}

}
