

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
        $("#channels-middlebar").hide();
        $("#messages-rightbar").hide();
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

    async function updateServer(toUpdateServerID, newServerName){
        try{
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

    async function deleteServer(toDeleteServerID){
        try{
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

    async function updateServerChannel(toUpdateChannelID, newChannelName){
        try{
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

    async function deleteServerChannel(toDeleteChannelID){
        try{
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
        $("#channels-middlebar").show();
        for(let i=0; i<channelList.length; i++){
            let channelInfo = channelList[i];
            let string = "<div data-channelID='" + Number(channelInfo.channelID) + "' class='channel-div'>"
                + "<h4>" + String(channelInfo.channelname) + "</h4>"
                + "</div>";
            $(string).appendTo("#channels-wrapper");
        }
    }

    $("#servers-wrapper").on('click', '.server-div', function(){
        if($(this).hasClass("clicked")) return;

        $("#messages-rightbar").hide();
        $(".server-div.clicked").removeClass("clicked");
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

    $("#channels-wrapper").on('click', '.channel-div', function(){
        if($(this).hasClass("clicked")) return;

        $(".channel-div.clicked").removeClass("clicked");
        $(this).addClass("clicked");
        let channelID = $(this).data("channelid");
        sessionStorage.setItem("channelID", channelID);

        $("#channelNameHeader").html("#"+$(".channel-div.clicked").children().text());

        $("#messages-rightbar").show();
        $("#right-page").hide();
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
        $(".lblServerNameConfirm").text(serverName);
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
        $(".lblChannelNameConfirm").text(channelName);
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

    //server update and delete
    $("#serverSettings").on('click', function(){
        backgroundBlur();
        $("#update-delete-server-section").show();
    });
    $("#btnUpdateServerSectionClose").on('click', function(){
        $("#update-delete-server-section").hide();
        unBlurEverything();
    });
    $("#btnUpdateServer").on('click', function(){
        let newServerName = $("#txtNewServerName").val();
        if(newServerName == "") return;
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        $(".lblNewServerName").text(newServerName);
        $("#update-delete-server-section").addClass("blur");
        $("#update-server-confirm").show();
    });
    $("#btnYESUpdateServerConfirm").on('click', function(){
        let newServerName = $("#txtNewServerName").val();

        updateServer(sessionStorage.getItem("serverID"), newServerName)
            .then(response => {
                $("#update-server-confirm").addClass("blur");
                $("#update-server-success").show();
            })
            .catch(error => {
                if(typeof error == String){
                    showMessage(error);
                }else{
                    showMessage("Please dont include \' or \" in the server name");
                    console.log(error);
                }
                $("#update-server-confirm").hide();
                $("#update-delete-server-section").removeClass("blur");
            });
    
    });
    $("#btnNOUpdateServerConfirm").on('click', function(){
        $("#update-server-confirm").hide();
        $("#update-delete-server-section").removeClass("blur");
    });

    $("#btnDeleteServer").on('click', function(){
        $(".lblServerNameConfirm").text($(".server-div.clicked").children().text())
        $("#update-delete-server-section").addClass("blur");
        $("#delete-server-confirm").show();
    });
    $("#btnYESDeleteServerConfirm").on('click', function(){
        deleteServer(sessionStorage.getItem("serverID"))
            .then(response => {
                $("#delete-server-confirm").addClass("blur");
                $("#delete-server-success").show();
            })
            .catch(error => {
                if(typeof error == String){
                    showMessage(error);
                }
                $("#delete-server-confirm").hide();
                $("#update-delete-server-section").removeClass("blur");
            });
    
    });
    $("#btnNODeleteServerConfirm").on('click', function(){
        $("#delete-server-confirm").hide();
        $("#update-delete-server-section").removeClass("blur");
    });


    //channel update and delete
    $("#channelSettings").on('click', function(){
        backgroundBlur();
        $("#update-delete-channel-section").show();
    });
    $("#btnUpdateChannelSectionClose").on('click', function(){
        $("#update-delete-channel-section").hide();
        unBlurEverything();
    });
    $("#btnUpdateChannel").on('click', function(){
        let newChannelName = $("#txtNewChannelName").val();
        if(newChannelName == "") return;
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text())
        $(".lblNewChannelName").text(newChannelName);
        $("#update-delete-channel-section").addClass("blur");
        $("#update-channel-confirm").show();
    });
    $("#btnYESUpdateChannelConfirm").on('click', function(){
        let newChannelName = $("#txtNewChannelName").val();

        updateServerChannel(sessionStorage.getItem("channelID"), newChannelName)
            .then(response => {
                $("#update-channel-confirm").addClass("blur");
                $("#update-channel-success").show();
            })
            .catch(error => {
                if(typeof error == String){
                    showMessage(error);
                }else{
                    showMessage("Please dont include \' or \" in the channel name");
                    console.log(error);
                }
                $("#update-channel-confirm").hide();
                $("#update-delete-channel-section").removeClass("blur");
            });
    
    });
    $("#btnNOUpdateChannelConfirm").on('click', function(){
        $("#update-channel-confirm").hide();
        $("#update-delete-channel-section").removeClass("blur");
    });

    $("#btnDeleteChannel").on('click', function(){
        $(".lblChannelNameConfirm").text($(".channel-div.clicked").children().text())
        $("#update-delete-channel-section").addClass("blur");
        $("#delete-channel-confirm").show();
    });
    $("#btnYESDeleteChannelConfirm").on('click', function(){
        deleteServerChannel(sessionStorage.getItem("channelID"))
            .then(response => {
                $("#delete-channel-confirm").addClass("blur");
                $("#delete-channel-success").show();
            })
            .catch(error => {
                if(typeof error == String){
                    showMessage(error);
                }
                $("#delete-channel-confirm").hide();
                $("#update-delete-channel-section").removeClass("blur");
            });
    
    });
    $("#btnNODeleteChannelConfirm").on('click', function(){
        $("#delete-channel-confirm").hide();
        $("#update-delete-channel-section").removeClass("blur");
    });

    
    $(".btnOKSuccess").on('click', function(){
        refresh();
    });

    // user settings btn
    $("#user-settings-btn").click(() => {
        window.location.assign("user.php");
    });
})