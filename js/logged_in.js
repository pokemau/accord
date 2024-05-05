import { createServer, updateServer, addUserToServer, deleteServer, getServerList } 
    from "./imports/servers.js";
import { createServerChannel, updateServerChannel, deleteServerChannel, getServerChannelList } 
    from "./imports/serverchannels.js";
import { sendMessage, updateMessage, deleteMessage, getMessageList }
    from "./imports/messages.js";
import { clicked, getClickedInfo, clickedServerID, clickedChannelID, getCurrUserID} 
    from "./imports/live.js";
import { getSearchedUserList } from "./imports/searches.js";
import { showPopUpDialog, hidePopUpDialog, hideAllPopUpDialog, showMessage } from "./imports/utilities.js";
$(document).ready(function(){
    getClickedInfo();
    refresh();
      
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

    function refresh(){
        promiseHandler(getCurrUserID());
        hideAllPopUpDialog();
        $(".options-form").hide();
        $("#replying-to-group").hide();
        let promiseServers = getServerList();
        let promiseChannels = $.Deferred();     //initialize a promise-type in case we dont go through an async func
        if($(".server-div.clicked")){        //if clicked server-div exists already, just update the channelslist
            promiseHandler(promiseServers, ()=>{
                promiseHandler(getServerChannelList(), (response)=>{
                    promiseChannels.resolve(response);
                }, (error)=>{
                    promiseChannels.reject(error);
                })
            })
        }else{      //else complete initialized 'resolved' promise and hide channels
            promiseChannels.resolve();      //resolves the initialized promise cuz we dont have async func
        }

        promiseChannels.done(function(){
            if($(".channel-div.clicked")[0]){       //if channel div has clicked, wait for updated channels before showing messages 
                promiseHandler(getMessageList());
            }
        });
    }
    function stopButtonIfInputEmpty(event){
        if($(event.currentTarget).parent().find("input, textarea").first().val().length === 0){
            return true;
        }
        return false;
    }

    //pressing enter when typing in input/textarea
    $("input, textarea").on('keyup', (event) => {
        if(event.keyCode == 13){    //pressed Enter key
            $(event.currentTarget).parent().find(".submitBtn").first().click();
            $(event.currentTarget).val("");
        }
    });
    
    //close options forms when clicking anything other than it
    var stopOptionFormPropagation = false;
    function optionsFormHidingHandler(){
        if(!stopOptionFormPropagation){
            $(".options-form").hide();
        }
        stopOptionFormPropagation = false;
    }
    $("#user-search, #update-server-section, #delete-server-confirm").click(() => {
        stopOptionFormPropagation = true;
    });
    $("#update-channel-section, #delete-channel-confirm").click(() => {
        stopOptionFormPropagation = true;
    })

    $("html").click(() => {
        optionsFormHidingHandler();
    })
    $(".options-form, .options-dropdown").click((event) => {
        stopOptionFormPropagation = true;
    })

    $("#servers-wrapper").on('click', '.server-div', function(){
        if($(this).hasClass("clicked")) return;

        $(".server-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        clicked.server = clickedServerID();
        sessionStorage.setItem('clicked', JSON.stringify(clicked));
        promiseHandler(getServerChannelList(), ()=>{promiseHandler(getMessageList())});
    });

    $("#channels-wrapper").on('click', '.channel-div', function(){
        if($(this).hasClass("clicked")) return;

        $(".channel-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        clicked.channels[clickedServerID()] = clickedChannelID();
        sessionStorage.setItem('clicked', JSON.stringify(clicked));

        $("#right-page").hide();
        $("#btnCloseReplyGroup").click();       //close reply-to-group when changing channel
        promiseHandler(getMessageList(), ()=>{}, (error)=>{showMessage(error)});
    });

    $("#btnCreateServerSection").click(() => {
        showPopUpDialog($("#create-server-section"));
    });

    $(".closeBtn, .noBtn").click((event) => {
        hidePopUpDialog($(event.currentTarget).parent().parent());
    });

    $("#btnCreateServer").click((event) => {
        if(stopButtonIfInputEmpty(event)) return;
        let serverName = $("#txtServerName").val();
        if(serverName == "") return;
        $(".lblServerNameConfirm").text(serverName);
        showPopUpDialog($("#create-server-confirm"));
    });
    $("#btnYESCreateServerConfirm").click((event) => {
        let serverName = $("#txtServerName").val();
        promiseHandler(createServer(serverName), ()=>{
            refresh();
            showMessage("Successfully created the server!");
        })
    });

    $("#btnCreateChannelSection").click(() => {
        showPopUpDialog($("#create-channel-section"));
    });
    $("#btnCreateChannel").click((event) => {
        if(stopButtonIfInputEmpty(event)) return;
        let channelName = $("#txtChannelName").val();
        if(channelName == "") return;
        $(".lblChannelNameConfirm").text(channelName);
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        showPopUpDialog($("#create-channel-confirm"));
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
    $("#serverOptionDropdown").click((event) => {
        let isInitialStateShown = $("#server-options").is(":visible");
        $(".options-form").hide();
        if(!isInitialStateShown){
            $("#server-options").show();
        }
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
        console.log(searchedKeyword.length);
        if(searchedKeyword.length === 0){
            $("#users-search-wrapper").html("");
            return;
        }
        promiseHandler(getSearchedUserList(searchedKeyword));
    });
    $("#users-search-wrapper").on('click', ".user-div", function(){
        promiseHandler(addUserToServer($(this).data('userid')));
        let searchedKeyword = $("#txtUsername").val();
        promiseHandler(getSearchedUserList(searchedKeyword));
    });

    $("#serverSettings").click(()=>{
        window.location.href = "server.php";
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
        if(stopButtonIfInputEmpty(event)) return;
        let newServerName = $("#txtNewServerName").val();
        if(newServerName == "") return;
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        $(".lblNewServerName").text(newServerName);
        showPopUpDialog($("#update-server-confirm"));
    });

    //channel update and delete
    $("#channelOptionDropdown").click(() => {
        let isInitialStateShown = $("#channel-options").is(":visible");
        $(".options-form").hide();
        if(!isInitialStateShown){
            $("#channel-options").show();
        }
    });

    $("#channelSettings").click(()=>{
        showPopUpDialog($("#update-channel-section"));
    });

    $("#channelDelete").click(()=>{
        $(".lblServerChannelConfirm").text($(".channel-div.clicked").children().text());
        showPopUpDialog($("#delete-channel-confirm"));
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
        if(stopButtonIfInputEmpty(event)) return;
        let newChannelName = $("#txtNewChannelName").val();
        if(newChannelName == "") return;
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text())
        $(".lblNewChannelName").text(newChannelName);
        showPopUpDialog($("#update-channel-confirm"));
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

    $("#btnCloseReplyGroup").click(() => {
        $("#replying-to-group").hide();
        $("#taInpMessage").data("repliedmessageid", -1);
    });

    $("#btnSendMessage").click((event) => {
        if(stopButtonIfInputEmpty(event)) return;
        let messageText = $("#taInpMessage").val();
        let repliedMessageID = $("#taInpMessage").data("repliedmessageid");
        promiseHandler(sendMessage(messageText, repliedMessageID), refresh());
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

    $("#messages-wrapper").on('click', ".btnMsgReply", function(){
        let messageDiv = $(this).parent().parent();
        let messageToReplyID = $(messageDiv).data("messageid");
        $("#taInpMessage").data("repliedmessageid", messageToReplyID);
        $("#replying-to-display-name").text($(messageDiv).find(".display-name").first().text());
        $("#replying-to-group").show();
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
    });

    // user settings btn
    $("#user-settings-btn").click(() => {
        window.location.assign("user.php");
    });

    // direct messages
    $("#direct-messages-cont").click(() => {
        sessionStorage.setItem("serverID", -1)
        sessionStorage.setItem("channelID", -1)


        // $("#channels-header").html(`
        //     <h3 class="lblServerName">Direct Messages</h3>
        // `)
    });

    $("#btnReport").click(() => {
        if($("#right-page").is(":visible")){
            $("#right-page").hide();
        }else{
            $("#right-page").show();
        }
    })

})

async function getUsers() {
    try {
        let res = await $.get("api/getUsersList.php",
        (responseInner, status) => { return responseInner; });

        if (res['status'] == false) { throw new Error(String(response['message'])) }

        showUsersOnDirectMessage(response['usersList'])

    } catch (error) {

    }
}

function showUsersOnDirectMessage(usersList) {

}