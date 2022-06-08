<?php
namespace Model;

class Request 
{
    public $id;
    public $location;
    public $latlon;
    public $type;
    public $status;
    public $time;
    public $uid;

    public function __construct($id, $location, $latlon, $type, $status, $time, $uid)
    {
        $this->id = $id;
        $this->location = $location;
        $this->latlon = $latlon;
        $this->type = $type;
        $this->status = $status;
        $this->time = $time;
        $this->uid = $uid;
    }
}
?>