<?php  
namespace DAO;
use Model\Purchase as Purchase;
use Model\CinemaPurchases as CinemaPurchases;
use Model\MoviePurchases;
use DAO\UsersDAO as usersDAO;
use DAO\CreditCardsDAO as CreditCardsDAO;

class PurchasesDAO  
{
    private $tableName = "purchases";

    public function add(Purchase $purchase)
    {
        $query="INSERT into ". $this->tableName." (purchase_date,hour,ticketsAmount,total,id_user,id_cc) VALUES(:purchase_date,:hour,:ticketsAmount,:total,:id_user,:id_cc)" ;
        $parameters["purchase_date"] = $purchase->getDate();
        $parameters["hour"] = $purchase->getHour();
        $parameters["ticketsAmount"] = $purchase->getTicketAmount();
        $parameters["total"] = $purchase->getTotal();
        $parameters["id_user"] = $purchase->getUser()->getId();
        $parameters["id_cc"] = $purchase->getcreditCard()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Throwable $ex) {
            throw $ex;
        }
    }

    public function searchByPurchase($purchase)
    {
        $query = "SELECT * FROM ". $this->tableName." WHERE ticketsAmount=:ticketsAmount  and purchase_date=:purchase_date   and hour=:hour and   id_user=:id_user and   id_cc=:id_cc and total=:total";
        $parameters['purchase_date'] =$purchase->getDate();
        $parameters['hour'] = $purchase->getHour();
        $parameters['ticketsAmount'] = $purchase->getTicketAmount();
        $parameters['total'] = $purchase->getTotal();
        $parameters['id_user'] = $purchase->getUser()->getId();
        $parameters['id_cc'] = $purchase->getcreditCard()->getId();
        try {
            $this->connection = Connection::GetInstance();
            $ResultSet=$this->connection->Execute($query, $parameters);
            if (!empty($ResultSet)) {
                $Purchase = new Purchase();
                $purchase->setId($ResultSet[0]['id']);
                $purchase->setDate($ResultSet[0]['purchase_date']);
                $purchase->setHour($ResultSet[0]['hour']);
                $purchase->setTicketAmount($ResultSet[0]['ticketsAmount']);
                $purchase->setTotal($ResultSet[0]['total']);

                $usersDAO=new usersDAO();
                $user=$usersDAO->searchById($ResultSet[0]['id_user']);
                $purchase->setUser($user);

                $CreditCardsDAO=new CreditCardsDAO();
                $creditCard=$CreditCardsDAO->searchById($ResultSet[0]['id_cc']);
                $purchase->setcreditCard($creditCard);
                return $purchase;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPurchasesByCinemaId($cinemaId, $minDate = "", $maxDate = ""){

        $cinemasPurchasesList = array();
        
        $query = "SELECT a.cinema_name, a.address, SUM(a.total) AS 'totalTickets', SUM(a.ticketsAmount) AS 'totalSales' FROM(
                    SELECT c.id, c.cinema_name, c.address, p.ticketsAmount, p.total
                    FROM cinemas c
                    INNER JOIN theaters th
                    ON  th.id_cinema = c.id
                    INNER JOIN showtimes s
                    ON s.id_theater = th.id
                    INNER JOIN tickets t
                    ON t.id_showtime = s.id
                    INNER JOIN purchases p
                    ON t.id_purchase = p.id AND (p.purchase_date BETWEEN :minDate AND :maxDate)
                    GROUP BY t.id_showtime, t.id_purchase) a
                  WHERE a.id = :id_cinema";

        if(empty($minDate) || empty($maxDate)){

            $minDate = '2019-11-17';
            $maxDate = '3000-01-01';
            $parameters['minDate'] = $minDate;
            $parameters['maxDate'] = $maxDate;
        }

        $parameters['id_cinema'] = $cinemaId;

        try{
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);
            
            if(!empty($resultSet)){
                
                foreach ($resultSet as $row) {
    
                    $cinemaPurchase = new CinemaPurchases();
        
                    $cinemaPurchase->setName($row['cinema_name']);
                    $cinemaPurchase->setAddress($row['address']);
                    $cinemaPurchase->setTotalTickets($row['totalTickets']);
                    $cinemaPurchase->setTotalSales($row['totalSales']);
                
                    array_push($cinemasPurchasesList, $cinemaPurchase);             
                }
                return $cinemasPurchasesList;
                
            }else{
                return null;
            }
        
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function getPurchasesByMovieId($movieId, $minDate = "", $maxDate = ""){

        $moviesPurchasesList = array();

        $query = "SELECT a.title, ifnull(SUM(a.ticketsAmount),0) AS 'totalTickets', ifnull(SUM(a.total),0) AS 'totalSales' FROM(
                    SELECT m.id, m.title, p.ticketsAmount, p.total
                    FROM movies m
                    INNER JOIN showtimes s
                    ON s.id_movie = m.id
                    INNER JOIN tickets t
                    ON t.id_showtime = s.id
                    INNER JOIN purchases p
                    ON t.id_purchase = p.id AND (p.purchase_date BETWEEN :minDate AND :maxDate)
                    GROUP BY t.id_showtime, t.id_purchase) a
                WHERE a.id = :id_movie";

        if(empty($minDate) || empty($maxDate)){

            $minDate = '2019-11-17';
            $maxDate = '3000-01-01';
        }

        $parameters['id_movie'] = $movieId;
        $parameters['minDate'] = $minDate;
        $parameters['maxDate'] = $maxDate;

        try{
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query,$parameters);

            if(!empty($ResultSet)){

                foreach ($resultSet as $row) {
    
                    $cinemaPurchase = new MoviePurchases();
        
                    $cinemaPurchase->setTitle($row['title']);
                    $cinemaPurchase->setTotalTickets($row['totalTickets']);
                    $cinemaPurchase->setTotalSales($row['totalSales']);
                
                    array_push($cinemaPurchasesList, $cinemaPurchase);             
                }

                return $cinemaPurchasesList;
            }else{
                return null;
            }
        
        } catch (\Throwable $th) {
            throw $th;
        }
    }



}







































?>