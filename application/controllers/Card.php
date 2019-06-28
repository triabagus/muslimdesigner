<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {

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
	public function index()
	{
		$data['title']  = 'Yipyip.id | Card';

        $this->load->view('welcome/header', $data);
        $this->load->view('welcome/search', $data);
        $this->load->view('welcome/topbar', $data);
        $this->load->view('order/card',$data);
        $this->load->view('order/newslatter');
        $this->load->view('welcome/footer-bar-menu');
        $this->load->view('welcome/footer');
	}
}
