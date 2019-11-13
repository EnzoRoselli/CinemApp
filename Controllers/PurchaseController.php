<?php 

namespace Controllers;
use Model\Purchase as Purchase;
use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;

class PurchaseController  
{
    private $showtimeDao;

    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
    }

    public function create($amount, $totalPrice, $showtimeId)
    {
        $showtime = $this->showtimeDao->searchById($showtimeId);
        var_dump($showtime->getTheater()->getTicketValue() * $amount);
        if( $totalPrice == ($showtime->getTheater()->getTicketValue() * $amount)){
            $purchase = 
        }else{
            
        }

    }
}













?>