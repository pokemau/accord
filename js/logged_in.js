
$(document).ready(function(){
    refresh();

    function isToday(someDate){
        const today = new Date();
        return checkDate(someDate, today);
    }
    function isYesterday(someDate){
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        checkDate(someDate, yesterday);
    }
    function checkDate(someDate, compareDate){
        return someDate.getDate() == compareDate.getDate() &&
          someDate.getMonth() == compareDate.getMonth() &&
          someDate.getFullYear() == compareDate.getFullYear()
    }
    function tConvert (time) {
        let timeParts = time.split(":");
        let hours = parseInt(timeParts[0]);
        let minutes = parseInt(timeParts[1]);

        let ampm = hours >= 12 ? "pm" : "am";
        hours = hours % 12;
        hours = hours==0 ? 12 : hours;

        minutes = minutes < 10 ? "0" + minutes : minutes;

        return hours + ":" + minutes + " " + ampm;
    }
    function formatDate(inputDate) {
        var date = new Date(inputDate);
        if (!isNaN(date.getTime())) {
            // Months use 0 index.
            return date.getMonth() + 1 + '-' + date.getDate() + '-' + date.getFullYear();
        }
    }
      
    function promiseHandler(promise, successCallback = null, errorCallback = null){
        promise
        .then(response => {
            if (successCallback) {
                successCallback(response);
            }
        })
        .catch(error => {
            if(error.responseText){
                showMessage(error.responseText);
                console.log(error.responseText);
            }else{
                showMessage(error);
                console.log(error);
            }
            if (errorCallback) {
                errorCallback(error);
            }
        });
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
        // $("#channels-middlebar").show();
    }
    function messagesRightBarShow(){
        $("#channelNameHeader").text("#"+$(".channel-div.clicked").children().text());
        // $("#messages-rightbar").show();
    }
    function refresh(){
        promiseHandler(getCurrUserID());
        unBlurEverything();
        $(".popUpForm").hide();
        $(".options-form").hide();
        $(".popUpForm").addClass("unblurred");
        let promiseServers = getServerList();
        let promiseChannels = $.Deferred();     //initialize a promise-type in case we dont go through an async func
        if($(".server-div.clicked")[0]){        //if clicked server-div exists already, just update the channelslist
            promiseHandler(promiseServers, ()=>{
                promiseHandler(getServerChannelList(), (response)=>{
                    channelsMiddleBarShow();
                    promiseChannels.resolve(response);
                }, (error)=>{
                    promiseChannels.reject(error);
                })
            })
        }else{      //else complete initialized 'resolved' promise and hide channels
            promiseChannels.resolve();      //resolves the initialized promise cuz we dont have async func
            // $("#channels-middlebar").hide();
        }

        promiseChannels.done(function(){
            if($(".channel-div.clicked")[0]){       //if channel div has clicked, wait for updated channels before showing messages 
                promiseHandler(getMessageList());
            }else{
                // $("#messages-rightbar").hide();
            }
        });
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
    async function getCurrUserID(){
        try{
            let response = await $.post("api/getCurrUserID.php",
            function(responseInner, status){
                return responseInner   
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            sessionStorage.setItem("userID", response['userID']);
        }catch(error){
            throw error;
        }
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

    async function addUserToServer(userIDToJoin){
        try{
            let serverIDToJoin = sessionStorage.getItem("serverID");
            let response = await $.post("api/addUserToServer.php",
            {
                joinerID: userIDToJoin,
                serverID: serverIDToJoin
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

    async function updateMessage(newText){
        try{
            let toUpdateMessageID = sessionStorage.getItem("messageID");
            let response = await $.post("api/updateMessage.php",
            {
                messageID: toUpdateMessageID,
                newtext: newText
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


    async function deleteMessage(){
        try{
            let toDeleteMessageID = sessionStorage.getItem("messageID");
            let response = await $.post("api/deleteMessage.php",
            {
                messageID: toDeleteMessageID
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
            throw new Error(String(response['message']));
        }
        printServers(response['serverList']);
    }

    function printServers(serverList){

        let serverID = sessionStorage.getItem("serverID")
        $("#servers-wrapper").html("");

        let clickedClassIsSet = false;
        for(let i=0; i<serverList.length; i++){
            let serverInfo = serverList[i];
            let string = `<div data-serverid="${parseInt(serverInfo.serverID)}" class="server-div`;


            if (serverInfo.serverID == serverID){
                string += " clicked";
                clickedClassIsSet = true;
            }
            string += `
                "> 
                    <h2> ${String(serverInfo.servername)}</h2>
                </div>`

            $(string).appendTo("#servers-wrapper");
        }

        if (!clickedClassIsSet) {
            const firstChild = $("#servers-wrapper > div:first-child")
            firstChild.addClass("clicked")
            sessionStorage.setItem("serverID", firstChild.data("serverid"))
        }

        getServerChannelList()
        channelsMiddleBarShow()
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

        let channelID = sessionStorage.getItem("channelID");
        $("#channels-wrapper").html("");
        channelsMiddleBarShow()

        let clickedClassIsSet = false;

        for(let i=0; i<channelList.length; i++){
            let channelInfo = channelList[i];
            let string = `<div data-channelid="${parseInt(channelInfo.channelID)}" class="channel-div`;

            if (channelInfo.channelID == channelID){
                string += " clicked";
                clickedClassIsSet = true;
            }
            
            string += `">
                <h4> ${String(channelInfo.channelname)} </h4>
                </div>`;
            $(string).appendTo("#channels-wrapper");
        }

        if (!clickedClassIsSet) {
            const firstChild = $("#channels-wrapper > div:first-child")
            firstChild.addClass("clicked")
            sessionStorage.setItem("channelID", firstChild.data("channelid"))
        }

        getMessageList()
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
            let string = "<div class='message-div' data-messageid='" + parseInt(messageInfo.messageID) 
            +"' data-senderid='"+parseInt(messageInfo.senderID)+"'>"
            +   "<div class='message-header'>"
            +       "<h4>" + String(messageInfo.senderdisplayname) + "</h4>"
            +       "<h6>";

            let messageTimeDate = messageInfo.dateTimeSent;
            let messageDate = messageTimeDate.slice(0, 10);
            let messageTime = messageTimeDate.slice(10, 16);
            if (isToday(new Date(messageDate))){
                string += "Today";
            }else if(isYesterday(new Date(messageDate))){
                string += "Yesterday";
            }else{
                string += String(formatDate(messageDate));
            }
            string += " at " + String(tConvert(messageTime)) + "</h6>"
            +   "</div>"
            +   "<div class='message-contents'>"
            +       "<h5>" + String(messageInfo.messageText) + "</h5>"
            +   "</div>"
            +   "<div class='message-options' style='display: none'>"
            +       "<img src='images/edit_icon.png' alt='editIcon' class='btnMsgEdit'>"
            +       "<img src='images/delete_icon.png' alt='deleteIcon' class='btnMsgDelete'>"
            +   "</div>"
            + "</div>";
            $(string).appendTo("#messages-wrapper");
        }
        let messagesWrapper = $("#messages-wrapper")[0];
        messagesWrapper.scrollTop = messagesWrapper.scrollHeight - messagesWrapper.clientHeight;
    };

    async function getSearchedUserList(usernameKeywordparam){
        try{
            let serverIDparam = sessionStorage.getItem("serverID");
            let response = await $.get("api/searchUsersToServer.php",
            {
                serverID: serverIDparam,
                usernameKeyword: usernameKeywordparam
            },
            function(responseInner, status){
                return responseInner;
            });
            if(response['status'] == false){
                throw new Error(String(response['message']));
            }
            printSearchedUsers(response['searchedUsers']); 
        }catch(error){
            throw error;
        }
    };

    function printSearchedUsers(searchedUsers){
        $("#users-search-wrapper").html("");
        for(let i=0; i<searchedUsers.length; i++){
            let userInfo = searchedUsers[i];
            let string = "<div data-userid='" + parseInt(userInfo.userID) + "' class='user-div option'>"
                + "<h2>" + String(userInfo.displayname) + "</h2>"
                + "<h4>#" + String(userInfo.username) + "</h4>"
                + "</div>";
            $(string).appendTo("#users-search-wrapper");
        }
    }

    $("#servers-wrapper").on('click', '.server-div', function(){
        if($(this).hasClass("clicked")) return;

        // $("#messages-rightbar").hide();
        $(".server-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        let serverID = $(this).data("serverid");
        sessionStorage.setItem("serverID", serverID);
        promiseHandler(getServerChannelList());
    });

    $("#channels-wrapper").on('click', '.channel-div', function(){
        if($(this).hasClass("clicked")) return;

        $(".channel-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        let channelID = $(this).data("channelid");
        sessionStorage.setItem("channelID", channelID);

        $("#right-page").hide();
        promiseHandler(getMessageList(), ()=>{}, (error)=>{showMessage(error)});
    });

    function openPopUpForm(callingButton){
        let callingButtonDiv = $(callingButton).parent()
        let callingPopUpForm = $(callingButtonDiv).parent();

        callingPopUpForm.addClass("blur");
        callingPopUpForm.removeClass("unblurred");

        let index = 0;

        //if multiple popUpForm are children of this popUpForm
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

    $("#btnCreateServerSection").click(() => {
        backgroundBlur();
        $("#create-server-section").show();
    });

    $(".closeBtn").click((event) => {
        closePopUpForm(event.currentTarget)
    });
    $(".noBtn").click((event) => {
        closePopUpForm(event.currentTarget)
    });

    $("#btnCreateServer").click((event) => {
        let serverName = $("#txtServerName").val();
        if(serverName == "") return;
        $(".lblServerNameConfirm").text(serverName);
        openPopUpForm(event.currentTarget);
    });
    $("#btnYESCreateServerConfirm").click((event) => {
        let serverName = $("#txtServerName").val();
        promiseHandler(createServer(serverName), ()=>{
            refresh();
            showMessage("Successfully created the server!");
        })
    });

    $("#btnCreateChannelSection").click(() => {
        backgroundBlur();
        $("#create-channel-section").show();
    });
    $("#btnCreateChannel").click((event) => {
        let channelName = $("#txtChannelName").val();
        if(channelName == "") return;
        $(".lblChannelNameConfirm").text(channelName);
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        openPopUpForm(event.currentTarget);
    });
    $("#btnYESCreateChannelConfirm").click((event) => {
        let channelName = $("#txtChannelName").val();

        promiseHandler(createServerChannel(channelName), ()=>{
            refresh();
            showMessage("Successfully created the channel!");
        }, (error)=>{
            closePopUpForm(event.currentTarget);
        })
    
    });

    //server update and delete
    $("#serverOptionDropdown").click(() => {
        $("#server-options").toggle();
    });
    function mouseOnOptionHandlerIn(optionDiv){
        $(optionDiv).addClass("hovered");
    }

    function mouseOnOptionHandlerOut(optionDiv){
        $(optionDiv).removeClass("hovered");
    }
    
    $(".option").on('mouseenter', function(){
        mouseOnOptionHandlerIn(this);
    }).on("mouseleave", function() {
        mouseOnOptionHandlerOut(this);
    });
    $("#users-search-wrapper").on('mouseenter', ".option", function(){
        mouseOnOptionHandlerIn(this);
    }).on("mouseleave", ".option", function() {
        mouseOnOptionHandlerOut(this);
    });

    $("#invitePeopleToServer").click(()=>{
        $("#user-search").show();
    });
    $("#txtUsername").on('input', function(){
        let searchedKeyword = $("#txtUsername").val();
        promiseHandler(getSearchedUserList(searchedKeyword));
    });
    $("#users-search-wrapper").on('click', ".user-div", function(){
        promiseHandler(addUserToServer($(this).data('userid')));
        let searchedKeyword = $("#txtUsername").val();
        promiseHandler(getSearchedUserList(searchedKeyword));
    });

    $("#serverSettings").click(()=>{
        $("#update-server-section").show();
    });

    $("#serverDelete").click(()=>{
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        $("#delete-server-confirm").show();
    });

    $("#btnYESUpdateServerConfirm").click((event) => {
        let newServerName = $("#txtNewServerName").val();

        promiseHandler(updateServer(newServerName), ()=>{
            refresh();
            showMessage("Successfully updated the server!");
        },(error)=>{
            closePopUpForm(event.currentTarget);
        });
    });

    $("#btnYESDeleteServerConfirm").click((event) => {
        promiseHandler(deleteServer(), ()=>{
            refresh();
            showMessage("Successfully deleted the server!");
        }, ()=>{
            closePopUpForm(event.currentTarget);
        });
    });

    $("#btnUpdateServer").click((event) => {
        let newServerName = $("#txtNewServerName").val();
        if(newServerName == "") return;
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        $(".lblNewServerName").text(newServerName);
        openPopUpForm(event.currentTarget);
    });

    //channel update and delete
    $("#channelOptionDropdown").click(() => {
        $("#channel-options").toggle();
    });

    $("#channelSettings").click(()=>{
        $("#update-channel-section").show();
    });

    $("#channelDelete").click(()=>{
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text());
        $("#delete-channel-confirm").show();
    });

    $("#btnYESDeleteChannelConfirm").click((event) => {
        promiseHandler(deleteServerChannel(), ()=>{
            refresh();
            showMessage("Successfully deleted the channel!");
        }, (error)=>{
            closePopUpForm(event.currentTarget);
        })
    });

    $("#btnUpdateChannel").click((event) => {
        let newChannelName = $("#txtNewChannelName").val();
        if(newChannelName == "") return;
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text())
        $(".lblNewChannelName").text(newChannelName);
        openPopUpForm(event.currentTarget);
    });
    $("#btnYESUpdateChannelConfirm").click((event) => {
        let newChannelName = $("#txtNewChannelName").val();
        promiseHandler(updateServerChannel(newChannelName), ()=>{
            refresh();
            showMessage("Successfully updated the channel!");
        }, (error)=>{
            closePopUpForm(event.currentTarget);
        });
    });

    $("#btnSendMessage").click(() => {
        let messageText = $("#inpMessage").val();
        $("#inpMessage").val("");
        promiseHandler(sendMessage(messageText), refresh());
    });

    function mouseOnMessageHandlerIn(messageDiv){
        if($(messageDiv).data("senderid") == sessionStorage.getItem("userID")){
            $(messageDiv).find(".message-options").show();
        }
        $(messageDiv).addClass("hovered");
    }

    function mouseOnMessageHandlerOut(messageDiv){
        $(messageDiv).find(".message-options").hide();
        $(messageDiv).removeClass("hovered");
    }

    $("#messages-wrapper").on('mouseenter', '.message-div', function(){
        mouseOnMessageHandlerIn(this);
    }).on("mouseleave", ".message-div", function() {
        mouseOnMessageHandlerOut(this);
    });

    $("#messages-wrapper").on('click', ".btnMsgEdit", function(){
        let messageDiv = $(this).parent().parent();
        sessionStorage.setItem("messageID", $(messageDiv).data("messageid"));
        let messageContents = $(messageDiv).find(".message-contents");
        let messageContentH5 = $(messageContents).find("h5");
        let string = "<textarea class='taMessageEdit'>" + $(messageContentH5).text() + "</textarea>"
        +"<div class='edit-message-options'>"
        +   "<button class='btnEditMessageSave'>Save</button>"
        +   "<button class='btnEditMessageCancel noBtn'>Cancel</button>"
        +"</div>";  
        $(messageContentH5).remove();
        $(messageContents).append(string);
        let taMessageEdit = $(messageContents).find(".taMessageEdit")[0];
        taMessageEdit.selectionStart = taMessageEdit.selectionEnd = taMessageEdit.value.length;
        taMessageEdit.focus();
    })

    $("#messages-wrapper").on('click', ".btnEditMessageCancel", ()=>{refresh()});

    $("#messages-wrapper").on('click', ".btnEditMessageSave", function(){
        let newText = $(this).parent().parent().find(".taMessageEdit").val();
        promiseHandler(updateMessage(newText), ()=>{
            refresh();
            showMessage("Successfully edited a message!");
        });
    });

    $("#messages-wrapper").on('click', ".btnMsgDelete", function(){
        sessionStorage.setItem("messageID", $(this).parent().parent().data("messageid"));
        $("#delete-message-confirm").show();
    });

    $("#btnYESDeleteMessageConfirm").click(() => {
        promiseHandler(deleteMessage(), (response)=>{
            refresh();
            showMessage("Successfully deleted the message!");
        });
    })

    // user settings btn
    $("#user-settings-btn").click(() => {
        window.location.assign("user.php");
    });

    // direct messages
    $("#direct-messages-cont").click(() => {
        sessionStorage.setItem("serverID", -1)
        sessionStorage.setItem("channelID", -1)
        // channelsMiddleBarShow()


        // $("#channels-header").html(`
        //     <h3 class="lblServerName">Direct Messages</h3>
        // `)

        // $("#channels-wrapper").html("")
    })
})

async function getUsers() {
    try {

    } catch (error) {

    }
}

function showUsersOnDirectMessage() {

}