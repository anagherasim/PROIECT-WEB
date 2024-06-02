<?php

class Produse {
  private $id;
  private $descriere;
  private $cantitate;

  public function __construct($id, $descriere,$cantitate) {
    $this->id = $id;
    $this->descriere = $descriere;
    $this->cantitate = $cantitate;
  }

  public function getId() {
    return $this->id;
  }


  public function getDescriere() {
    return $this->descriere;
  }

  public function getCantitate()
    {
        return $this->cantitate;
    }

    public function setCantitate($cantitate)
    {
        $this->cantitate = $cantitate;
    }

}

?>