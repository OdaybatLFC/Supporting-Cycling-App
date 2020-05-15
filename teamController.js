function teamController(){
    var teamview = new teamView();
    var teammodel = new teamModel();

    this.init = function(){
        teammodel.init();
        teamview.init();

        teammodel.setMessagesCallback(function(message){
            teamview.addMessage(message);
        });

        teamview.setSendCallback(teammodel.post);
    };
}


var teamcontroller = new teamController();
window.addEventListener("load", teamcontroller.init)