<?php
namespace DAO;

use Model\Purchase AS Purchase;
use Model\QR_ AS QRs;
use DAO\TicketsDAO AS TicketsDAO;

require_once(QR_ROUTE.'/phpqrcode/qrlib.php');
use QRcode AS QRcode;

class QRsDAO 
{
    private $TicketsDAO;
    private $tableName="QRs";
    public function __construct() {
        $this->TicketsDAO = new TicketsDAO();
    }

    public function add(QRs $newQr)
    {
        $query = "INSERT INTO ". $this->tableName . "(id_ticket,qr_image) VALUES(:id_ticket,:qr_image) ";
        $parameters["id_ticket"] = $this->TicketsDAO->getLastTicket();
        $lastId=($this->getLastQRid()+1);
        $fileName=QR_IMG."qr-".$lastId.".png";
        $file="qr-".$lastId.".png";
        $parameters["qr_image"]=$file;
        
        QRcode::png($lastId, $fileName);
   
        //echo '<img src="'.$fileName.'"/>'; 
       // echo '<img src="../QR/temp/qr-33.png"/>'; 
      
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
            $qr=new QRs();
            $ticket=$this->TicketsDAO->searchById($item['id_ticket']);
            $qr->setTicket($ticket);
            $qr->setFileName($item['qr_image']);
          array_push($QRsList,$qr);
        }
        return $QRsList;
    } catch (\Throwable $ex) {
        throw $ex;
    }
    }

    public function getLastQRid()
    {
        $query = "SELECT max(id) as id FROM " .  $this->tableName;
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