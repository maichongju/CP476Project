$("#changePassword").submit(function (event) {
    let p = $("input[name=p]");
    let pr = $("input[name=pr]");

    let msg = $("#msg");
    // Clear message area if there is any error message
    msg.empty();

    // Password does not match
    if (p.val() !== pr.val()){
        event.preventDefault();
        let node = $("<div class='alert alert-danger error-msg' role='alert'> </div>");
        node.html("Password does not match!");
        msg.append(node);
        pr.val("");
        pr.focus();
    }
})
