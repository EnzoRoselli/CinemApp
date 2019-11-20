<?php 

namespace DAO;

use Model\Ticket as Ticket;
use DAO\UsersDAO as usersDAO;
use DAO\ShowtimesDAO;
use DAO\PurchasesDAO;

class TicketsDAO  
{
    private $tableName="tickets";
    private $showtimesDAO;
    private $purchasesDAO;
    public function __construct() {
        $this->showtimesDAO = new ShowtimesDAO();
        $this->purchasesDAO = new PurchasesDAO();
    }

    public function add(Ticket $ticket)
    {
        $query = "INSERT INTO ". $this->tableName." "."(id_showtime,id_purchase) VALUES(:id_showtime,:id_purchase)";
        $parameters["id_showtime"] = $ticket->getShowtime()->getShowtimeId();
        $parameters["id_purchase"] = $ticket->getPurchase()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function searchById($id)
    {
        
            $query = "SELECT * FROM " . " " . $this->tableName . " WHERE id=:id";
            $parameters["id"] = $id;
            try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);
            if ($resultSet != null) {
                $ticket = new Ticket();
                $ticket->setId($resultSet[0]["id"]);

               $showtime=$this->showtimesDAO->searchById($resultSet[0]['id_showtime']);
                $ticket->setShowtime($showtime);

                $purchase=$this->purchasesDAO->searchById($resultSet[0]['id_purchase']);
                $ticket->setPurchase($purchase);
                return $ticket;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getLastTicket()
    {
        $query = "SELECT max(id) as id FROM ". $this->tableName ;
        $this->connection = Connection::GetInstance();
        $resultSet = $this->connection->Execute($query);

        try {
            if(!empty($resultSet)){
                return $resultSet[0]['id'];
            }
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }
}
