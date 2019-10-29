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

    public function determinateUpdateCreate()
    {
        if ($_POST) {
            if ($_POST[CINE_ID] != "") {
                $this->update();
            } else if ($_POST[CINE_ID] == "") {
                $this->create();
            }
        }
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

    public function update()
    {
        $advices = array();
        $updatedId = $_POST[CINE_ID];
        $updatedName = $_POST[CINE_NAME];
        $updatedAddress = $_POST[CINE_ADDRESS];
        $updatedCapacity = $_POST[CINE_CAPACITY];
        $updatedPrice = $_POST[CINE_TICKETVALUE];

        $modifiedCinema = new Cine($updatedName, $updatedAddress, $updatedCapacity, $updatedPrice);
        $modifiedCinema->setId($updatedId);

        if ($modifiedCinema->testValuesValidation()) {
            try {
                $cinemaToBeModified = $this->CineDao->searchById($updatedId);
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
            }
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


}
