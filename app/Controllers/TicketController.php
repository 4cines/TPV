<?php

namespace app\Controllers;

require_once 'app/Models/Ticket.php';

use app\Models\Ticket;

class TicketController {

	protected $ticket;

	public function __construct(){  

		$this->ticket = new Ticket();
	}

	public function index($mesa){
		return $this->ticket->index($mesa);
	}

	public function index($preciobase){
		return $this->precio_bi->index($preciobase);
	}
}

?>