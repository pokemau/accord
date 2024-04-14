

$(document).ready(function(){
    var currUser = null

    refresh();

    function unBlurEverything(){
        $(".blur").removeClass('blur');
    }
    function backgroundBlur(){
        $("nav").addClass('blur');
        $("#divServerList").addClass('blur');
    }
    function refresh(){
        $(".popUpForm").hide();
        unBlurEverything();
        getServerList();
    }
    function showMessage(message){
        $("body").append("<div id='message-box'> <p>"+message+"</p> </div>");
        setTimeout(function() {
            var messageBox = document.getElementById('message-box');
            if (messageBox) {
              messageBox.parentNode.removeChild(messageBox);
            }
          }, 3000);
    }

    async function createServer(serverName){
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

    async function createServerChannel(serverIDparam, channelName){
        try{
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

    async function getServerList(){
        let response = await $.get("api/getServerList.php",
        function(responseInner, status){
            return responseInner;
        });
        if(response['status'] == false){
            console.log("Something was wrong (getServerList)");
            return;
        }
        printServers(response['serverList']);
    }

    function printServers(serverList){
        $("#servers-wrapper").html("");
        for(let i=0; i<serverList.length; i++){
            let serverInfo = serverList[i];
            let string = "<div data-serverid='" + Number(serverInfo.serverID) + "' class='server-div'>"
                + "<h2>" + String(serverInfo.servername) + "</h2>"
                + "</div>";
            $(string).appendTo("#servers-wrapper");
        }
    }

    async function getServerChannelList(serverIDparam){
        try{
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
        $("#channels-wrapper").html("");
        for(let i=0; i<channelList.length; i++){
            let channelInfo = channelList[i];
            let string = "<div data-channelID='" + Number(channelInfo.channelID) + "' class='channel-div'>"
                + "<h2>" + String(channelInfo.channelname) + "</h2>"
                + "</div>";
            $(string).appendTo("#channels-wrapper");
        }
    }

    $("#servers-wrapper").on('click', '.server-div', function(){
        $(".clicked").removeClass("clicked");
        $(this).addClass("clicked");
        let serverID = $(this).data("serverid");
        getServerChannelList(serverID)
            .then(response => {
            })
            .catch(error => {
                console.log(error);
            });
        sessionStorage.setItem("serverID", serverID);
    });

    $("#btnCreateServerSection").on('click', function(){
        backgroundBlur();
        $("#create-server-section").show();
    });
    $("#btnCreateServerSectionClose").on('click', function(){
        $("#create-server-section").hide();
        unBlurEverything();
    });
    $("#btnCreateServer").on('click', function(){
        let serverName = $("#txtServerName").val();
        if(serverName == "") return;
        $("#lblServerNameConfirm").text(serverName);
        $("#create-server-section").addClass("blur");
        $("#create-server-confirm").show();
    });
    $("#btnYESCreateServerConfirm").on('click', function(){
        let serverName = $("#txtServerName").val();

        createServer(serverName)
            .then(response => {
                $("#create-server-confirm").addClass("blur");
                $("#create-server-success").show();
            })
            .catch(error => {
                if(typeof error == String){
                    showMessage(error);
                }else{
                    showMessage("Please dont include \' or \" in the servername");
                    console.log(error);
                }
                $("#create-server-confirm").hide();
                $("#create-server-section").removeClass("blur");
            });
    
    });
    $("#btnNOCreateServerConfirm").on('click', function(){
        $("#create-server-confirm").hide();
        $("#create-server-section").removeClass("blur");
    });
    $("#btnOKCreateServerSuccess").on('click', function(){
        refresh();
    });


    $("#btnCreateChannelSection").on('click', function(){
        backgroundBlur();
        $("#create-channel-section").show();
    });
    $("#btnCreateChannelSectionClose").on('click', function(){
        $("#create-channel-section").hide();
        unBlurEverything();
    });
    $("#btnCreateChannel").on('click', function(){
        let channelName = $("#txtChannelName").val();
        if(channelName == "") return;
        $("#lblChannelNameConfirm").text(channelName);
        $("#create-channel-section").addClass("blur");
        $("#create-channel-confirm").show();
    });
    $("#btnYESCreateChannelConfirm").on('click', function(){
        let channelName = $("#txtChannelName").val();

        createServerChannel(sessionStorage.getItem("serverID"), channelName)
            .then(response => {
                $("#create-channel-confirm").addClass("blur");
                $("#create-channel-success").show();
            })
            .catch(error => {
                if(typeof error == String){
                    showMessage(error);
                }else{
                    showMessage("Please dont include \' or \" in the channel name");
                    console.log(error);
                }
                $("#create-channel-confirm").hide();
                $("#create-channel-section").removeClass("blur");
            });
    
    });
    $("#btnNOCreateChannelConfirm").on('click', function(){
        $("#create-channel-confirm").hide();
        $("#create-channel-section").removeClass("blur");
    });
    $("#btnOKCreateChannelSuccess").on('click', function(){
        refresh();
    });
})