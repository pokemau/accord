import { getServerChannelList } from "./serverchannels.js"

export async function createServer(serverName){
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

export async function updateServer(newServerName){
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

export async function addUserToServer(userIDToJoin){
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

export async function deleteServer(){
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

export async function getServerList(){
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

    getServerChannelList();
    channelsMiddleBarShow();
}