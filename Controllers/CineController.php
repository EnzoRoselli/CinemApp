<?php 
namespace Controllers;

Use Model\Cine as Cine;
Use DAO\CinemasDAO as daoCine;


class CineController{

    private $CineDao;

    public function __construct()
    {
        $this->CineDao = new daoCine();
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

        if (isset($cine->getName()) && isset($cine->getAddress()) && $cine->getCapacity()>0 && $cine->getTicketValue()>0) { 

            if($this->CineDao->add($cine)){
    
                $advice=  CineController::showMessage(0);
                $this->showCinemaMenu(); 
            }else{
                $advice=  CineController::showMessage(1);
                $this->showCinemaMenu(); 
           }
        }else{
            $advice=CineController::showMessage(4);
            $this->showCinemaMenu(); //SIEMPRE TESTEAR SI LA VARIABLE NO ESTA VACIA EN LA VIEW, Y SINO HACERLE EL ALERT CON DE TEXTO EL &advice
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

        if (isset($cine->getName()) && isset($cine->getAddress()) && $cine->getCapacity()>0 && $cine->getTicketValue()>0) { 

            if($this->CineDao->modifyCine($modifiedCinema)){
                
                $advice= CineController::showMessage(2);
                $this->showCinemaMenu();
            }else{

               $advice= CineController::showMessage(3);
                $this->showCinemaMenu();
            }
        }else{
            $advice=CineController::showMessage(4);
            $this->showCinemaMenu(); //SIEMPRE TESTEAR SI LA VARIABLE NO ESTA VACIA EN LA VIEW, Y SINO HACERLE EL ALERT CON DE TEXTO EL &advice

        } 

    }

    private function isCapacityValid($capacity){

        if($capacity <= 0){
            return false;
        }else{
            return true;
        }
    }

    private function isTicketValueValid($price){

        if($price <= 0){
            return false;
        }else{
            return true;
        }
    }

    public function showCinemaMenu()
    {
     
        $cines = $this->CineDao->getAll();
        if(isset($_GET['delete']) || isset($_GET['update'])){

            if (isset($_GET['delete'])) {
    
                $id = $_GET['delete'];
                $this->CineDao->delete($id);
                require_once(VIEWS  .'/AdminCine.php');
            }
            
            if (isset($_GET['update'])) {

                $cineUpdate = new Cine();
                $id = $_GET['update'];
        
                $cineUpdate = $this->CineDao->searchById($id);
                
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
        $this->CineDao->delete($_GET['id']);
        
    }
    public function update()
    {
        $this->CineDao->modifyCine($_GET['id']);      
     
    }

    public static function showMessage($messageNumber){

        switch ($messageNumber) {
            case 0:
                return "Agregado correctamente";
                break;
            case 1:
                return "Verifique que los datos no esten repetidos";
                break;
            case 2:
                return "Modificado correctamente";      
                break;
            case 3:
                return "Sin modificacion";
                break;
                case 4:
                return "La capacidad y el valor del ticket deben ser mayor a 0(cero)";
      
                    break;
           
            default:
               

                break;
        }
    }

}
