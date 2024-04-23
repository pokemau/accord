

$(document).ready(function(){
    var currUser = null

    refresh();

    const isToday = (someDate) => {
        const today = new Date()
        return someDate.getDate() == today.getDate() &&
          someDate.getMonth() == today.getMonth() &&
          someDate.getFullYear() == today.getFullYear()
    }
    function tConvert (time) {
        // Check correct time format and split into components
        time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
      
        if (time.length > 1) { // If time format correct
          time = time.slice (1);  // Remove full string match value
          time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
          time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join (''); // return adjusted time or original string
      }
      

    function unBlurEverything(){
        $(".blur").removeClass('blur');
    }
    function backgroundBlur(){
        $("nav").addClass('blur');
        $("#divServerList").addClass('blur');
        $("#main-cont").addClass('blur');
    }
    function channelsMiddleBarShow(){
        $(".lblServerName").text($(".server-div.clicked").children().text());
        $("#channels-middlebar").show();
    }
    function messagesRightBarShow(){
        $("#channelNameHeader").text("#"+$(".channel-div.clicked").children().text());
        $("#messages-rightbar").show();
    }
    function refresh(){
        unBlurEverything();
        $(".popUpForm").hide();
        $(".popUpForm").addClass("unblurred");
        let promiseServers = getServerList();
        let promiseChannels = $.Deferred();     //initialize a promise-type in case we dont go through an async func
        if($(".server-div.clicked")[0]){        //if clicked server-div exists already, just update the channelslist
            promiseServers.then(function() {
                getServerChannelList()
                    .then(response => {
                        channelsMiddleBarShow();
                        promiseChannels.resolve(response);
                    })
                    .catch(error => {
                        promiseChannels.reject(error);
                    });
            });
        }else{      //else complete initialized 'resolved' promise and hide channels
            promiseChannels.resolve();      //resolves the initialized promise cuz we dont have async func
            $("#channels-middlebar").hide();
        }

        if($(".channel-div.clicked")[0]){       //if channel div has clicked, wait for updated channels before showing messages 
            promiseChannels.done(function() {
                getMessageList()
                    .then(response => {
                        messagesRightBarShow();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        }else{
            $("#messages-rightbar").hide();
        }
    }
    function showMessage(message){
        $("body").append("<div id='message-box'> <p>"+message+"</p> </div>");
        setTimeout(function() {
            var messageBox = document.getElementById('message-box');
            if (messageBox) {
              messageBox.parentNode.removeChild(messageBox);
            }
          }, 3000);
    }
    

    async function createServer(serverName){
        try{
            let response = await $.post("api/createServer.php",
            {
                servername: serverName
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function updateServer(newServerName){
        try{
            let toUpdateServerID = sessionStorage.getItem("serverID");
            let response = await $.post("api/updateServer.php",
            {
                serverID: toUpdateServerID,
                newservername: newServerName
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function deleteServer(){
        try{
            let toDeleteServerID = sessionStorage.getItem("serverID");
            let response = await $.post("api/deleteServer.php",
            {
                serverID: toDeleteServerID
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function createServerChannel(channelName){
        try{
            let serverIDparam = sessionStorage.getItem("serverID");
            let response = await $.post("api/createServerChannel.php",
            {
                serverID: serverIDparam,
                channelname: channelName
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function updateServerChannel(newChannelName){
        try{
            let toUpdateChannelID = sessionStorage.getItem("channelID");
            let response = await $.post("api/updateServerChannel.php",
            {
                channelID: toUpdateChannelID,
                newchannelname: newChannelName
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function deleteServerChannel(){
        try{
            let toDeleteChannelID = sessionStorage.getItem("channelID");
            let response = await $.post("api/deleteServerChannel.php",
            {
                channelID: toDeleteChannelID
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function sendMessage(messageTextparam){
        try{
            let channelIDparam = sessionStorage.getItem("channelID");
            let response = await $.post("api/sendMessage.php",
            {
                channelID: channelIDparam,
                messageText: messageTextparam
            },
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            return response['message'];
        }catch(error){
            throw error;
        }
    }

    async function getServerList(){
        let response = await $.get("api/getServerList.php",
        function(responseInner, status){
            return responseInner;
        });
        if(response['status'] == false){
            console.log("Something was wrong (getServerList)");
            return;
        }
        printServers(response['serverList']);
    }

    function printServers(serverList){
        let serverIDClicked = $(".server-div.clicked").data("serverid");
        $("#servers-wrapper").html("");
        for(let i=0; i<serverList.length; i++){
            let serverInfo = serverList[i];
            let string = "<div data-serverid='" + Number(serverInfo.serverID) + "' class='server-div";
            if(serverInfo.serverID == serverIDClicked){
                string += " clicked";
            }
            string += "'>"
                + "<h2>" + String(serverInfo.servername) + "</h2>"
                + "</div>";
            $(string).appendTo("#servers-wrapper");
        }
    }

    async function getServerChannelList(){
        try{
            let serverIDparam = sessionStorage.getItem("serverID");
            let response = await $.get("api/getServerChannelList.php",
            {
                serverID: serverIDparam  
            },
            function(responseInner, status){
                return responseInner;
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            printServerChannels(response['channelList']); 
        }catch(error){
            throw error;
        }
    }

    function printServerChannels(channelList){
        let channelIDClicked = $(".channel-div.clicked").data("channelid");
        $("#channels-wrapper").html("");
        channelsMiddleBarShow();
        for(let i=0; i<channelList.length; i++){
            let channelInfo = channelList[i];
            let string = "<div data-channelid='" + Number(channelInfo.channelID) + "' class='channel-div";
            if(channelInfo.channelID == channelIDClicked){
                string += " clicked";
            }
            string += "'>"
                + "<h4>" + String(channelInfo.channelname) + "</h4>"
                + "</div>";
            $(string).appendTo("#channels-wrapper");
        }
    }

    async function getMessageList(){
        try{
            let channelIDparam = sessionStorage.getItem("channelID");
            let response = await $.get("api/getMessageList.php",
            {
                channelID: channelIDparam  
            },
            function(responseInner, status){
                return responseInner;
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            printMessages(response['messageList']); 
        }catch(error){
            throw error;
        }
    }

    function printMessages(messageList){
        $("#messages-wrapper").html("");
        messagesRightBarShow();
        for(let i=0; i<messageList.length; i++){
            let messageInfo = messageList[i];
            let string = "<div data-messageid='" + Number(messageInfo.messageID) + "' class='message-div'>"
            +   "<div class='message-header'>"
            +       "<h4>" + String(messageInfo.senderdisplayname) + "</h4>"
            +       "<h6>";

            let messageTimeDate = messageInfo.dateTimeSent;
            let messageDate = messageTimeDate.slice(0, 10);
            let messageTime = messageTimeDate.slice(10, 15);
            if (isToday(new Date(messageDate))){
                string += "Today";
            }else{
                string += String(messageDate);
            }
            string += " at " + String(tConvert(messageTime)) + "</h6>"
            +   "</div>"
            +   "<div class='message-contents'>"
            +       "<h5>" + String(messageInfo.messageText) + "</h5>"
            +   "</div>"
            + "</div>";
            $(string).appendTo("#messages-wrapper");
        }
    }

    $("#servers-wrapper").on('click', '.server-div', function(){
        if($(this).hasClass("clicked")) return;

        $("#messages-rightbar").hide();
        $(".server-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        let serverID = $(this).data("serverid");
        sessionStorage.setItem("serverID", serverID);
        getServerChannelList()
            .catch(error => {
                showMessage(error);
            });
    });

    $("#channels-wrapper").on('click', '.channel-div', function(){
        if($(this).hasClass("clicked")) return;

        $(".channel-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        let channelID = $(this).data("channelid");
        sessionStorage.setItem("channelID", channelID);

        $("#right-page").hide();
        getMessageList()
            .catch(error => {
                showMessage(error);
            });
    });

    function openPopUpForm(callingButton){
        let callingButtonDiv = $(callingButton).parent()
        let callingPopUpForm = $(callingButtonDiv).parent();

        callingPopUpForm.addClass("blur");
        callingPopUpForm.removeClass("unblurred");

        let index = 0;

        if($(callingPopUpForm).find('.divSubmitBtn').length > 1){
            index = $(callingPopUpForm).find('.divSubmitBtn').index(callingButtonDiv);
        }

        let childPopUpForm =  $(callingPopUpForm).find('.popUpForm')[index];
        $(childPopUpForm).show();
    };
    function closePopUpForm(callingButton){
        let callingPopUpForm = $(callingButton).parent().parent();
        callingPopUpForm.addClass("unblurred");
        callingPopUpForm.hide();
        let parentPopUpForm =  $(callingPopUpForm).parent();
        if($(parentPopUpForm).is('body')) {
            refresh();
            return;
        }
        parentPopUpForm.removeClass("blur");
        parentPopUpForm.addClass("unblurred");
    }

    $("#btnCreateServerSection").on('click', function(){
        backgroundBlur();
        $("#create-server-section").show();
    });

    $(".closeBtn").on('click', function(){
        closePopUpForm(this)
    });
    $(".noBtn").on('click', function(){
        closePopUpForm(this)
    });

    $("#btnCreateServer").on('click', function(){
        let serverName = $("#txtServerName").val();
        if(serverName == "") return;
        $(".lblServerNameConfirm").text(serverName);
        openPopUpForm(this);
    });
    $("#btnYESCreateServerConfirm").on('click', function(){
        let serverName = $("#txtServerName").val();

        createServer(serverName)
            .then(response => {
                refresh();
                showMessage("Successfully created the server!");
            })
            .catch(error => {
                showMessage(error);
                return;
            });
    });

    $("#btnCreateChannelSection").on('click', function(){
        backgroundBlur();
        $("#create-channel-section").show();
    });
    $("#btnCreateChannel").on('click', function(){
        let channelName = $("#txtChannelName").val();
        if(channelName == "") return;
        $(".lblChannelNameConfirm").text(channelName);
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        openPopUpForm(this);
    });
    $("#btnYESCreateChannelConfirm").on('click', function(){
        let channelName = $("#txtChannelName").val();

        createServerChannel(channelName)
            .then(response => {
                refresh();
                showMessage("Successfully created the channel!");
            })
            .catch(error => {
                showMessage(error);
                closePopUpForm();
            });
    
    });

    //server update and delete
    $("#serverSettings").on('click', function(){
        backgroundBlur();
        $("#update-delete-server-section").show();
    });
    $("#btnUpdateServer").on('click', function(){
        let newServerName = $("#txtNewServerName").val();
        if(newServerName == "") return;
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        $(".lblNewServerName").text(newServerName);
        openPopUpForm(this);
    });
    $("#btnYESUpdateServerConfirm").on('click', function(){
        let newServerName = $("#txtNewServerName").val();

        updateServer(newServerName)
            .then(response => {
                refresh();
                showMessage("Successfully updated the server!");
            })
            .catch(error => {
                showMessage(error);
                closePopUpForm();
            });
    
    });

    $("#btnDeleteServer").on('click', function(){
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
       openPopUpForm(this);
    });
    $("#btnYESDeleteServerConfirm").on('click', function(){
        deleteServer()
            .then(response => {
                refresh();
                showMessage("Successfully deleted the server!");
            })
            .catch(error => {
                showMessage(error);
                closePopUpForm();
            });
    
    });

    //channel update and delete
    $("#channelSettings").on('click', function(){
        backgroundBlur();
        $("#update-delete-channel-section").show();
    });
    $("#btnUpdateChannel").on('click', function(){
        let newChannelName = $("#txtNewChannelName").val();
        if(newChannelName == "") return;
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text())
        $(".lblNewChannelName").text(newChannelName);
        openPopUpForm(this);
    });
    $("#btnYESUpdateChannelConfirm").on('click', function(){
        let newChannelName = $("#txtNewChannelName").val();

        updateServerChannel(newChannelName)
            .then(response => {
                refresh();
                showMessage("Successfully updated the channel!");
            })
            .catch(error => {
                showMessage(error);
                closePopUpForm();
            });
    
    });

    $("#btnDeleteChannel").on('click', function(){
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text())
        openPopUpForm(this);
    });
    $("#btnYESDeleteChannelConfirm").on('click', function(){
        deleteServerChannel()
            .then(response => {
                refresh();
                showMessage("Successfully deleted the channel!");
            })
            .catch(error => {
                showMessage(error)
                closePopUpForm();
            });
    
    });

    $("#btnSendMessage").click(() => {
        $messageText = $("#inpMessage").val();
        sendMessage($messageText)
            .then(response => {
                refresh();
            })
            .catch(error => {
                showMessage(error);
            });
    });

    // user settings btn
    $("#user-settings-btn").click(() => {
        window.location.assign("user.php");
    });
})