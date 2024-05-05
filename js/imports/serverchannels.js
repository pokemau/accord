import { clicked , clickedServerID} from "./live.js" 
import { channelsHeaderNameUpdate } from "./logged-in-document.js"

export async function createServerChannel(channelName){
    try{
        let response = await $.post("api/createServerChannel.php",
        {
            serverID: clicked.server,
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
        let response = await $.post("api/updateServerChannel.php",
        {
            channelID: clicked.channels[clickedServerID()],
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
        let response = await $.post("api/deleteServerChannel.php",
        {
            channelID: clicked.channels[clickedServerID()]
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
        let serverIDparam = clicked.server;
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
    let channelID = clicked.channels[clickedServerID()];
    $("#channels-wrapper").html("");
    channelsHeaderNameUpdate()

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
        clicked.channels[clickedServerID()] = firstChild.data("channelid");
    }
}