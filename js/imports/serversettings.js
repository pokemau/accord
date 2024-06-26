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
async function updateServer(serverID, serverName) {
    try {
        const response = await $.post(
            "api/serverSettings/updateServer.php",
            {
                serverID: serverID,
                serverName: serverName,
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
async function deleteServer() {}
async function editRole(
    serverID,
    roleName,
    roleID,
    canDeleteServer,
    canEditServer,
    canCreateChannel,
    canEditChannel
) {
    try {
        const response = await $.post(
            "api/serverSettings/updateServerRole.php",
            {
                serverID: serverID,
                roleName: roleName,
                roleID: roleID,
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

async function removeMemberFromRole(userID, roleID) {
    try {
        const response = await $.post(
            "api/serverSettings/removeMemberFromRole.php",
            {
                roleID: roleID,
                userID: userID,
            },
            (res, status) => {
                return res;
            }
        );
        return response;
    } catch (error) {
        throw error;
    }
}

async function addMemberToRole(userID, roleID) {
    try {
        const response = await $.post(
            "api/serverSettings/addMemberToRole.php",
            {
                userID: userID,
                roleID: roleID,
            },
            (res, status) => {
                return res;
            }
        );
        return response;
    } catch (error) {
        throw error;
    }
}

async function getNonRoleMembers(roleID) {
    try {
        const response = await $.post(
            "api/serverSettings/getNonRoleMembers.php",
            {
                roleID: roleID,
            },
            (res, status) => {
                return res;
            }
        );
        return response;
    } catch (error) {
        throw error;
    }
}

async function getRoleMembers(roleID) {
    try {
        const response = await $.post(
            "api/serverSettings/getRoleMembers.php",
            {
                roleID: roleID,
            },
            (res, status) => {
                return res;
            }
        );
        return response;
    } catch (error) {
        throw error;
    }
}

async function getRoleDetails(serverID, roleID) {
    try {
        const response = await $.post(
            "api/serverSettings/getRoleDetails.php",
            {
                serverID: serverID,
                roleID: roleID,
            },
            (res, status) => {
                return res;
            }
        );

        return response;
    } catch (error) {
        throw error;
    }
}
async function deleteRole(serverID, roleID) {
    try {
        const response = await $.post(
            "api/serverSettings/deleteServerRole.php",
            {
                serverID: serverID,
                roleID: roleID,
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
    getRoleDetails,
    getRoleMembers,
    removeMemberFromRole,
    getNonRoleMembers,
    addMemberToRole,
};
