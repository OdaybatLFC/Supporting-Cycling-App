function teamView() {
    var chatDiv;
    var postForm;
    var teamMessage;

    this.init = function(){
        chatDiv = document.getElementById("chatDiv");
        postForm = document.getElementById("chatForm");
        teamMessage = document.getElementById("message");
    };

    this.addMessage = function(msg){
        chatDiv.innerHTML = chatDiv.innerHTML + "<p>" + msg + "</p>";
    };

    this.setSendCallback = function(callback){
        postForm.addEventListener("submit", function(event) {
            callback(teamMessage.value);
            teamMessage.value = "";
            teamMessage.focus();
            event.preventDefault();
        });
    };
}
