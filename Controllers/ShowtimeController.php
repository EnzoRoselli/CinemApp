<?php
namespace Controllers;

use Model\Showtime as Showtime;
use DAO\ShowtimesDAO as ShowtimeDAO;
use DAO\CinemasDAO as CinemasDAO;
use DAO\MoviesDAO as MoviesDAO;
use DAO\LanguagesDAO as LanguagesDAO;
//VALIDAR QUE LOS DATOS DE LA FUNCIONN YA NO ESTEN CARGADOS, OSEA A LA MISMA HORA, MISMO CINE
class ShowtimeController{

    private $showtimeDao;
    private $cinemasDAO;
    private $moviesDAO;
    private $languagesDAO;


    public function __construct()
    {
        $this->showtimeDao = new ShowtimeDAO();
        $this->cinemasDAO= new CinemasDAO();
        $this->moviesDAO= new MoviesDAO();
        $this->languagesDAO= new LanguagesDAO();
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

        $cinema = $this->cinemasDAO->searchById($_POST['idCinema']);
        $movie = $this->moviesDAO->searchById($_POST['idMovie']);
        $language = $this->languagesDAO->searchByName($_POST['nameLanguage']);
        $subtitled = null;

        if(isset($_POST['subtitle']) && $_POST['subtitle']!="")
        {
            $subtitled = 1;
        }else{
            $subtitled = 0;
        }
        
        $showtime = new Showtime($movie,$cinema, $_POST['date'], $_POST['hour'], $language, $subtitled);
        $showtime->setActive(true);
        $showtime->setTicketAvaliable($cinema->getCapacity());
        
        try {
            
            $this->showtimeDao->add($showtime);
           
            $this->showShowtimeMenu();
                    
        } catch (\Throwable $th) {
            echo $th->getMessage();
   
        }

}

    public function showShowtimeMenu(){
        try {
           $cinemasList = $this->cinemasDAO->getAll();
            $moviesList = $this->moviesDAO->getAll();
            
            $languagesList = $this->languagesDAO->getAll();
            $showtimes=$this->showtimeDao->getAll();
        } catch (\Throwable $th) {
            $advice = ShowtimeController::showMessage("DB");
        }finally{
            require_once(VIEWS . "/AdminShowtimes.php");
        }
        
    }

    public function delete()
    {try {
        if (!empty($this->showtimeDao->searchById($_GET['id']))) {
            $this->showtimeDao->delete($_GET['id']);
            $advice=ShowtimeController::showMessage(5);
        }
    } catch (\Throwable $th) {
        $advice=ShowtimeController::showMessage("DB");
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