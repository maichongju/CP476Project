var sign_up_check = function (event) {
    var password = document.querySelector("form#form-signup input[name=password]"),
        cpassword = document.querySelector("form#form-signup input[name=cpassword]"),
        username = document.querySelector("form#form-signup input[name=username]");
    username.value = username.value.trimStart().trimEnd();
    if (password.value !== cpassword.value) {
        if (document.getElementById("error-password-not-match") === null) {
            var errorNode = document.createElement("p"),
                errorMessage = document.createTextNode("The password you enter did not match.");
            errorNode.appendChild(errorMessage);
            errorNode.setAttribute("class", "form-error-msg");
            password.parentElement.insertBefore(errorNode, password.nextSibling);
        }

        event.preventDefault();
    } else {
        if (document.getElementById("error-password-not-match") !== null)
            document.getElementById("error-password-not-match").remove();
    }

};

if (document.querySelector("form#form-signup") !== null) {
    document.querySelector("form#form-signup").addEventListener("submit", sign_up_check);
}
