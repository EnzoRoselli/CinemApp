<?php
namespace Controllers;

use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\CinemasDAO;
//VALIDAR QUE LOS DATOS DE LA FUNCIONN YA NO ESTEN CARGADOS, OSEA A LA MISMA HORA, MISMO CINE
class ShowtimeController{

    private $showtimeDao;
    private $CinemasDAO;


    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
        $this->CinemasDAO= new CinemasDAO();
    }

    public function determinateUpdateCreate()
    {
        if ($_POST) {
            if ($_POST[SHOWTIME_ID] != "") {
         
                $this->update();

            } else if ($_POST[SHOWTIME_ID] == "") {
           
                $this->create();
            }
          
        }
    }

    public function create()
    {
      
        $cinema = $_POST[SHOWTIME_CINEMA];
        $movie = $_POST[SHOWTIME_MOVIE];
        $date = $_POST[SHOWTIME_DATE];
        $hour = $_POST[SHOWTIME_HOUR];
        $language = $_POST[SHOWTIME_LANGUAGE];
        $subtitles = $_POST[SHOWTIME_SUBTITLE];

        $showtime = new Showtime($cinema, $movie, $date, $hour, $language, $subtitles);
        $showtime->setActive(true);
      
        if ($showtime->testValuesValidation()) {
           
        try {
            
            $cinemaToSet=$this->CinemasDAO->searchById($_POST[SHOWTIME_CINEMA]);
            if (!empty($cinemaToSet)) {
               //VALIDAR QUE LA FUNCION NO EXISTA YA, O QUE NO SE DE EN UN TIEMPO DONDE ESTÉ OTRA
                $this->showtimeDao->add($showtime);
                $advice =  ShowtimeController::showMessage(0);
                $this->showShowtimeMenu();
            }else {
               $advice =  ShowtimeController::showMessage(1);
               $this->showShowtimeMenu();
            }
              
 
                  
           
             
             
        } catch (\Throwable $th) {
         echo $th->getMessage();
            $advice=ShowtimeController::showMessage("DB");;
        }
    } else {
        $advice = ShowtimeController::showMessage(4);
       // $this->showShowtimeMenu(); 
    }
    }

    public function showShowtimeMenu(){
        require_once(VIEWS . "/AdminShowtimes.php");
    }

    public function delete()
    {try {
        if (!empty($this->showtimeDao->searchById($_GET['id']))) {
            $this->showtimeDao->delete($_GET['id']);
            $advice=ShowtimeController::showMessage(5);;
        }
    } catch (\Throwable $th) {
        $advice=ShowtimeController::showMessage("DB");;
    }
      
    }
    public function update()
    {
        try {
            if (!empty($this->showtimeDao->searchById($_GET['id']) )) {
                $this->showtimeDao->modify($_GET['id']);
                $advice=ShowtimeController::showMessage(2);
            }else {
                $advice=ShowtimeController::showMessage(3);
            }    
        } catch (\Throwable $th) {
            $advice=ShowtimeController::showMessage("DB");

        }
        
    }

    public function activate($id)
    {
        try {
            if (!empty($this->showtimeDao->searchById($id))) {
                $this->showtimeDao->activate($id);
                $advice=ShowtimeController::showMessage("activado");
            }else {
                $advice=ShowtimeController::showMessage(3);
            }
        } catch (\Throwable $th) {
            $advice=ShowtimeController::showMessage("DB");

        }
        
    }

    public function desactivate($id)
    {
try {
    if (!empty($this->showtimeDao->searchById($id))) {
        $this->showtimeDao->desactivate($id);
        $advice=ShowtimeController::showMessage("desactivado");
    }else {
        $advice=ShowtimeController::showMessage(3);

    }
} catch (\Throwable $th) {
    $advice=ShowtimeController::showMessage("DB");

}
        
    }

    public static function showMessage($messageNumber)
    {

        switch ($messageNumber) {
            case 0:
                return "Agregado correctamente";
                break;
            case 1:
                return "Verifique que los datos no esten repetidos";
                break;
            case 2:
                return "Modificado correctamente";
                break;
            case 3:
                return "Sin modificacion";
                break;
                case 4:
                    return "No se encuentra el cine";break;
           case "DB":
                return "Error al procesar la query"; break;
                case 5:
                    return "Eliminado correctamente";
                    break;
                    case 'activado':
                        return "Se activó";
                        break;
                        case 'desactivado':
                        return "Se activó";
                        break;
            default:
                break;
        }
    }

}
?>