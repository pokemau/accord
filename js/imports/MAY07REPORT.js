import { clicked, clickedServerID } from "./live.js"

export async function getReportData(){
    let response = await $.get("api/MAY07REPORT.php",
    {
        serverID: clicked.server,
        channelID: clicked.channels[clickedServerID()]
    },
    function(responseInner, status){
        return responseInner;
    });
    if(response['status'] == false){
        throw new Error(String(response['message']));
    }
    printReportData(response['allData']);
}

function printReportData(allData){
    let allServers = allData.allServers;
    let allServerMembers = allData.allServerMembers;
    let allMessagesFromUser = allData.allMessagesFromUser;


    let string = "<h2>UserID: "+sessionStorage.getItem("userID")+"</h2>"
    + "<h2>Displayname: " + sessionStorage.getItem("displayname") + "</h2>"
    + "<br>"
    + "<h2>All Servers</h2>"
    + "<table id='tblservers'>"
    + "<thead>"
    +    "<tr>"
    +      "<th>Server Name</th>"
    +    "</tr>"
    +  "</thead>"
    +  "<tbody>";
    for(let i=0; i<allServers.length; i++){
        string += "<tr>"
        +   "<td>" + allServers[i] + "</td>"
        +   "</tr>";
    }
    string += "</tbody>"
    +   "</table>"
    + "<br>";

    string += "<h2>All Server Members</h2>"
    + "<table id='tblservermembers'>"
    + "<thead>"
    +    "<tr>"
    +      "<th>Display Name</th>"
    +      "<th>Birth Date</th>"
    +    "</tr>"
    +  "</thead>"
    +  "<tbody>";
    for(let i=0; i<allServerMembers.length; i++){
        string += "<tr>"
        +   "<td>" + allServerMembers[i].displayname + "</td>"
        +   "<td>" + allServerMembers[i].birthdate + "</td>"
        +   "</tr>";
    }
    string += "</tbody>"
    +   "</table>"
    + "<br>";

    string += "<h2>All Messages By Me</h2>"
    + "<table id='tblusermessages'>"
    + "<thead>"
    +    "<tr>"
    +      "<th>Message Text</th>"
    +      "<th>DateTime Sent</th>"
    +    "</tr>"
    +  "</thead>"
    +  "<tbody>";
    for(let i=0; i<allMessagesFromUser.length; i++){
        string += "<tr>"
        +   "<td>" + allMessagesFromUser[i].messageText + "</td>"
        +   "<td>" + allMessagesFromUser[i].dateTimeSent + "</td>"
        +   "</tr>";
    }
    string += "</tbody>"
    +   "</table>"
    + "<br>";

    $("#right-page").html("");
    $(string).appendTo("#right-page");
}