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
