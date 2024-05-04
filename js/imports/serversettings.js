async function getServerDetails(serverID) {
    try {
        const res = await $.post(
            "api/serverSettings/getServerDetails.php",
            {
                serverID: serverID,
            },
            (res, status) => {
                return res;
            }
        );

        return res["serverName"];
    } catch (error) {
        console.error(error);
    }
}

async function getServerRoles(serverID) {
    try {
        const res = await $.post(
            "api/serverSettings/getServerRoles.php",
            {
                serverID: serverID,
            },
            (res, status) => {
                return res;
            }
        );

        return res;
    } catch (error) {
        console.error(error);
    }
}
async function updateServer() {}
async function deleteServer() {}
async function editRole() {}
async function deleteRole() {}
async function createRole(
    serverID,
    roleName,
    canDeleteServer,
    canEditServer,
    canCreateChannel,
    canEditChannel
) {
    try {
        const response = await $.post(
            "api/serverSettings/createServerRole.php",
            {
                serverID: serverID,
                roleName: roleName,
                canDeleteServer: canDeleteServer,
                canEditServer: canEditServer,
                canCreateChannel: canCreateChannel,
                canEditChannel: canEditChannel,
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

export {
    getServerDetails,
    getServerRoles,
    updateServer,
    deleteRole,
    deleteServer,
    editRole,
    createRole,
};
