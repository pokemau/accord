export function channelsHeaderNameUpdate(){
    let servername = $(".server-div.clicked").children().text();
    if(servername.length > 11){
        let nameSliced = servername.slice(0, 12);
        servername = nameSliced + "...";
    }
    $("#servernameHeader").text(servername);
}
export function messagesHeaderNameUpdate(){
    let channelname = "#"+$(".channel-div.clicked").children().text();
    if(channelname.length > 12){
        let nameSliced = channelname.slice(0, 11);
        channelname = nameSliced + "...";
    }
    $("#channelNameHeader").text(channelname);
}