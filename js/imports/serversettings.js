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

async function getServerRoles() {}
async function updateServer() {}
async function deleteServer() {}
async function editRole() {}
async function deleteRole() {}
async function createRole() {}

export {
    getServerDetails,
    getServerRoles,
    updateServer,
    deleteRole,
    deleteServer,
    editRole,
    createRole,
};
