var usr = {
  list : function () {
  // list() : show all the users

    adm.load({
      url : "ajax-users.php",
      target : "container",
      data : {
        req : "list"
      }
    });
  },

  addEdit : function (id) {
  // addEdit() : show add/edit user docket
  // PARAM id : user ID

    adm.load({
      url : "ajax-users.php",
      target : "container",
      data : {
        req : "addEdit",
        id : id
      }
    });
  },

  save : function () {
  // save() : save user

    var id = document.getElementById("usr_id").value;
    adm.ajax({
      url : "ajax-users.php",
      data : {
        req : (id=="" ? "add" : "edit"),
        id : id,
        name : document.getElementById("name").value,
        phoneNumber : document.getElementById("phoneNumber").value,
        city: document.getElementById("city").value
      },
      ok : usr.list
    });
    return false;
  },

  del : function (id) {
  // del() : delete user
  // PARAM id : user ID

    if (confirm("Delete user?")) {
      adm.ajax({
        url : "ajax-users.php",
        data : {
          req : "del",
          id : id
        },
        ok : usr.list
      });
    }
  }
};

window.addEventListener("load", usr.list);