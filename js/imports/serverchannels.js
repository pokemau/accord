import { getMessageList } from "./messages.js"

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

export async function getServerChannelList(){
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