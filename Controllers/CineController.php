<?php 
namespace Controllers;

Use Model\Cine as Cine;
Use DAO\CineRepository as daoCine;


class CineController{

    private $cineRepository;

    public function __construct()
    {
        $this->cineRepository = new daoCine();
    }

    public function determinateUpdateCreate()
    {
        if($_POST){     
            if($_POST[CINE_ID] !== ""){
                
                $this->updateCinema();

            }else if($_POST[CINE_ID] == ""){

                $this->createCinema();
            }
        }
    }

    public function createCinema(){
        
        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];
        
        $cine = new Cine($name, $adress, $capacity, $price);

        if($this->isCapacityValid($capacity) && $this->isTicketValueValid($price)){

        //     if($this->cineRepository->add($cine)){
    
        //         CineController::showMessage(0);
        //         $this->showCinemaMenu(); 
        //     }else{
        //         CineController::showMessage(1);
        //         $this->showCinemaMenu(); 
        //    }
        $this->cineRepository->add($cine);
        $this->showCinemaMenu();    
        
        }else if(!$this->isCapacityValid($capacity) && $this->isTicketValueValid($price)){

            CineController::showMessage(4);
            $this->showCinemaMenu();
        }else if($this->isCapacityValid($capacity) && !$this->isTicketValueValid($price)){

            CineController::showMessage(5);
            $this->showCinemaMenu();
        }else if(!$this->isCapacityValid($capacity) && !$this->isTicketValueValid($price)){

            CineController::showMessage(6);
            $this->showCinemaMenu(); 
        }
        
        
    }

    public function updateCinema(){

        $updatedId=$_POST[CINE_ID];
        $updatedName=$_POST[CINE_NAME];
        $updatedAdress=$_POST[CINE_ADRESS];
        $updatedCapacity=$_POST[CINE_CAPACITY];
        $updatedPrice=$_POST[CINE_TICKETVALUE];

        $modifiedCinema = new Cine($updatedName,$updatedAdress,$updatedCapacity,$updatedPrice);
        $modifiedCinema->setId($updatedId);

        if($this->isCapacityValid($updatedCapacity) && $this->isTicketValueValid($updatedPrice)){

            if($this->cineRepository->modifyCine($modifiedCinema)){
                
                CineController::showMessage(2);
                $this->showCinemaMenu();
            }else{

                CineController::showMessage(3);
                $this->showCinemaMenu();
            }

        }else if(!$this->isCapacityValid($updatedCapacity) && $this->isTicketValueValid($updatedPrice)){

            CineController::showMessage(4);
            $this->showCinemaMenu();
        }else if($this->isCapacityValid($updatedCapacity) && !$this->isTicketValueValid($updatedPrice)){

            CineController::showMessage(5);
            $this->showCinemaMenu();
        }else if(!$this->isCapacityValid($updatedCapacity) && !$this->isTicketValueValid($updatedPrice)){

            CineController::showMessage(6);
            $this->showCinemaMenu(); 
        }

    }

    private function isCapacityValid($capacity){

        if($capacity <= 0){
            return 0;
        }else{
            return 1;
        }
    }

    private function isTicketValueValid($price){

        if($price <= 0){
            return 0;
        }else{
            return 1;
        }
    }

    public function showCinemaMenu()
    {
     
        $cines = $this->cineRepository->getAll();
        if(isset($_GET['delete']) || isset($_GET['update'])){

            if (isset($_GET['delete'])) {
    
                $id = $_GET['delete'];
                $this->cineRepository->delete($id);
                require_once(VIEWS  .'/AdminCine.php');
            }
            
            if (isset($_GET['update'])) {

                $cineUpdate = new Cine();
                $id = $_GET['update'];
        
                $cineUpdate = $this->cineRepository->searchById($id);
                
                echo "<script type='text/javascript'>
                    window.addEventListener('load', function() {
                        overlay.classList.add('active');
                        popup.classList.add('active');
                    })
                </script>";
                
                require_once(VIEWS  .'/AdminCine.php');
            
            }

        }else{
            require_once(VIEWS  .'/AdminCine.php');
        }
    
    }

    public function delete()
    {
        $this->cineRepository->delete($_GET['id']);
        
    }
    public function update()
    {
        $this->cineRepository->modifyCine($_GET['id']);      
     
    }

    public static function showMessage($messageNumber){

        switch ($messageNumber) {
            case 0:
                echo "<script> if(confirm('Agregado correctamente'));</script>";
                break;
            case 1:
                 echo "<script> if(confirm('Verifique que los datos no esten repetidos'));</script>";
                break;
            case 2:
                echo "<script> if(confirm('Modificado correctamente'));</script>";      
                break;
            case 3:
                echo "<script> if(confirm('Sin modificacion'));</script>";
                break;
            case 4:
                echo "<script> if(confirm('La capacidad debe ser mayor a 0'));</script>";
                break;
            case 5:
                echo "<script> if(confirm('El valor del ticket debe ser mayor a 0'));</script>";
                break;
            case 6:
                echo "<script> if(confirm('La capacidad y el valor del ticket deben ser mayor a 0'));</script>";
                break;
            default:
               

                break;
        }
    }

}
