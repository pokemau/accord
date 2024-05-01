export async function sendMessage(messageTextparam, repliedMessageIDparam){
    try{
        let channelIDparam = sessionStorage.getItem("channelID");
        let repliedMessageIDPOST = (repliedMessageIDparam === undefined || repliedMessageIDparam === -1) 
            ? null : repliedMessageIDparam;
        let response = await $.post("api/sendMessage.php",
        {
            channelID: channelIDparam,
            messageText: messageTextparam,
            repliedMessageID: repliedMessageIDPOST
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

export async function updateMessage(newText){
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


export async function deleteMessage(){
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

export async function getMessageList(){
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
        +"' data-senderid='"+parseInt(messageInfo.senderID)+"' id='"+parseInt(messageInfo.messageID)+"'>";
        let repliedMessageInfo = messageInfo.repliedMessageInfo
        if(repliedMessageInfo.messageID != null){
            string += "<div class='replied-message-div'>"
            +   "<img src='images\\reply_link_icon.png' alt='ReplyLinkIcon' class='reply-link-icon'>"
            +   "<h4 class='display-name'>" + String(repliedMessageInfo.senderdisplayname) + "</h4>"
            +   "<a href='#"+repliedMessageInfo.messageID+"' class='message-text'>"+ String(repliedMessageInfo.messageText) +"</a>"
            + "</div>";
        }
        string +=   "<div class='message-header'>"
        +       "<h4 class='display-name'>" + String(messageInfo.senderdisplayname) + "</h4>"
        +       "<h6 class='message-date-time'>";

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
        +       "<h5 class='message-text'>" + String(messageInfo.messageText) + "</h5>"
        +   "</div>"
        +   "<div class='message-options' style='display: none'>"
        +       "<img src='images/reply_icon.png' alt='replyIcon' class='btnMsgReply'>"
        +       "<img src='images/edit_icon.png' alt='editIcon' class='btnMsgEdit'>"
        +       "<img src='images/delete_icon.png' alt='deleteIcon' class='btnMsgDelete'>"
        +   "</div>"
        + "</div>";
        $(string).appendTo("#messages-wrapper");
    }
    let messagesWrapper = $("#messages-wrapper")[0];
    messagesWrapper.scrollTop = messagesWrapper.scrollHeight - messagesWrapper.clientHeight;
};