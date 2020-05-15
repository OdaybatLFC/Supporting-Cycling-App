var userArray = new Array();
var userTextField = document.getElementById("user");
var nameTextField = document.getElementById("groupName");
function addUser(){
    userArray[userArray.length] = userTextField.value;
    userTextField.value = "";
    console.log(userArray);
}

function submit(){
    var params = "";
    for(var i = 0; i <userArray.length; i++) {

            params = params + '&users[]=' + userArray[i];

    }
    var http = new XMLHttpRequest();
    http.open("GET", "addGroup.php?groupName="+ nameTextField.value + params, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send();
    setTimeout(goBack, 1000 )
    return false;
}
function goBack(){
    window.location='teamForming.php';
}