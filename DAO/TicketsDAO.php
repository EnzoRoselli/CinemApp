<?php 

namespace DAO;

use Model\Ticket as Ticket;

//FALTA LA IMPLEMENTACION DEL QR
class TicketsDAO  
{
    private $tableName="tickets";

    public function add(Ticket $ticket)
    {
        $query = "INSERT INTO ". $this->tableName." "."(id_showtime,id_purchase) VALUES(:id_showtime,:id_purchase)";
        $parameters["id_showtime"] = $ticket->getShowtime()->getId();
        $parameters["id_purchase"] = $ticket->getPurchase()->getId();
 
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
}


























?>