<?php
class Team
{
    private ?int $id;
    private string $name;
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    public function getId():int{
        return $this->id;
    }
}
