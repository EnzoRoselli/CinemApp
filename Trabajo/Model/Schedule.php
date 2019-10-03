<?php
namespace Model;

require_once("../Config/Autoload.php");

class Schedule{

    private $day;
    private $hour;
    private $id;
    private static $counter = 0;

    public function __construct($day,$hour){

        $this->day=$day;
        $this->hour=$hour;
        $this->id=Schedule::$counter++;
    }

    public function getId(){ return $this->id;}
    public function getDay(){return $this->day;}
    public function getHour(){return $this->hour;}

    public function setDay($day){$this->day=$day;}
    public function setHour($hour){$this->hour=$hour;}
}
?>