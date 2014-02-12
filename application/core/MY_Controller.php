<?php
/**
 * A base model with a series of CRUD functions (powered by CI's query builder),
 * validation-in-model support, event callbacks and more.
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-model
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

class MY_Controller extends CI_Controller
{		
	
	function __construct() {
		
		parent::__construct();
		
		// enable ChomePHP
		$this->ci =& get_instance();
		$this->ci->load->library('ChromePhp');
		$this->ci->chromephp->log('ChomePHP Loaded...');
			
  	} 			
   		
}