
export async function createServerChannel(channelName){
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

export async function updateServerChannel(newChannelName){
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

export async function deleteServerChannel(){
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