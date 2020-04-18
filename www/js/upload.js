function convertFileSize(number) {
    if (number < 1024) {
        return number + 'bytes';
    } else if (number >= 1024 && number < 1048576) {
        return (number / 1024).toFixed(1) + 'KB';
    } else if (number >= 1048576) {
        return (number / 1048576).toFixed(1) + 'MB';
    }
}

let closeSpan = $('  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
    '    <span aria-hidden="true">&times;</span>\n' +
    '  </button>');

function createErrorAlert(msg){
    let errorNode = $("<div class='alert alert-danger' role='alert'> </div>");
    errorNode.html("<strong>Upload Failed: </strong>" + msg);
    errorNode.append(closeSpan);
    return errorNode;
}

function createWarningAlert(msg){
    let warningNode = $("<div class='alert alert-warning' role='alert'> </div>");
    warningNode.html("<strong>Upload Failed: </strong>" + msg);
    warningNode.append(closeSpan);
    return warningNode;
}

function createSuccessAlert(msg){
    let node = $("<div class='alert alert-success' role='alert'> </div>");
    node.html("<strong>Upload Succeeded: </strong>" + msg);
    node.append(closeSpan);
    return node;
}

$("#upload-file-input").change(function () {
    const input = $("#upload-file-input")[0];
    if (input.files.length > 0) {
        $("#file-detail-group").prop("hidden", false);
        const file = input.files[0];
        $("#display-name").val(file.name)
        $("#file-name").val(file.name);
        $("#file-size-text").text("Size: " + convertFileSize(file.size));
    }
})
$("form").submit(function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    formData.append("file", $("#upload-file-input")[0].files[0]);
    console.log(...formData);
    $.ajax({
        url: "uploadC.php",
        type: "POST",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#upload-progress").prop("hidden", false);
            $("#file-upload-result").empty();
        },
        complete: function () {
            $("#upload-progress").prop("hidden", true);
        },
        success: function (raw) {
            console.log(raw);
            let result = JSON.parse(raw);
            if (result.hasOwnProperty("result")){
                // If file insert succeeded
                if (result.result && result.hasOwnProperty("msg")){
                    let node = createSuccessAlert(result.msg);
                    $("#file-upload-result").append(node);
                }else if (!result.result){
                    if (result.hasOwnProperty("error")){
                        let node = createErrorAlert(result.error);
                        $("#file-upload-result").append(node);
                    }else if (result.hasOwnProperty("warning")){
                        let node = createWarningAlert(result.warning);
                        $("#file-upload-result").append(node);
                    }
                }
            }
        },
        error: function (_,status,error) {
            let node = createErrorAlert("There are something wrong, please try again later");
            $("#file-upload-result").append(node);
            console.log(status);
            console.log(error);
        },
        xhr: function () {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (event) {
                let percentage = Math.ceil(event.loaded / event.total * 100);
                $("#file-upload-progress-bar").animate({
                    width: percentage + "%"
                }, {duration: "fast"})
            })
            return xhr;
        }
    })
})