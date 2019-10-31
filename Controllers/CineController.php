<?php

namespace Controllers;

use Model\Cine as Cine;
use DAO\CinemasDAO as daoCine;


class CineController
{

    private $CineDao;
    public function __construct()
    {
        $this->CineDao = new daoCine();
    }

    public function apretarBotonUpdate(){


        $cineUpdate =$this->CineDao->searchById($_GET['update']);
     
        
        echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})                </script>";
        $this->showCinemasOnTable($cineUpdate);
    }   

   

    public function determinateUpdateCreate($id, $name, $adress, $capacity, $ticketValue)
    {
        

        //$id = $_POST['id'];
        //var_dump($id, $name, $adress, $capacity, $ticketValue);
        //if ($_GET) {
            
          //  if ($id != "") {
                $this->update($id, $name, $adress, $capacity, $ticketValue);
          //  } else if ($id == "") {
                //$this->create();
         //   }
        //}
    }

    public function create()
    {

        $advices = array();
        $name = $_POST[CINE_NAME];
        $adress = $_POST[CINE_ADDRESS];
        $capacity = $_POST[CINE_CAPACITY];
        $price = $_POST[CINE_TICKETVALUE];

        $cine = new Cine($name, $adress, $capacity, $price);
        $cine->setActive(true);

        if ($cine->testValuesValidation()) {
            try {
                if (!$this->CineDao->exists($cine)) {
                    $this->CineDao->add($cine);
                    array_push($advices, ADDED);
                } else {
                    array_push($advices, EXISTS);
                }
            } catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            } finally {
                $cines = $this->CineDao->getAll();

                require_once(VIEWS  . '/AdminCine.php');
            }
        } else {
            $cines = $this->CineDao->getAll();           
            array_push($advices, CAMPOS_INVALIDOS);
            require_once(VIEWS  . '/AdminCine.php');
        }
    }

    public function update($id, $name, $adress, $capacity, $ticketValue)
    {
        $cinemaToModify = new Cine($name, $adress, $capacity, $ticketValue);
        $cinemaToModify->setId($id); 
        $advices = array();
        

         if ($this->checkNotEmptyParameters($cinemaToModify)){ //Si los campos son correctos
            
            try {
                
                    $cinemaPreModification = $this->CineDao->searchById($id);
                    //Para comparar el nombre y dirección del cine antes de la modificación
                    
                if ($cinemaPreModification->getName() == $cinemaToModify->getName() 
                    && $cinemaPreModification->getAddress() == $cinemaToModify->getAddress()) {
                        //Si el cine nuevo (modificado) y el viejo (sin modificar) son iguales no hace nada
                        
                        array_push($advices, SIN_MODIFICACION);
                }else {
                    
                        if ($this->CineDao->exists($cinemaToModify)) {
                            //Si el cine nuevo ya existe en la base no hace nada
                            array_push($advices, SIN_MODIFICACION);
                        

                        } else {
                            //Caso de éxito lo agrega
                            
                            $this->CineDao->modify($cinemaToModify);
                            array_push($advices, MODIFIED);
                        }
                    }
            }catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            }
        } else {   
               array_push($advices, CAMPOS_INVALIDOS);
        }
        $this->showCinemasOnTable();
    }


    /* public function showAdminCine($message = array())
    {
        require_once(VIEWS  . '/AdminCine.php');
    }*/


    public function showCinemaMenu()
    {
        $advices = array();
        try {
            $cines = $this->CineDao->getAll();

            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $this->CineDao->delete($id);
                array_push($advices, ELIMINATED);
            } else if (isset($_GET['update'])) {
                $cineUpdate = new Cine();
                $id = $_GET['update'];
                $cineUpdate = $this->CineDao->searchById($id);
                echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');})                </script>";
            } else if (isset($_GET['activate']) || isset($_GET['desactivate'])) {

                if (isset($_GET['activate'])) {

                    $this->activate($_GET['activate']);
                    array_push($advices, DESACTIVATED);
                } else {
                    $this->desactivate($_GET['desactivate']);
                    array_push($advices, ACTIVATED);
                }
            }
        } catch (\Throwable $th) {
            array_push($advices, DB_ERROR);
        } finally {
            $cines = $this->CineDao->getAll();
            require_once(VIEWS  . '/AdminCine.php');
        }
    }

    public function delete()
    {
        try {
            if (!empty($this->CineDao->searchById($_GET['id']))) {
                $this->CineDao->delete($_GET['id']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function activate($id)
    {
        try {
            if (!empty($this->CineDao->searchById($id))) {
                $this->CineDao->activate($id);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function desactivate($id)
    {
        try {
            if (!empty($this->CineDao->searchById($id))) {
                $this->CineDao->desactivate($id);

            } 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function checkNotEmptyParameters($cine)
    {
        if (!empty($cine->getName()) && !empty($cine->getAddress())&& !empty($cine->getCapacity()) && $cine->getCapacity()>0 && !empty($cine->getTicketValue()) && $cine->getTicketValue()>0){return true;}
        else{return false;}
    }

     /*
        @param cineUpdate: en caso de que quieras abrir el pop-up para modificar 
                           llena los campos para su modificación
    */ 
    public function showCinemasOnTable($cineUpdate=""){
        $cines = $this->CineDao->getAll();         
        require_once(VIEWS  . '/AdminCine.php');
    }

}
