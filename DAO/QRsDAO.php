<?php
namespace DAO;

use Model\Purchase AS Purchase;
use Model\QR AS QR;
use DAO\TicketsDAO AS TicketsDAO;


class QRsDAO 
{
    private $TicketsDAO;
    private $tableName="QRs";
    public function __construct() {
        $this->TicketsDAO = new TicketsDAO();
    }

    public function add(QR $qr)
    {
        $query = "INSERT INTO ". $this->tableName . "(id_ticket,qr_image) VALUES(:id_ticket,:qr_image) ";
        $parameters["id_ticket"] = $this->TicketsDAO->getLastTicket();
        $lastId=($this->getLastQRid()+1);
        $fileName=$qr->getDir()."qr-".$lastId.".png";
        $parameters["qr_image"]=$fileName;
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
    public function getByPurchase(Purchase $purchase)
    {
        $QRsList=array();
       $query = "SELECT * FROM ". $this->tableName . " inner join tickets on tickets.id=QRs.id_ticket inner join purchases on purchases.id=tickets.id_purchase WHERE purchases.id=:id_purchase group by(QRs.id)";
       $parameters['id_purchase']=$purchase->getId();
       try {
        $this->connection = Connection::GetInstance();
        $ResultSet=$this->connection->Execute($query, $parameters);
        foreach ($ResultSet as $item) {
            $qr=new QR();
            $ticket=$this->TicketsDAO->searchById($item['id_ticket']);
            $qr->setTicket($ticket);
            $qr->setFileName($item['qr_image']);
          array_push($qr,$QRsList);
        }
        return $QRsList;
    } catch (\Throwable $ex) {
        throw $ex;
    }
    }

    public function getLastQRid()
    {
        $query = "SELECT max(id) FROM " .  $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $ResultSet=$this->connection->Execute($query);
            return $ResultSet[0]['id'];
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }
}










?>