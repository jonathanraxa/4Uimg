<?php

/**
 * Represents a user
 *
 * NOTE: Passwords stored as SHA256 hash, this is *not* secure (but was easy and slightly better than plain text)
 */
class Login {
    private $username;
    private $email;
    private $firstName;
    private $lastName;
    private $type;

    /**
     * Attempt to authenticate the user, initiate logged in session, and returns Login object of user or null on failure
     */
    public static function authenticate($connection, $username, $password) {
        $statement = $connection->prepare("SELECT name, firstname, lastname, email, profile FROM logins WHERE name = ? AND password = SHA2(?, 256);");

        $statement->bind_param("ss", $username, $password);
        $statement->execute();

        $result = new ResultSet($statement);

        $row = $result->fetch_assoc();

        if ($row == null) {
            return null;
        }

        $l = Login::fromResult($row);

        // PHP Whines if a session already exists
        if (session_id() == "") {
            session_start();
        }
        $_SESSION['user'] = $l->username;

        return $l;
    }

    /**
     * Logs out the current user
     *
     * NOTE: assumes there is an existing session
     */
    public static function logout() {
        unset($_SESSION['user']);
    }

    /**
     * Create login user 
     */
    public static function signup($connection, $username, $email, $firstname, $lastname, $type, $password) {
        $l = new Login();
        $l->email = $email;
        $l->firstName = $firstname;
        $l->lastName = $lastname;
        $l->username = $username;
        $l->type = $type;

        $statement = $connection->prepare("INSERT INTO logins (name, email, password, firstname, lastname, profile) VALUES(?, ?, SHA2(?, 256), ?, ?, ?);");

        $statement->bind_param("ssssss", $username, $email, $password, $firstname, $lastname, $type);
        $statement->execute();

        if ($connection->affected_rows != 1) {
            return null;
        } else {
            return $l;
        }
    }

    private static function fromResult($result) {
        $login = new Login();
        $login->username = $result["name"];
        $login->firstName = $result["firstname"];
        $login->lastName = $result["lastname"];
        $login->email = $result["email"];
        $login->type = $result["profile"];
        return $login;
    }

    public static function getByUsername($connection, $username) {
        $statement = $connection->prepare("SELECT name, firstname, lastname, email, profile FROM logins WHERE name = ?");

        $statement->bind_param("s", $username);
        $statement->execute();

        $result = new ResultSet($statement);

        $row = $result->fetch_assoc();

        if ($row == null) {
            return null;
        }

        return Login::fromResult($row);
    }

    /**
     * Return the current logged in user or null
     */
    public static function current($connection) {
        // PHP Whines if a session already exists
        if (session_id() == "") {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            return null;
        }

        $username = $_SESSION['user'];

        $statement = $connection->prepare("SELECT name, firstname, lastname, email, profile FROM logins WHERE name = ?;");

        $statement->bind_param("s", $username);
        $statement->execute();

        $result = new ResultSet($statement);

        $row = $result->fetch_assoc();

        if ($row == null) {
            return null;
        }

        $l = Login::fromResult($row);

        return $l;
    }

    /**
     * Returns true if password change succeeds
     */
    public function changePassword($connection, $oldPassword, $newPassword) {
        $login = Login::authenticate($connection, $this->username, $oldPassword);

        if ($login == null) {
            return false;
        }

        $statement = $connection->prepare("UPDATE logins SET password=SHA2(?, 256) WHERE name=?;");

        $statement->bind_param("ss", $newPassword, $this->username);
        $statement->execute();

        if ($connection->affected_rows != 1) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Update this login object in the database
     */
    public function update($connection) {
        $statement = $connection->prepare("UPDATE logins SET firstname=?, lastname=?, email=?, profile=? WHERE name=?;");

        $statement->bind_param("sssss", $this->firstName, $this->lastName, $this->email, $this->type,  $this->username);
        $statement->execute();

        if ($connection->affected_rows != 1) {
            return false;
        } else {
            return true;
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email){
        if ($this->email != $email) {
            $this->email = $email;
            return true;
        }
        return false;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function setFirstName($firstname) {
        if ($this->firstName != $firstname) {
            $this->firstName = $firstname;
            return true;
        }
        return false;
    }

    public function getLastName() {
        return $this->lastName;
    }
    public function setLastName($lastname) {
        if ($this->lastName != $lastname) {
            $this->lastName = $lastname;
            return true;
        }
        return false;
    }

    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;
    }

    public function getUploads($connection) {
        return Media::getByUploader($connection, $this->username);
    }

    public function getPurchases($connection) {
        return Purchase::getByPurchaser($connection, $this->username);
    }
}

?>
