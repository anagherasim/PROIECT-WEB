<?php

require_once 'clasaproduse.php';

class Cos {
    private $items = array();

    public function __construct(){
        $this->items=array();
    }

    public function addItems(Produse $produs, $quantity = 1) {
        $found = false;
        foreach ($this->items as &$item) {
            if ($item->getId() == $produs->getId()) {
                $item->setCantitate($item->getCantitate() + $quantity);
                $found = true;
                break;
            }
        }
        if (!$found) {
            $produs->setCantitate($quantity);
            $this->items[] = $produs;
        }
    }

    public function getItems() {
        return $this->items;
    }

    public function deleteItem($productId) {
        $this->items = array_filter($this->items, function ($produs) use ($productId) {
            return $produs->getId()!= $productId;
        });
    }
    public function removeItem($key) {

        unset($this->items[$key]);
    }
}
?>