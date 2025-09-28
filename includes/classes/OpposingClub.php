<?php
class OpposingClub
{
    private ?int $id;
    private string $address;
    private string $city;

    public function __construct($address, $city, ?int $id = null)
    {
        $this->id = $id;
        $this->address = $address;
        $this->city = $city;
    }

    public function getId(): ?int
    {
        return $this->id;
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