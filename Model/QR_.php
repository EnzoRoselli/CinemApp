<?php 
namespace Model;

class QR_ 
{
    
  
    private $size;
    private $level;
    private $frameSize;
    private $fileName;
    private $ticket;

    public function __construct() {
        $this->size=10;
        $this->level='M';
        $this->frameSize=3;
    }
    
    public function getSize()
    {
        return $this->size;
    }
    public function getLevel()
    {
        return $this->level;
    }
    public function getFrameSize()
    {
        return $this->frameSize;
    }

    public function getTicket()
    {
    return $this->ticket;
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
    
    

}
