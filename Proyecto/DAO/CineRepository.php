<?php

namespace DAO;

require_once("../Config/Autoload.php");
Use Config\Autoload as Autoload;
use DAO\IRepository as IRepository;
use Model\Cine as Cine;

include ('../Config/Constants/CineConstants.php');

Autoload::start();

define("FILE_DIR", '../Data/cine.json');

/*mandar al config.php*/

class CineRepository implements IRepository
{

    private $cineList = array();

    public function add(Cine $cine)
    {
        $this->getData();

        if($this->exists(null, $cine->getName(), $cine->getAdress())){
            echo "<script> if(confirm('Verifique que los datos sean correctos'));";
            echo "window.location ='../Views/AdminCine.php'; </script>";
        }else{
            $this->fixId($cine);
            array_push($this->cineList, $cine);

            $this->saveData();
            echo "<script> if(confirm('Agregado correctamente'));";
            echo "window.location ='../Views/AdminCine.php'; </script>";
        }
            
    }

    public function exists($id=null, $name=null, $adress=null){
        $flag = false;
       
        foreach ($this->cineList as $key) {
            if($key->getId() == $id || ($key->getName()===$name && $key->getAdress()===$adress)){
                $flag=true;
                break;
            }
        }
            return $flag;
    }

    public function delete($id)
    {
        $cine= $this->searchById($id);

        if (($key = array_search($cine, $this->cineList)) !== false) {
            $this->cineList[$key]->setActive(false);

        }
    
        $this->saveData();
    }

    public function searchById($id){


        if($this->exists($id)){
            foreach ($this->cineList as $key) {
                if($key->getId() == $id){
                    return $key;
                    break;
                }
            }
        }

        return null;
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
            $valueArray[CINE_ACTIVE] = $aux->getActive();

            array_push($arrayToEncode, $valueArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents('../Data/cine.json', $jsonContent);
    }

    public function getData($allCine=null)
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
                $aux->setActive($valueArray[CINE_ACTIVE]);
                array_push($this->cineList, $aux);
            }
        }
    }

    public function getAll()
    {
  
    $this->getData();
        return $this->cineList;
        // foreach ($this->cineList as $aux) {
        //     echo '<pre>';
        //     var_dump($aux);
        //     echo '<pre>';
        // }
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
