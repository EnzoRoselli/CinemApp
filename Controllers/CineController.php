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

    public function determinateUpdateCreate($id, $name, $adress, $capacity, $ticketValue)
    {
        var_dump($GLOBALS);
        if ($id){
            if ($id != "") {
                $this->update($id, $name, $adress, $capacity, $ticketValue);
            } else if ($id == "") {
                $this->create($name, $adress, $capacity, $ticketValue);
            }
        }
    }

    public function create($name, $adress, $capacity, $ticketValue)
    {
        $advices = array();

        $cine = new Cine($name, $adress, $capacity, $ticketValue);

        $cine->setActive(true);

        if ($this->checkNotEmptyParameters($cine)) {
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
        $advices = array();

        $modifiedCinema = new Cine($name, $adress, $capacity, $ticketValue);
        $modifiedCinema->setId($id);


        if ($this->checkNotEmptyParameters($modifiedCinema)) {
            try{
                $this->CineDao->modify($modifiedCinema);
                array_push($advices, MODIFIED);

            }catch (\Throwable $th) {
                array_push($advices, DB_ERROR);

            } finally {
                $cines = $this->CineDao->getAll();
                require_once(VIEWS  . '/AdminCine.php');
            }


           /* try {
                $cinemaToBeModified = $this->CineDao->searchById($id);
                if ($cinemaToBeModified->getName() == $modifiedCinema->getName() && $cinemaToBeModified->getAddress() == $modifiedCinema->getAddress()) {
                    $this->CineDao->modify($modifiedCinema);
                    array_push($advices, MODIFIED);
                } else {
                    if (!$this->CineDao->exists($modifiedCinema)) {
                        $this->CineDao->modify($modifiedCinema);
                        array_push($advices, MODIFIED);
                    } else {
                        array_push($advices, SIN_MODIFICACION);
                    }
                }
            } catch (\Throwable $th) {
                array_push($advices, DB_ERROR);
            } finally {
                $cines = $this->CineDao->getAll();

                require_once(VIEWS  . '/AdminCine.php');
            }*/
        } else {
            $cines = $this->CineDao->getAll();

            array_push($advices, CAMPOS_INVALIDOS);
            require_once(VIEWS  . '/AdminCine.php');
        }
    }

    /* public function showAdminCine($message = array())
    {
        require_once(VIEWS  . '/AdminCine.php');
    }*/

    public function showCinemas(){
        $cines = $this->CineDao->getAll();
        require_once(VIEWS  . '/AdminCine.php');
    }

    public function executeAction($action, $id)
    {
        switch($action){
            case 'delete':
                $this->CineDao->delete($id);
            //    array_push($advices, ELIMINATED);
                break;
            case 'update':
                $cineUpdate = new Cine();
                $cineUpdate = $this->CineDao->searchById($id);
                echo "<script type='text/javascript'>window.addEventListener('load', function() { overlay.classList.add('active'); popup.classList.add('active');}) </script>";
                
                break;

            case 'delete':
            $this->CineDao->delete($id);
        //    array_push($advices, ELIMINATED);
            break;

            case 'delete':
            $this->CineDao->delete($id);
        //    array_push($advices, ELIMINATED);
            break;
        }
        



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


}
