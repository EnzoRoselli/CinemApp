<?php 
namespace DAO;

Use Model\Cine as Cine;

interface IRepository{

    function add(Cine $cine);
    
    /*function delete();
    function getAll();*/

}
?>