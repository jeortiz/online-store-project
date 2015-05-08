<?php

class Product {

    private $id;
    private $name;
    private $description;
    private $price;
    private $onSalePrice;
    private $quantity;
    private $image;

    function __construct($_id, $_name, $_description, $_price, $_quantity, $_image, $_onSalePrice) {
        $this->setId($_id);
        $this->setName($_name);
        $this->setDescription($_description);
        $this->setPrice($_price);
        $this->setOnSalePrice($_onSalePrice);
        $this->setQuantity($_quantity);
        $this->setImage($_image);
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($_name) {
        $this->name = $_name;
    }

    public function getName() {
        return $this->name;
    }

    public function setDescription($_description) {
        $this->description = $_description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setPrice($_price) {
        $this->price = $_price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setOnSalePrice($_onSalePrice) {
        $this->onSalePrice = $_onSalePrice;
    }

    public function getOnSalePrice() {
        return $this->onSalePrice;
    }

    public function setQuantity($_quantity) {
        $this->quantity = $_quantity;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setImage($_image) {
        $this->image = $_image;
    }

    public function getImage() {
        return $this->image;
    }
}