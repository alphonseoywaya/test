<?php
// INIT
session_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";

// HANDLE AJAX REQUEST
switch ($_POST['req']) {
  /* [INVALID REQUEST] */
  default:
    die("ERR");
    break;

  /* [LOGIN] */
  case "in":
    // ALREADY SIGNED IN
    if (is_array($_SESSION['user'])) { die("OK"); }

    // VERIFY
    else {
      // INIT
      require PATH_LIB . "lib-users.php";
      $usrLib = new Users();

      // GET + CHECK PASSWORD
      $user = $usrLib->getByEmail($_POST['name']);
      $pass = is_array($user);
      if ($pass) {
        $pass = $usrLib->getByPhone($_POST['phoneNumber']);
      }
      if ($pass) {
        $_SESSION['user'] = [
            "id" => $user['user_id'],
            "name" => $user['name'],
            "city" => $user['city']
        ];
      }
      echo $pass ? "OK" : "ERR" ;
    }
    break;

  /* [LOGOUT] */
  case "out":
    unset($_SESSION['user']);
    die("OK");
    break;
}
?>