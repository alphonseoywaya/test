<?php
// RESTRICT ACCESS
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
session_start();
if (!is_array($_SESSION['user'])) {
  die("ERR");
}

// INIT
require PATH_LIB . "lib-users.php";
$usrLib = new Users();

// HANDLE AJAX REQUEST
switch ($_POST['req']) {
  /* [INVALID REQUEST] */
  default:
    die("ERR");
    break;

  /* [SHOW ALL USERS] */
  case "list":
    $users = $usrLib->getAll(); ?>
    <h1>MANAGE USERS</h1>
    <input type="button" value="Add User" onclick="usr.addEdit()"/>
    <?php
    if (is_array($users)) {
      echo "<table class='zebra'>";
      foreach ($users as $u) {
        printf("<tr><td>%s (%s)</td><td class='right'>"
          . "<input type='button' value='Delete' onclick='usr.del(%u)'>"
          . "<input type='button' value='Edit' onclick='usr.addEdit(%u)'>"
          . "</td></tr>", 
          $u['name'], $u['city'],
          $u['user_id'], $u['phoneNumber']
        );
      }
      echo "</table>";
    } else {
      echo "<div>No users found.</div>";
    }
    break;

  /* [ADD/EDIT USER DOCKET] */
  case "addEdit":
    $edit = is_numeric($_POST['id']);
    if ($edit) {
      $user = $usrLib->get($_POST['id']);
    } ?>
    <h1><?=$edit?"EDIT":"ADD"?> USER</h1>
    <form onsubmit="return usr.save()">
      <input type="hidden" id="usr_id" value="<?=$user['user_id']?>"/>
      <label for="name">Name:</label>
      <input type="text" id="name" required value="<?=$user['name']?>"/>
      <label for="phoneNumber">Phone number:</label>
      <input type="text" id="phoneNumber" required value="<?=$user['phoneNumber']?>"/>
      <label for="city">city:</label>
      <input type="text" id="city" required value="<?=$user['phoneNumber']?>"/>
      <input type="button" value="Cancel" onclick="usr.list()"/>
      <input type="submit" value="Save"/>
    </form>
    <?php break;

  /* [ADD USER] */
  case "add":
    echo $usrLib->add($_POST['name'], $_POST['phoneNumber'], $_POST['city']) ? "OK" : "ERR" ;
    break;

  /* [EDIT USER] */
  case "edit":
    echo $usrLib->edit($_POST['name'], $_POST['phoneNumber'], $_POST['city'], $_POST['id']) ? "OK" : "ERR" ;
    break;

  /* [DELETE USER] */
  case "del":
    echo $usrLib->del($_POST['id']) ? "OK" : "ERR" ;
    break;
}
?>