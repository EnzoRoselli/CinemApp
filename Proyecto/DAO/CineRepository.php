<?php

namespace DAO;

require_once("../Config/Autoload.php");
Use Config\Autoload as Autoload;
use DAO\IRepository as IRepository;
use Model\Cine as Cine;


Autoload::start();

define("FILE_DIR", '../Data/cine.json');
define('CINE_ID', 'id');
define('CINE_NAME', 'name');
define('CINE_ADRESS', 'adress');
define('CINE_CAPACITY', 'capacity');
define('CINE_TICKETVALUE', 'ticketValue');
/*mandar al config.php*/

class CineRepository implements IRepository
{

    private $cineList = array();

    public function add(Cine $cine)
    {
        $this->getData();

        if($this->exists($cine)){
            echo 'Se encuentra <br>';
        }else{
            $this->fixId($cine);
            array_push($this->cineList, $cine);

            $this->saveData();
        }
            
    }

    public function exists($cine){
        $flag = false;
            for ($i = 0; $i < count($this->cineList) && !$flag; $i++) {
                if ($this->cineList[$i]->equals($cine)) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            return $flag;
    }

    public function delete(Cine $cine)
    {

        if (($key = array_search($cine, $this->cineList)) !== false) {
            unset($this->cineList[$key]);
            echo 'lo borro';
        }

        $this->saveData();
    }

    public function saveData()
    {
        $arrayToEncode = array();
        $valueArray = array();

        foreach ($this->cineList as $aux) {
            
            $valueArray[CINE_ID] = $aux->getId();
            $valueArray[CINE_NAME] = $aux->getName();
            $valueArray[CINE_ADRESS] = $aux->getAdress();
            $valueArray[CINE_CAPACITY] = $aux->getCapacity();
            $valueArray[CINE_TICKETVALUE] = $aux->getTicketValue();

            array_push($arrayToEncode, $valueArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents('../Data/cine.json', $jsonContent);
    }

    public function getData()
    {
        $this->cineList=array();
        if (file_exists(FILE_DIR)) {
            $jsonContent = file_get_contents(FILE_DIR);

            $arrayToDecode = array();

            if ($jsonContent) {
                $arrayToDecode = json_decode($jsonContent, true);
            }
           
            foreach ($arrayToDecode as $valueArray) {
               
                $aux = new Cine($valueArray[CINE_NAME], $valueArray[CINE_ADRESS], $valueArray[CINE_CAPACITY], $valueArray[CINE_TICKETVALUE]);
                 $aux->setId($valueArray[CINE_ID]);

                array_push($this->cineList, $aux);
            }
        }
    }

    public function getAll()
    {
        $this->getData();
        foreach ($this->cineList as $aux) {
            echo '<pre>';
            var_dump($aux);
            echo '<pre>';
        }
    }

    public function fixId(Cine $cine){

        $id=0;

        if(empty($this->cineList)){
            $cine->setId(1);
        }else{
            foreach($this->cineList as $value){
                if($value->getId() > $id){
                    
                    $id=$value->getId();
                }
            }
            $cine->setId($id+1);
        }
    }


    
}
