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

	public function total($mesa){
		return $this->ticket->total($mesa);
	}

	public function num_mesa($mesa){
		return $this->ticket->num_mesa($mesa);
	}

	public function addProduct($price_id, $table_id){
		return $this->ticket->addProduct($price_id, $table_id);
	}

	public function deleteProduct($ticket_id){
		return $this->ticket->deleteProduct($ticket_id);
	}

	public function deleteAllProducts($num_table){
		return $this->ticket->deleteAllProducts($num_table);
	}
		
}

?>