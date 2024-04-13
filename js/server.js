$(document).ready(() => {
    $("#create-role-btn").click(() => {
        const roleName = $("#role-name-input").val();
        const canEditServer = $("#server-role-edit-server").is(":checked")
            ? 1
            : 0;
        const canDeleteServer = $("#server-role-delete-server").is(":checked")
            ? 1
            : 0;

        if (
            (canEditServer == 0 && canEditServer == 0) ||
            roleName.length == 0
        ) {
            return;
        }

        createServerRole(roleName, canEditServer, canDeleteServer)
            .then((res) => {
                console.log(res);
                $("#role-name-input").val("");
                $("#server-role-edit-server").prop("checked", false);
                $("#server-role-delete-server").prop("checked", false);
            })
            .catch((error) => {
                console.log("ERR");
            });
    });
});

async function createServerRole(roleName, canEditServer, canDeleteServer) {
    try {
        const response = await $.post(
            "api/serverRole/createServerRole.php",
            {
                roleName: roleName,
                canEditServer: canEditServer,
                canDeleteServer: canDeleteServer,
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
