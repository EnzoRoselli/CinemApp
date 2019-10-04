<?php 
namespace Interfaces;
require_once ("../Config/Autoload.php");
Use Model\Cine as Cine;
interface IRepository{
    function add(Cine $cine);
    /*function delete();
    function getAll();*/
}
?>