function teamModel() {
    this.init = function(){
        setTimeout(updatePosts, 300);
        setInterval(updatePosts, 3000);
    };
    var newPostCallback = null;
    var lastSeenID = -1;

    var updatePosts = function(){
        var group = window.location.search.split("=");
        var parameters = "startID="+((lastSeenID*1)+1)+"&groupID="+ group[1];
        var http;
        var entry;
        var replies;
        if (newPostCallback !== null){
            http = new XMLHttpRequest();
            http.open("GET", "getPosts.php?"+parameters, true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = function(){
                if (http.readyState == 4 && http.status == 200){
                    replies = http.responseText;
                    console.log(replies);
                    replies = http.responseText.split("\n");
                    replies.forEach(function(messageEntry){
                        if (messageEntry.length > 0) {
                            entry = JSON.parse(messageEntry);
                            console.log(entry.Username);
                            lastSeenID = entry.insertID;
                            newPostCallback(entry.Username + ": " + entry.Message);
                        }
                    });

                };
            };
            http.send();
        };
    };




    function getUniqueID() {
        if(localStorage.chatUID){
            var string = localStorage.chatUID.slice(0, -4);
            var num = '';
            var num2 = localStorage.chatUID;
            num2 = num2.substring(num2.length-4)
            console.log(num2);
            while(num2.length != 1 && (num2.charAt(0)=='0' && num2.charAt(1) != '9')){
                    num = num + num2.charAt(0);
                    num2 = num2.substring(1);
            }
            num2++;
            localStorage.chatUID = string + num + num2;
        }else{
            var cookies = decodeURIComponent(document.cookie).split(';');
            var user = "currentUser=";
            var returnCookie;
            cookies.forEach(function (cookie) {
                returnCookie = cookie;
                while (returnCookie.charAt(0) == ' ') {
                    returnCookie = returnCookie.substring(1);
                }
                if (returnCookie.indexOf(user) == 0) {
                    user = returnCookie.substring(user.length, returnCookie.length);
                }
            })
            localStorage.chatUID = user + "0000";
        }
        return localStorage.chatUID;
    }

    this.post = function(message){
        var group = window.location.search.split("=");
        var http = new XMLHttpRequest();
        var parameters = "msg="+encodeURIComponent(message)+"&groupID="+group[1]+"&uid="+getUniqueID();
        http.open("POST", "chat.php", true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        http.onreadystatechange = function(){
            if (http.readyState == 4 && http.status == 200){
                window.setTimeout(updatePosts, 100);
            }
        }
        http.send(parameters);
    };

    this.setMessagesCallback = function(callback){
        newPostCallback = callback;
        updatePosts();
    }
}