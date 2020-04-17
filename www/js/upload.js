function convertFileSize(number) {
    if(number < 1024) {
        return number + 'bytes';
    } else if(number >= 1024 && number < 1048576) {
        return (number/1024).toFixed(1) + 'KB';
    } else if(number >= 1048576) {
        return (number/1048576).toFixed(1) + 'MB';
    }
}
$("#upload-file-input").change(function () {
    const input = $("#upload-file-input")[0];
    if (input.files.length > 0){
        $("#file-detail-group").prop("hidden",false);
        const file = input.files[0];
        $("#display-name").val(file.name)
        $("#file-name").val(file.name);
        $("#file-size-text").text("Size: " + convertFileSize(file.size));
    }
})
$("form").submit(function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    formData.append("file",$("#upload-file-input")[0].files[0]);
    console.log(...formData);

})