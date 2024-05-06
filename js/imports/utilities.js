export function showPopUpDialog(popUpDialog) {
    popUpDialog[0].show();
    popUpDialog.css({
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
    });
}

export function hidePopUpDialog(popUpDialog) {
    popUpDialog.css({
        display: "none",
    });
    popUpDialog[0].close();
}

export function hideAllPopUpDialog() {
    $("dialog").css({
        display: "none",
    });
    $("dialog")[0].close();
}

export function showMessage(message) {
    $("body").append("<div id='message-box'> <p>" + message + "</p> </div>");
    setTimeout(function () {
        var messageBox = document.getElementById("message-box");
        if (messageBox) {
            messageBox.parentNode.removeChild(messageBox);
        }
    }, 3000);
}

export function getCheckboxValue(checkbox) {
    return checkbox.is(":checked") ? 1 : 0;
}
