$(document).ready(() => {
    const initRoleName = $("#role-name").data("rolename");
    $("#edit-role-name-input").val(initRoleName);

    $("#save-edit-role-btn").click(() => {
        const roleID = $("#role-id").data("roleid");
        const roleName = $("#edit-role-name-input").val();
        const canEditServer = $("#server-role-edit-server").is(":checked")
            ? 1
            : 0;
        const canDeleteServer = $("#server-role-delete-server").is(":checked")
            ? 1
            : 0;

        if (
            (canEditServer == 0 && canDeleteServer == 0) ||
            roleName.length == 0
        ) {
            return;
        }

        saveEditServerRole(roleID, roleName, canEditServer, canDeleteServer)
            .then((res) => {
                console.log(res);
            })
            .catch((error) => {
                console.log(error.responseText);
            });
    });
});

async function saveEditServerRole(
    roleID,
    roleName,
    canEditServer,
    canDeleteServer
) {
    try {
        const response = await $.post(
            "saveEditRole.php",
            {
                roleID: roleID,
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
