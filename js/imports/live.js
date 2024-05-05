export var clicked;

export function getClickedInfo(){
    if(sessionStorage.getItem('clicked')){
        clicked = JSON.parse(sessionStorage.getItem('clicked'));
    }else{
        clicked = {
            server: -1,
            channels: []
        };
    }
}

export function clickedServerID(){
    return $(".server-div.clicked").data("serverid");
};

export function clickedChannelID(){
    return $(".channel-div.clicked").data("channelid");
};

export async function getCurrUserID(){
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