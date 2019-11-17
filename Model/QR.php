<?php 
namespace Model;



require 'QR/phpqrcode/qrlib.php';

class QR  
{
    
    private $dir;
    private $size;
    private $level;
    private $frameSize;
    private $fileName;//
    private $ticket;//

    public function __construct() {
        $this->dir=$this->setDir();
        $this->size=10;
        $this->level='M';
        $this->frameSize=3;
 
    }
public function getTicket()
{
    return $this->ticket;
}

    public function getDir()
    {
        return $this->dir;
    }
 
    public function getFileName()
    {
        return $this->fileName;
    }
    public function getInformation()
    {
        return $this->information;
    }

    public function setFileName($fileName)
    {
        $this->fileName=$fileName;
    }
    public function setInformation($information)
    {
        $this->information=$information;
    }
   
    public function setTicket($ticket)
    {
        $this->ticket=$ticket;
    }
    
    public function setDir()
    {
        $this->dir='QR/phpqrcode/temp/';
        if (!file_exists($this->dir)) {
           mkdir( $this->dir);
        }
    }

}














?>