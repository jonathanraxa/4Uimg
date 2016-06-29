<?php
// HANDLES ALL PURCHASING ACTIONS DONE BY A CUSTOMER

class Purchase {
    private $purchaseID; // Why have purchase ID at all?
    private $customerUsername;
    private $mediaID;
    private $media;
    private $price;
    private $licenseType;

    public static function purchaseMedia($media, $licenseType, $login) {
        $p = new Purchase();
        $p->customerUsername = $login->getUsername();
        $p->mediaID = $media->getID();
        $p->price = Purchase::getLicensePrice($media, $licenseType);
        $p->licenseType = $licenseType;
        $p->media = $media;
        
        return $p;
    }

    public static function getLicensePrice($media, $licenseType) {
        // Would have been much cleaner to store in DB in separate table keyed by mediaId and licenseType...
        switch ($licenseType) {
        case "web":
            return $media->getWebPrice();
        case "print":
            return $media->getPrintPrice();
        case "unlimited":
            return $media->getUnlimitedPrice();
        default:
            return 0; // FIXME: handle error case, throw appropriate exception
        }
    }

    public static function getByPurchaser($connection, $purchaserUsername) {
        $statement = $connection->prepare("SELECT * FROM purchases WHERE purchaser=?");
        $statement->bind_param("s", $purchaserUsername);

        $statement->execute();

        $result = new ResultSet($statement);

        // XXX: horribly inefficient, 1 + n DB queries
        $purchases = array();
        while ($row = $result->fetch_assoc()) {
            $purchases[] = Purchase::fromResult($row);
        }

        // mysqli doesn't like nested queries, have to have a separate loop
        // TODO: use a proper join query once we can properly handle results with name.field
        foreach ($purchases as $purchase) {
            $purchase->media = Media::getByID($connection, $purchase->mediaID);
        }

        return $purchases;
    }

    private static function fromResult($result) {
        $p = new Purchase();
        $p->customerUsername = $result["purchaser"];
        $p->price = $result["price"];
        $p->mediaID = $result["media"];
        $p->licenseType = $result["license"];

        return $p;
    }

    public function getPurchaseID() {
        return $this->purchaseID;
    }
    public function getCustomerUsername() {
        return $this->customerUsername;
    }
    public function getCustomer($connection) {
        return Login::getByUsername($connection, $this->customerUsername);
    }
    public function getMediaID() {
        return $this->media;
    }
    public function getMedia() {
        return $this->media;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getLicenseType() {
        return $this->licenseType;
    }
}
?>
