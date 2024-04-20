$(document).ready(() => {
    $("#save-user-update-profile-btn").click(() => {
        const displayName = $("#input-user-display-name").val();
        const gender = $("#user-gender").find(":selected").val();
        const email = $("#input-user-email").val();
        const userName = $("#input-username").val();

        if (displayName.length == 0 && email.length == 0 && userName == 0) {
            console.log("CANNOT BE BLANK");
        }

        console.log(displayName, gender, email, userName);
        updateUser(displayName, gender, email, userName)
            .then((res) => {
                console.log(res);
                // $("#role-name-input").val("");
                // $("#server-role-edit-server").prop("checked", false);
                // $("#server-role-delete-server").prop("checked", false);
            })
            .catch((error) => {
                console.log(error.responseText);
            });
    });
});

async function updateUser(displayName, gender, email, userName) {
    try {
        const response = await $.post(
            "api/updateUser.php",
            {
                displayName: displayName,
                gender: gender,
                email: email,
                userName: userName,
            },
            (res, status) => {
                return res;
            }
        );
        return response["message"];
    } catch (error) {
        throw error;
    }
}
