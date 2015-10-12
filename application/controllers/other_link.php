<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Other_link extends CI_Controller {
	
	public function araneta_center()
	{

	header('Location:  http://www.aranetacenter.net/2008/index.php', TRUE, 301); exit(0);  
	}

	public function binibining_pilipinas()
	{

	header('Location:  http://www.bbpilipinas.com/', TRUE, 301); exit(0);  
	}

	public function dairyqueen()
	{

	header('Location: http://www.dairyqueen.com.ph/', TRUE, 301); exit(0);  
	}

	public function gateway_cineplex10()
	{

	header('Location: http://www.gatewaycineplex10.com/', TRUE, 301); exit(0);  
	}

	public function pizza_hut()
	{

	header('Location: http://www.pizzahut.com.ph/', TRUE, 301); exit(0);  
	}

	public function taco_bell()
	{

	header('Location: http://www.tacobell.com.ph/', TRUE, 301); exit(0);  
	}

	public function ticketnet()
	{

	header('Location: http://www.ticketnet.com.ph/', TRUE, 301); exit(0);  
	}

	}