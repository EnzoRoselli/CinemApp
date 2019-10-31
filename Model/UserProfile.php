<?php
    namespace Model;

    class UserProfile{

        private $name;
        private $lastName;
        private $dni;
        private $id;
        private static $counter=0;

        public function __construct($name,$lastName,$dni){
            $this->lastName=$lastName;
            $this->name=$name;
            $this->id=UserProfile::$counter++;
        }

        public function getId(){return $this->id;}
        public function getName(){return $this->name;}
        public function getLastName(){return $this->lastName;}
        public function getDni(){return $this->dni;}

        public function setName($name){$this->name=$name;}
        public function setLastName($lastName){$this->lastName=$lastName;}
        public function setDni($dni){$this->dni=$dni;}
    }
?>