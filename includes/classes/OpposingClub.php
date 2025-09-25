<?php
class OpposingClub
{
    private string $address;
    private string $city;

    public function __construct($id, $address, $city)
    {
        $this->id = $id;
        $this->address = $address;
        $this->city = $city;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
}