<?php
class Users {
  private $pdo = null;
  private $stmt = null;

  function __construct () {
  // __construct() : connect to the database
  // PARAM : DB_HOST, DB_CHARSET, DB_NAME, DB_USER, DB_PASSWORD

    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ]
      );
      return true;
    } catch (Exception $ex) {
      $this->CB->verbose(0, "DB", $ex->getMessage(), "", 1);
    }
  }

  function __destruct () {
  // __destruct() : close connection when done

    if ($this->stmt !== null) {
      $this->stmt = null;
    }
    if ($this->pdo !== null) {
      $this->pdo = null;
    }
  }

  function get ($id) {
  // get() : get user
  // PARAM $id : user ID

    $sql = "SELECT * FROM `microfinance` WHERE `user_id`=?";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute([$id]);
    $entry = $this->stmt->fetchAll();
    return count($entry)==0 ? false : $entry[0] ;
  }

  function getByEmail ($name) {
      // get() : get user by name
  // PARAM $name : user email

    $sql = "SELECT * FROM `microfinance` WHERE `name`=?";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute([$name]);
    $entry = $this->stmt->fetchAll();
    return count($entry)==0 ? false : $entry[0] ;
  }

    function getByPhone ($phoneNumber) {
        // get() : get user by name
        // PARAM $name : user email

        $sql = "SELECT * FROM `microfinance` WHERE `phoneNumber`=?";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute([$phoneNumber]);
        $entry = $this->stmt->fetchAll();
        return count($entry)==0 ? false : $entry[0] ;
    }

  function getAll () {
  // getAll() : get all users

    $sql = "SELECT * FROM `microfinance`";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute();
    $entry = $this->stmt->fetchAll();
    return count($entry)==0 ? false : $entry ;
  }

  function add ($name, $phoneNumber, $city) {
  // add() : add a new user
  // PARAM $email - email
  //       $name - name
  //       $password - password (clear text)

    $sql = "INSERT INTO `microfinance` (`name`, `phoneNumber`, `city`) VALUES (?, ?, ?)";
    $cond = [$name, $phoneNumber,$city];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }
    return true;
  }

  function edit ($name, $phoneNumber, $city, $id) {
  // edit() : update user
  // PARAM $email - email
  //       $name - name
  //       $password - password (clear text)
  //       $id - user ID

    $sql = "UPDATE `microfinance` SET `name`=?, `phoneNumber`=?, `city`=? WHERE `user_id`=?";
    $cond = [$name, $phoneNumber, $city, $id];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }
    return true;
  }

  function del ($id) {
  // del() : delete user
  // PARAM $id - user ID

    $sql = "DELETE FROM `microfinance` WHERE `user_id`=?";
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute([$id]);
    } catch (Exception $ex) {
      return false;
    }
    return true;
  }
}
?>