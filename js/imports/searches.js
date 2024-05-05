import { clicked } from "./live.js";

export async function getSearchedUserList(usernameKeywordparam){
    try{
        let response = await $.get("api/searchUsersToServer.php",
        {
            serverID: clicked.server,
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