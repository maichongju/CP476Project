function openAccountTab(event, tabName) {
    var i, tabcontent, tablinks;

    // Get all the element and hide them
    tabcontent = document.getElementsByClassName("account-tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    //Remove all the class for active
    tablinks = document.getElementsByClassName("account-tab-links");

    for (i = 0; i < tablinks.length; i++) {
        tablinks[i] .className = tablinks[i].className.replace(" active","");
    }

    //show the active tab
    document.getElementById(tabName).style.display= "block";
    event.currentTarget.className += " active";
    //Test
}
document.getElementById("account-tab-default").click();
