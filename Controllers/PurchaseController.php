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
       //tomar total, y el amount, una vez hecha corroboracion de si existe la showtime, etc, hacer un for count del amount, y crear ticjets POST haber creado la purhcase
        if( $totalPrice == ){
            $purchase = 
        }else{
            
        }

    }
}













?>