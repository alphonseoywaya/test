<?php
// INIT
session_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";

// HTML
require PATH_LIB . "page-top.php"; ?>
<script>
function login() {
  adm.ajax({
    // Change this to absolute URL if you are getting file not found errors
    // E.g. http://mysite.com/ajax-session.php
    url : "ajax-session.php",
    data : {
      req : "in",
      name : document.getElementById("name").value,
      phoneNumber : document.getElementById("phoneNumber").value
    },
    ok : function(){
      location.href = "index.php";
    },
    error : function(){
      alert("Invalid user/password");
    }
  });
  return false;
}
</script>
<style>
#login-form{
  max-width: 340px;
  margin: 0 auto;
  padding: 10px 20px 20px 20px;
  background: #eee;
}
#login-form input{
  width: 100%;
}
</style>
<form id="login-form" onsubmit="return login();">
  <h1>PLEASE SIGN IN</h1>
  <label for="name">Name:</label>
  <input type="text" id="name" required value="john"/>
  <label for="phoneNumber">Password:</label>
  <input type="text" id="phoneNumber" required value="0729201358"/>
  <input type="submit" value="login"/>
</form>
<?php require PATH_LIB . "page-bottom.php"; ?>