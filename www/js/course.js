function removeSuccessed(){
    let node = $("<div class='alert alert-success error-msg' role='alert'> </div>");
    node.html("File have been removed");
    let closeSpan = $('<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '    <span aria-hidden="true">&times;</span>\n' +
        '  </button>');
    node.append(closeSpan);
    return node;
}

function removeFailed(){
    let node = $("<div class='alert alert-danger error-msg' role='alert'> </div>");
    node.html("File remove failed, please try again later");
    let closeSpan = $('<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '    <span aria-hidden="true">&times;</span>\n' +
        '  </button>');
    node.append(closeSpan);
    return node;
}

$(".delete-record-button").click(function () {
    let card = $(this.parentElement.parentElement.parentElement.parentElement);
    let successNode = removeSuccessed();
    console.log(this.value)
    $.ajax({
        url: "fileDelete.php",
        type: "post",
        data:{"fileid":this.value},
        success: function (raw) {
            try {
                let result = JSON.parse(raw)
                if (result.result){
                    successNode.insertBefore(card);
                    // Remove the card
                    $(card).fadeOut(800);

                    setTimeout(function () {
                        card.remove();
                    },1000);
                    setTimeout(function () {
                        successNode.fadeOut();
                        setTimeout(function () {
                            successNode.remove()
                        },1000);
                    },3000);

                }else{
                    if (!$(".error-msg",card).length){
                        $(".card-header",card).prepend(removeFailed());
                    }

                }

            }catch (e) {
                if (!$(".error-msg",card).length){
                    $(".card-header",card).prepend(removeFailed());
                }
            }

        },error:function () {

        }
        }
    )

})