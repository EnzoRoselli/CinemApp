<?php
namespace Model;

class Role{

    private $description;
    private $id;
    private static $counter=0;

    public function __construct($description){
        $this->description=$description;
        $this->id=Role::$counter++;
    }

    public function getId(){return $this->id;}
    public function getDescription(){return $this->description;}

    public function setDescription($description){$this->description=$description;}
}


?>