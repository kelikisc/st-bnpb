<?php
/**
 * Created by PhpStorm.
 * User: MNurilmanBaehaqi
 * Date: 8/6/2018
 * Time: 9:10 AM
 */

class Surat extends CI_Controller
{

	function __Construct()
	{
		parent ::__construct();
		$this->load->model("home_model");
		$this->load->library("pagination");
	}

	function buat_surat_dinas() {
		$data['pegawai'] = $this->home_model->get_pegawai();
		$data['nomor'] = $this->home_model->get_nomor();
		$data['harian'] = $this->home_model->get_uang_harian();
		$data['penginapan'] = $this->home_model->get_biaya_penginapan();
		$data['tiket'] = $this->home_model->get_tiket_pesawat();
		$data['transport'] = $this->home_model->get_biaya_transport();
		$this->load->view('layouts/nav');
		$this->load->view('layouts/header');
		$this->load->view('dynamic_form', $data);
		$this->load->view('layouts/footer');
	}

	function exec_surat() {
		if (isset($_POST['submit'])) {
			$nomor = $this->input->post('nomor');
			$kegiatan = $this->input->post('kegiatan');
			$jenis = isset($_POST['jenisPembayaran']) ? "1" : "0";
			$opsi = isset($_POST['check'])	 ? "1" : "0";

			$data_surat = array(
				'nomor' => $nomor,
				'kegiatan' => $kegiatan,
				'jenis' => $jenis,
				'opsi' => $opsi
			);
			$this->db->insert('surat_dinas', $data_surat);

			if(!isset($_POST['check'])) {
				//Proses banyak nama untuk satu tempat
				$mulai = $this->input->post('mulai');
				$akhir = $this->input->post('akhir');
				$my_select = $this->input->post('my-select[]');
				$tempat = $this->input->post('tempat');
				$harian = $this->input->post('harian');
				$penginapan = $this->input->post('penginapan');
				$tiket = $this->input->post('tiket');
				$transport = $this->input->post('transport');

				$num_data = count($this->input->post('my-select[]'));
				for($i=0;$i<$num_data;$i++) {
					$data_rinci = array(
						'id' => $i,
						'nomor' => $nomor, 'kegiatan' => $kegiatan, 'jenis' => $jenis,
						'opsi' => $opsi, 'id_pegawai' => $my_select[$i], 'tgl_mulai' => $mulai,
						'tgl_akhir' => $akhir, 'tempat' => $tempat, 'id_harian' => $harian,
						'id_penginapan' => $penginapan, 'id_tiket' => $tiket, 'id_transport' => $transport
					);
					$this->db->insert('data_rinci', $data_rinci);
				}

			} else {
				//Proses banyak nama untuk banyak tempat

				$mulai = $this->input->post('mulai_input');
				$akhir = $this->input->post('akhir_input');
				$tempat = $this->input->post('tempat_input');

				$d_pegawai = $this->input->post('my-select-pegawai');
				$d_harian = $this->input->post('my-select-harian');
				$d_penginapan = $this->input->post('my-select-penginapan');
				$d_tiket = $this->input->post('my-select-tiket');
				$d_transport = $this->input->post('my-select-transport');

				$num_data = count($this->input->post('my-select-pegawai'));

				for($key=0;$key<$num_data;$key++) {

					$data_rinci = array(
						'nomor' => $nomor, 'kegiatan' => $kegiatan, 'jenis' => $jenis,
						'opsi' => $opsi, 'id_pegawai' => $d_pegawai[$key], 'tgl_mulai' => $mulai[$key],
						'tgl_akhir' => $akhir[$key], 'tempat' => $tempat[$key], 'id_harian' => $d_harian[$key],
						'id_penginapan' => $d_penginapan[$key], 'id_tiket' => $d_tiket[$key], 'id_transport' => $d_transport[$key]
					);
					$this->db->insert('data_rinci', $data_rinci);
				}
			}
		}
	}
}