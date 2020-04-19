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

function createUploadErrorAlert(msg){
    let errorNode = $("<div class='alert alert-danger' role='alert'> </div>");
    errorNode.html("<strong>Upload Failed: </strong>" + msg);
    errorNode.append(closeSpan);
    return errorNode;
}

function createErrorAlert(msg){
    let errorNode = $("<div class='alert alert-danger' role='alert'> </div>");
    errorNode.html(msg);
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

function validFileSize(size){
    const maxsize = 1024*1024*35;
    return size <= maxsize;
}

$("#upload-file-input").change(function () {
    $("#file-upload-result").empty();
    const input = $("#upload-file-input")[0];
    if (input.files.length > 0 ) {
        if (validFileSize(input.files[0].size)){
            $("#file-detail-group").prop("hidden", false);
            const file = input.files[0];
            $("#display-name").val(file.name)
            $("#file-name").val(file.name);
            $("#file-size-text").text("Size: " + convertFileSize(file.size));
        }else{
            let node = createErrorAlert("File Max Size is 35MB, please upload a smaller file")
            $("#file-upload-result").append(node);
            $("#upload-file-input").val("");
        }

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
            try{
                let result = JSON.parse(raw);
                if (result.hasOwnProperty("result")){
                    // If file insert succeeded
                    if (result.result && result.hasOwnProperty("msg")){
                        let node = createSuccessAlert(result.msg);
                        $("#file-upload-result").append(node);
                    }else if (!result.result){
                        if (result.hasOwnProperty("error")){
                            let node = createUploadErrorAlert(result.error);
                            $("#file-upload-result").append(node);
                        }else if (result.hasOwnProperty("warning")){
                            let node = createWarningAlert(result.warning);
                            $("#file-upload-result").append(node);
                        }
                    }
                }
            }catch (e) {
                let node = createUploadErrorAlert("Something wrong with our side, please try again later");
                $("#file-upload-result").append(node);
            }

        },
        error: function (_,status,error) {
            let node = createUploadErrorAlert("There are something wrong, please try again later");
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