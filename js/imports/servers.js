
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