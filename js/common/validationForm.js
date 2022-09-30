// $(document).on("click", "button[type='submit']", function (e) {
$("button[data-validationForm='true']").click( function(e) {
  exit();

  e.preventDefault();

  let regexList = {
    hidden:     /(.*?)/,
    id:         /^[0-9]{1,}$/,
    file:       /(.*?)/,
    firstname:  /^[\p{L}\s]{2,}$/u,
    lastname:   /^[\p{L}\s]{2,}$/u,
    email:      /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g,
    password:   /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/g,
    address:    /(.*?)/,
    zipcode:    /^[\w\-\s]{5,}$/,
    city:       /(.*?)/,
    phone:      /^[\d]{10,}$/
  };

  $("small").text("");
  let error = false;

  let formElements = $("form")[0]; // recupérer tous les elements du form dans un tab

  // formElements.length - 2   : pour ne pas prendre les boutons submit et reset //  il ne faut METTRE le bouton reset dans le form
  for (let i = 0; i < formElements.length - 2; i++) {

    console.log($(formElements[i]).attr("type"));
    if ( $(formElements[i]).attr("type") == 'hidden'
         || $(formElements[i]).attr("type") == 'file' ) {
      continue;
    }

    // trt des boutons radio
    if ($(formElements[i]).attr("type") === "radio") {
      //$("#" + $(formElements[i]).attr("aria-describedby")).html("");
      if ($("input[name='" + $(formElements[i]).attr("name") + "']:checked").length === 0) {
        error = true;
        $("#" + $(formElements[i]).attr("aria-describedby")).html(
          `<p class="errorMessage">${$(formElements[i]).attr("data-message")}</p>`
        );
      }
    }

    // trt du password
    else if ($(formElements[i]).attr("type") === "password") {
      // $("#pass").removeClass("errorInput");
      // $("#pass2").removeClass("errorInput");
      $("input[type='password']").removeClass("errorInput");

      const pattern = regexList.password;

      if (pattern.test(formElements[i].value) === false) {
        error = true;
        // $("#pass").addClass("errorInput");
        // $("#pass2").addClass("errorInput");
        $("input[type='password']").addClass("errorInput");
        $("#" + $(formElements[i]).attr("aria-describedby")).html(
          `<p class="errorMessage">${$(formElements[i]).attr("data-message")}</p>`
        );
      }
      if ($("#pass").val() !== $("#pass2").val()) {
        error = true;
        // $("#pass").addClass("errorInput");
        // $("#pass2").addClass("errorInput");
        $("input[type='password']").addClass("errorInput");
        $("#" + $(formElements[i]).attr("aria-describedby")).html(
          `<p class="errorMessage">Les deux mot de passes doivent etre identiques et au bon format...</p>`
        );
      }
    }

    // trt du select
    else if ($(formElements[i]).prop("tagName").toLowerCase() === "select") {
      $(formElements[i]).removeClass("errorInput");
      //$(formElements[i]).next().html("");

      if (formElements[i].value === "") {
        error = true;
        $(formElements[i]).addClass("errorInput");
        $("#" + $(formElements[i]).attr("aria-describedby")).html(
          `<p class="errorMessage">${$(formElements[i]).attr("data-message")}</p>`
        );
      }
    }

    // trt du reste des input
    else {

      $(formElements[i]).removeClass("errorInput");

      let type = $(formElements[i]).attr("data-type");
      let pattern = regexList[type];

      if (pattern.test(formElements[i].value) === false) {
        console.log(type);
        error = true;
        $(formElements[i]).addClass("errorInput");
        $("#" + $(formElements[i]).attr("aria-describedby")).html(
          `<p class="errorMessage">${$(formElements[i]).attr("data-message")}</p>`
        );
      }

    }
  }

  if (!error) {
    $("form").submit();
  }
});
