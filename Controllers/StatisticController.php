<?php
namespace Controllers;

class StatisticController{
    public function showStats(){
        require_once(VIEWS  . '/Statistics.php');
    }
}
?>