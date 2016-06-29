<?php
// HANDLES ALL THE IMAGES/VIDEOS UPLOADED AND RETRIEVED FROM THE DATABASE
// THIS RANGES FROM INFORMATION ABOUT THE IMAGES TO THE OWNER OF THE ARTWORK

class Media {
    private $id;
    private $mime;
    private $title;
    private $artistUsername;
    private $width;
    private $height;
    private $extension;
    private $previewID;
    private $preview;
    private $unlimitedPrice;
    private $webPrice;
    private $printPrice;
    private $description;

    public static function uploadImage($connection, $image, $title, $unlimitedPrice, $webPrice, $printPrice, $description) {
        $src = $image['tmp_name'];
        $sname = $image['name'];

        $original = GDImage::read($src);

        $media = new Media();
        $media->title = $title;
        $media->mime = $original->getMime();
        $media->width = $original->getWidth();
        $media->height = $original->getHeight();
        $media->webPrice = $webPrice;
        $media->printPrice = $printPrice;
        $media->unlimitedPrice = $unlimitedPrice;
        $media->description = $description;

        $extension = $original->getExtension();

        $currentUser = Login::current($connection);

        $query = $connection->prepare("INSERT INTO media (mime, title, uploader, width, height, extension, unlimited_price, web_price, print_price, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $query->bind_param("ssssssssss", $media->mime, $media->title, $currentUser->getUsername(), $media->width, $media->height, $extension, $unlimitedPrice, $webPrice, $printPrice, $description);

        $query->execute();

        if ($connection->affected_rows != 1) {
            return null;
        } else {
            $media->id = $connection->insert_id;
            // FIXME: "image store" should be hoisted out of here
            if (!move_uploaded_file($src, "images/original/" . $media->id . "." . $extension)) {
                return null;
            }

            return $media;
        }
    }

    public static function uploadVideo($connection, $videoFile, $displayImageFile, $title, $unlimitedPrice, $webPrice, $printPrice, $description) {
        $media = new Media();
        $media->mime = get_mime_type($videoFile['tmp_name']);

        // Must do the above before uploadImage() because it moves the image
        $preview = Media::uploadImage($connection,
                                      $displayImageFile, "PREVIEW",
                                      0, 0, 0,
                                      "Preview Image");

        if ($preview == null) {
            return null;
        }

        $src = $videoFile['tmp_name'];
        $sname = $videoFile['name'];

        $media->title = $title;
        $media->webPrice = $webPrice;
        $media->printPrice = $printPrice;
        $media->unlimitedPrice = $unlimitedPrice;
        $media->description = $description;
        $media->preview = $preview;
        $media->previewID = $preview->getID();

        $file_info = pathinfo($videoFile['name']);
        $media->extension = $extension = $file_info['extension'];

        $currentUser = Login::current($connection);

        $query = $connection->prepare("INSERT INTO media (preview, mime, title, uploader, extension, unlimited_price, web_price, print_price, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $query->bind_param("sssssssss", $preview->getID(), $media->mime, $media->title, $currentUser->getUsername(), $extension, $unlimitedPrice, $webPrice, $printPrice, $description);

        $query->execute();

        if ($connection->affected_rows != 1) {
            return null;
        } else {
            $media->id = $connection->insert_id;
            // FIXME: "image store" should be hoisted out of here
            if (!move_uploaded_file($src, "images/original/" . $media->id . "." . $extension)) {
                return null;
            }

            return $media;
        }

    }

    // TODO: fix/implement related record access
    // FIXME: Smells funny to expose this publicly, needed by Purchase::getByPurchaser()
    public static function fromResult($connection, $result) {
        $media = new Media();
        $media->id = $result["id"];
        $media->mime = $result["mime"];
        $media->title = $result["title"];

        $media->artistUsername = $result["uploader"];
        
        $media->width = $result["width"];
        $media->height = $result["height"];

        $media->extension = $result["extension"];

        $media->unlimitedPrice = $result["unlimited_price"];
        $media->webPrice = $result["web_price"];
        $media->printPrice = $result["print_price"];

        $media->description = $result["description"];

        $media->previewID = $result["preview"];

        if ($media->previewID == null || $media->previewID == $media->id) {
            $media->preview = $media;
        } else {
            $media->preview = null;
        }

        return $media;
    }

    public static function search($connection, $keywords) {
        $search = new ImageSearch();

        foreach ($keywords as $keyword) {
            $search->addCriteria(keywordClause($keyword));
        }

        $statement = $search->prepare($connection);
        $statement->execute();

        $result = new ResultSet($statement);    

        $media = array();
        while ($row = $result->fetch_assoc()) {
            $media[] = Media::fromResult($connection, $row);
        }
        return $media;
    }

    public static function getFeatured($connection) {
        $featured_query = "SELECT * FROM media ORDER BY media.id <> 'PREVIEW' DESC LIMIT 6";

        $result = $connection->query($featured_query);

        $media = array();
        while ($row = $result->fetch_assoc()) {
            $media[] = Media::fromResult($connection, $row);
        }

        return $media;
    }

    public static function getAll($connection) {
        $result = $connection->query("SELECT * FROM media WHERE title <> 'PREVIEW' ORDER BY media.id");

        $media = array();
        while ($row = $result->fetch_assoc()) {
            $media[] = Media::fromResult($connection, $row);
        }

        return $media;
    }

    public static function getByUploader($connection, $uploaderUsername) {
        $statement = $connection->prepare("SELECT * FROM media WHERE uploader=? AND title <> 'PREVIEW';");
        $statement->bind_param("s", $uploaderUsername);

        $statement->execute();

        $result = new ResultSet($statement);

        $media = array();
        while ($row = $result->fetch_assoc()) {
            $media[] = Media::fromResult($connection, $row);
        }

        return $media;
    }

    public static function getByID($connection, $id) {
        $statement = $connection->prepare("SELECT * FROM media WHERE id = ?;");

        $statement->bind_param("s", $id);
        $statement->execute();

        $result = new ResultSet($statement);

        $row = $result->fetch_assoc();

        if ($row == null) {
            return null;
        }

        return Media::fromResult($connection, $row);
    }

    public function isVideo() {
        switch ($this->mime) {
        case "application/x-troff-msvideo":
        case "video/avi":
        case "video/msvideo":
        case "video/x-msvideo":
        case "audio/mpeg":
        case "video/divx":
        case "video/ogg":
            return true;
        default:
            return false;
        }
    }

    public function getID() {
        return $this->id;
    }
    public function getMime() {
        return $this->mime;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
    }

    public function getArtistUsername() {
        return $this->artistUsername;
    }
    public function getArtist($connection) {
        return Login::getByUsername($connection, $this->artistUsername);
    }
    public function getWidth() {
        return $this->width;
    }
    public function getHeight() {
        return $this->height;
    }
    public function getExtension() {
        return $this->extension;
    }

    public function setUnlimitedPrice($unlimitedPrice) {
        $this->unlimitedPrice = $unlimitedPrice;
    }
    public function getUnlimitedPrice() {
        return $this->unlimitedPrice;
    }

    public function setWebPrice($webPrice) {
        $this->webPrice = $webPrice;
    }
    public function getWebPrice() {
        return $this->webPrice;
    }

    public function setPrintPrice($printPrice) {
        $this->printPrice = $printPrice;
    }
    public function getPrintPrice() {
        return $this->printPrice;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getDisplayImage($connection) {
        if ($this->preview == null) {
            $this->preview = Media::getByID($connection, $this->previewID);
        }
        return $this->preview;
    }

    public function update($connection) {
        $query = $connection->prepare("UPDATE media SET mime=?, title=?, uploader=?, width=?, height=?, extension=?, unlimited_price=?, web_price=?, print_price=?, description=? WHERE id=?;");
        $query->bind_param("sssssssssss", $this->mime, $this->title, $this->artistUsername, $this->width, $this->height, $this->extension, $this->unlimitedPrice, $this->webPrice, $this->printPrice, $this->description, $this->id);

        $query->execute();
    }

    public function setKeywords($connection, $keywords) {
        $keyword_delete = $connection->prepare("DELETE FROM media_keywords WHERE media = ?");
        $keyword_delete->bind_param("s", $this->id);
        $keyword_delete->execute();

        $keyword_insert = $connection->prepare("INSERT IGNORE INTO keywords (keyword, spelling, weight) VALUES(?, ?, 100);");

        $media_keyword_insert = $connection->prepare("INSERT IGNORE INTO media_keywords (media, keyword) VALUES(?, ?);");

        foreach ($keywords as $keyword) {
            $keyword_insert->bind_param("ss", $keyword, $keyword);
            $keyword_insert->execute();

            $media_keyword_insert->bind_param("ss", $this->id, $keyword);
            $media_keyword_insert->execute();
        }
    }

    public function getKeywords($connection) {
        $keyword_query = $connection->prepare("SELECT k.keyword FROM keywords as k JOIN media_keywords as mk ON mk.keyword = k.keyword WHERE mk.media = ?;");
        $keyword_query->bind_param("s", $this->id);

        $keyword_query->execute();

        $results = new ResultSet($keyword_query);

        $keywords = array();
        while ($result = $results->fetch_assoc()) {
            $keywords[] = $result["keyword"];
        }
        return $keywords;
    }
}

?>
