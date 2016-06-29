<?php
// BOUNTY CLASS HANDLES THE ARTWORK REQUESTS MADE BY CUSTOMERS
// AND SHOWS THEM TO THE ARTISTS
class Bounty {
    private $id;
    private $title;
    private $customerLogin;
    private $customer;
    private $licenseType;
    private $priceLow;
    private $priceHigh;
    private $description;

    public static function getBounties($connection) {
        $bounties_query = "SELECT * FROM bounties;";

        $result = $connection->query($bounties_query);

        $bounties = array();
        while ($row = $result->fetch_assoc()) {
            $bounties[] = Bounty::fromResult($row);
        }

        return $bounties;
    }

    public static function fromResult($result) {
        $bounty = new Bounty();
        $bounty->id = $result["id"];
        $bounty->title = $result["title"];
        $bounty->customerLogin = $result["username"];
        $bounty->priceLow = $result["price_low"];
        $bounty->priceHigh = $result["price_high"];
        $bounty->licenseType = $result["license"];
        $bounty->description = $result["description"];

        return $bounty;
    }
    // PUSH ARTWORK REQUEST DATA TO THE DATABASE
    public static function requestArtwork($connection, $title, $customerLogin, $licenseType, $priceLow, $priceHigh, $description) {
        $bounty = new Bounty();
        $bounty->title = $title;
        $bounty->customerLogin = $customerLogin;
        $bounty->priceLow = $priceLow;
        $bounty->priceHigh = $priceHigh;
        $bounty->licenseType = $licenseType;
        $bounty->description = $description;

        $statement = $connection->prepare("INSERT INTO bounties (title, username, license, price_low, price_high, description) VALUES(?,?,?,?,?,?);");

        $statement->bind_param("ssssss", $title, $customerLogin, $licenseType, $priceLow, $priceHigh, $description);

        $statement->execute();

        if ($connection->affected_rows != 1) {
            return null;
        } else {
            // TODO: snag ID of new bounty
            return $bounty;
        }

        return $bounty;
    }

    public function getID() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getCustomerUsername() {
        return $this->customerLogin;
    }
    public function getCustomer($connection) {
        return Login::getByUsername($connection, $this->customerLogin);
    }
    public function getLicenseType() {
        return $this->licenseType;
    }
    public function getPriceLow() {
        return $this->priceLow;
    }
    public function getPriceHigh() {
        return $this->priceHigh;
    }
    public function getDescription() {
        return $this->description;
    }
}
?>
