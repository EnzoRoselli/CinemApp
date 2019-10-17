<?php

namespace DAO;

use DAO\IRepository as IRepository;
use Model\Cine as Cine;

define("FILE_DIR", JSON ."/cine.json");

/*mandar al config.php*/

class CineRepository implements IRepository
{

    private $cineList = array();

    public function add(Cine $cine)
    {
        $this->getData();

        if($this->existsNameAndAdress($cine->getName(), $cine->getAdress())){
           
            return false;
        }else{
            $this->fixId($cine);
            array_push($this->cineList, $cine);

            $this->saveData();

            return true;
        }
            
    }

    public function existsId($id){
        $flag = false;
       
        foreach ($this->cineList as $key) {
            if($key->getId() == $id){
                $flag=true;
                break;
            }
        }
            return $flag;
    }

    public function existsNameAndAdress($name, $adress){
        $flag = false;
       
        foreach ($this->cineList as $key) {
            if($key->getName()===$name && $key->getAdress()===$adress){
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


        if($this->existsId($id)){
            foreach ($this->cineList as $cine) {
                if($cine->getId() == $id){
                    return $cine;
                    break;
                }
            }
        }

        return null;
    }

    public function modifyCine($cine){
        
        $this->getData();
        $cineToModify = $this->searchById($cine->getId());

        if($cineToModify  !== null){
            
            if($cineToModify->getName() !== ""){

                $cineToModify->setName($cine->getName());
            }

            if($cineToModify->getAdress() !== ""){

                $cineToModify->setAdress($cine->getAdress());
            }

            if($cine->getCapacity() !== ""){

                $cineToModify->setCapacity($cine->getCapacity());
            }

            if($cine->getTicketValue() !== ""){

                $cineToModify->setTicketValue($cine->getTicketValue());
            }
            
            if (($key = array_search($this->searchById($cine->getId()), $this->cineList)) !== false) {

                $this->cineList[$key]=$cineToModify;
                $this->saveData();

                return true;
    
            }
        }
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

        file_put_contents(JSON ."/cine.json", $jsonContent);
    }

    public function getData($allCine=null)
    {
       
        $this->cineList=array();
          
        if (file_exists(JSON ."/cine.json")) {
         
            $jsonContent = file_get_contents(JSON ."/cine.json");

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

    public function getAll() {
  
        $this->getData();

        return $this->cineList;
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
