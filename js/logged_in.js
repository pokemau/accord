

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
    }

    async function createServer(serverName){
        let response = await $.post("api/createServer.php",
        {
            servername: serverName
        },
        function(responseInner, status){
            return responseInner   
        });
        if(response['status'] == false){
            if(response['errorType'] != "serverAlreadyExist"){
                location.reload();
            }else{
                await $.post("includes/messageBox.php",
                {
                    message: "Server with this name has already been created by you!"
                },
                )
            }
            throw response['message'];
        }
    }

    $("#btnCreateServerSection").on('click', function(){
        backgroundBlur();
        $("#divCreateServerSection").show();
    });
    $("#createEventAreaClose").on('click', function(){
        $("#divCreateServerSection").hide();
        unBlurEverything();
    });
    $("#btnCreateEvent").on('click', function(){
        let serverName = $("#txtServerName").val();    
        if(serverName == "") return;
        $("#lblServerName").text(serverName);
        $("#divCreateServerSection").addClass("blur");
        $("#divCreateServerConfirm").show();
    });
    $("#btnYESCreateServerConfirm").on('click', function(){
        let serverName = $("#txtServerName").val();
        try{
            createServer(serverName);
            $("#divCreateServerConfirm").addClass("blur");
            $("#divCreateServerSuccess").show();
        }catch(err){
            $("#divCreateServerConfirm").hide();
            $("#divCreateServerSection").removeClass("blur");
        }
    
    });
    $("#btnNOCreateServerConfirm").on('click', function(){
        $("#divCreateServerConfirm").hide();
        $("#divCreateServerSection").removeClass("blur");
    });
    $("#btnOKCreateServerSuccess").on('click', function(){
        refresh();
    });
})