
<?php
class ExceptionController extends Exception {

 function checkTitle($title) {
  if($title==null) {
    throw new Exception("No existe pelicula registrada con el titulo ingresado");
  }
  return true;
} 
}
?> 