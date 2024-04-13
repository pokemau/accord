

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
            let string = "<div data-serverID='" + Number(serverInfo.serverID) + "' class='server-div'>"
                + "<h2>" + String(serverInfo.servername) + "</h2>"
                + "</div>";
            $(string).appendTo("#servers-wrapper");
        }
    }

    $("#servers-wrapper").on('click', '.server-div', function(){
        $(".clicked").removeClass("clicked");
        $(this).addClass("clicked");
    });

    $("#btnCreateServerSection").on('click', function(){
        backgroundBlur();
        $("#create-server-section").show();
    });
    $("#btnCreateEventAreaClose").on('click', function(){
        $("#create-server-section").hide();
        unBlurEverything();
    });
    $("#btnCreateEvent").on('click', function(){
        let serverName = $("#txtServerName").val();    
        if(serverName == "") return;
        $("#lblServerName").text(serverName);
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
})