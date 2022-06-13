<?php 

abstract class Notification 
{
    public int      $id;
    public string   $title;
    public string   $description;
    public string   $creationDate;
    public string   $icon;

    public function __construct(int $id, string $title, string $description, string $creationDate, string $icon)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creationDate = $creationDate;
        $this->icon = $icon;
    }
}
?>