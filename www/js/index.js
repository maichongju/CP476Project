function account_dropdown(){
    document.getElementById("nav-main-dropdown-content").classList.toggle("show");
}

window.onclick = function (event){
    if (!event.target.matches(".nav-main-dropdown-content")){
        let content = document.getElementById("nav-main-dropdown-content");
        if (content.classList.contains("show")){
            content.classList.remove("show");
        }
    }
}