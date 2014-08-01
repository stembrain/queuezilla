<?php
require_once(VENDORS . 'OAuth' . DS . 'netflix_consumer.php');

class TestNetflixConsumer extends NetflixConsumer{
	
	public function __construct(){
		parent::__construct(
			'T1DOCDyCxe7j3gN6N_RIiBiKLNF4PvM4hqnyMYSD.LEv4-', 
			'BQAJAAEDEOepFfh_SmYuVZunUl0xhK4wLJtw4trLKKFVVWcNk3bteR9yBvaLEskMZoufJrQvK4oPpxHi3zyiZal0YV8l2oAa', 
			'dDyx9YPJ4ayd'
		);
	}
	
	public function testSearchForTitle(){
		$results = $this->searchForTitle('Batman');
		
	}
}