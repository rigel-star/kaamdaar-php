<?php 
namespace Model;

class RequestNotification
{
    public $id;
    public $request;
    public $user;
    
    public function __construct($id, $request, $user)
    {
        $this->id = $id;
        $this->request = $request;
        $this->user = $user;
    }
}
?>