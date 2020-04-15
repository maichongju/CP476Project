$("form#form-signup").submit(function (event) {
    var password = $("form#form-signup input[name=password]")[0],
        cpassword = $("form#form-signup input[name=cpassword]")[0],
        username = $("form#form-signup input[name=username]")[0];
    // clean up the username
    username.value = username.value.trimStart().trimEnd();

    let div_error_msg = $("div .error-msg-group");

    // clean up all the error if exist
    div_error_msg.empty();

    if (password.value !== cpassword.value) {
        // password not match ,create error message
        let errorMsg = $("<h5 class='form-text text-danger'>The password you enter did not match.</h5>");
        div_error_msg.append(errorMsg);
        password.value = "";
        cpassword.value = "";
        password.focus();
        event.preventDefault();
    }
})

