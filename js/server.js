import {
    createRole,
    deleteRole,
    editRole,
    getRoleDetails,
    getServerDetails,
    getServerRoles,
    updateServer,
} from "./imports/serversettings.js";
import { getCheckboxValue } from "./imports/utilities.js";

$(document).ready(function () {
    const currServerID = JSON.parse(sessionStorage.getItem("clicked")).server;

    let serverName = getServerDetails(currServerID).then(function (res) {
        $("#server-name").text(res);
        $("#main-body").find("input[type='text']").val(res);
        serverName = res;
    });
    const serverOverviewSetting = $("#server-overview-setting");
    const serverRolesSetting = $("#server-roles-setting");

    serverOverviewSetting.click(function () {
        serverRolesSetting.removeClass("hovered");
        serverOverviewSetting.addClass("hovered");
        showServerOverviewUI(serverName);
    });

    serverRolesSetting.click(function () {
        serverRolesSetting.addClass("hovered");
        serverOverviewSetting.removeClass("hovered");
        showServerRolesUI();
    });

    ///////////////////////// OVERVIEW ///////////////////////
    $("#main-body").on("click", "#save-edit-server-name-btn", function () {
        const inputVal = $("#main-body").find("input[type='text']").val();

        if (inputVal == serverName) {
            return;
        }

        updateServer(currServerID, inputVal).then(function (res) {
            console.log(res);
        });
    });

    $("#main-body").on("click", "#create-role-btn", function () {
        resetCreateRoleFields();
        const createRoleModal = $("#create-role-modal")[0];
        createRoleModal.showModal();
    });

    $("#main-body").on("click", "#edit-role-btn", function () {
        const editRoleModal = $("#edit-role-modal")[0];

        currRoleID = $(this).closest(".role-cont").attr("data-roleid");

        getRoleDetails(currServerID, currRoleID).then(function (res) {
            const resRoleDetails = res.roleDetails[0];

            const canDeleteServer = resRoleDetails.canDeleteServer;
            const canEditServer = resRoleDetails.canEditServer;
            const canEditChannel = resRoleDetails.canEditChannel;
            const canCreateChannel = resRoleDetails.canCreateChannel;

            if (canDeleteServer == 1) {
                $("#edit-can-delete-server-checkbox").prop("checked", true);
            }
            if (canEditServer == 1) {
                $("#edit-can-edit-server-checkbox").prop("checked", true);
            }
            if (canCreateChannel == 1) {
                $("#edit-can-create-channel-checkbox").prop("checked", true);
            }
            if (canEditChannel == 1) {
                $("#edit-can-edit-channel-checkbox").prop("checked", true);
            }

            $("#edit-role-name-input").val(res.roleDetails[0].roleName);
        });
        editRoleModal.showModal();
    });

    $("#save-create-role-btn").click(function () {
        const roleName = $("#create-role-name-input").val();
        const canDeleteServer = getCheckboxValue(
            $("#create-can-delete-server-checkbox")
        );
        const canEditServer = getCheckboxValue(
            $("#create-can-edit-server-checkbox")
        );

        const canCreateChannel = getCheckboxValue(
            $("#create-can-create-channel-checkbox")
        );
        const canEditChannel = getCheckboxValue(
            $("#create-can-edit-channel-checkbox")
        );

        if (
            roleName.length == 0 ||
            (!canDeleteServer &&
                !canEditServer &&
                !canCreateChannel &&
                !canEditChannel)
        ) {
            return;
        }

        createRole(
            currServerID,
            roleName,
            canDeleteServer,
            canEditServer,
            canCreateChannel,
            canEditChannel
        )
            .then(function (res) {
                showServerRolesUI();
                $("#create-role-modal")[0].close();
            })
            .catch((error) => {
                console.error(error);
            });
    });

    let currRoleID = -1;
    $("#main-body").on("click", "#delete-role-btn", function () {
        currRoleID = $(this).closest(".role-cont").attr("data-roleid");

        const deleteRoleModal = $("#delete-role-modal")[0];
        deleteRoleModal.showModal();
    });

    $("#cancel-create-role-btn").click(function () {
        $("#create-role-modal")[0].close();
    });
    $("#cancel-edit-role-btn").click(function () {
        $("#edit-role-modal")[0].close();
        resetEditRoleFields();
    });
    $("#deny-delete-role-modal").click(function () {
        $("#delete-role-modal")[0].close();
    });
    $("#accept-delete-role-modal").click(function () {
        deleteRole(currServerID, currRoleID)
            .then(function () {
                showServerRolesUI();
                $("#delete-role-modal")[0].close();
            })
            .catch(function (error) {
                console.error(error);
            });
    });

    $("#save-edit-role-btn").click(function () {
        const roleName = $("#edit-role-name-input").val();
        const canDeleteServer = getCheckboxValue(
            $("#edit-can-delete-server-checkbox")
        );
        const canEditServer = getCheckboxValue(
            $("#edit-can-edit-server-checkbox")
        );

        const canCreateChannel = getCheckboxValue(
            $("#edit-can-create-channel-checkbox")
        );
        const canEditChannel = getCheckboxValue(
            $("#edit-can-edit-channel-checkbox")
        );

        console.log(
            currServerID,
            roleName,
            currRoleID,
            canDeleteServer,
            canEditServer,
            canCreateChannel,
            canEditChannel
        );

        editRole(
            currServerID,
            roleName,
            currRoleID,
            canDeleteServer,
            canEditServer,
            canCreateChannel,
            canEditChannel
        )
            .then(function (res) {
                console.log(res);
                showServerRolesUI();
                $("#edit-role-modal")[0].close();
            })
            .catch((error) => {
                console.error(error);
            });
    });

    function showServerRolesUI() {
        $("#main-body").html(rolesUI);

        getServerRoles(currServerID).then(function (res) {
            for (const role of res.serverRoles) {
                $("#roles-cont").append(`
                    <div class="role-cont" data-roleid=${role.roleID}>
                        <h2 id="role-name">${role.roleName}</h2>
                        <h2 id="role-member-count">${role.members}</h2>

                        <div>
                            <button id="edit-role-btn"><img src="images/edit_icon.png" alt="Edit Icon"></button>
                            <button id="delete-role-btn"><img src="images/delete_icon.png" alt="Delete Icon"></button>
                        </div>
                    </div>
                `);
            }
        });
    }
});

function resetCreateRoleFields() {
    $("#create-role-name-input").val("");
    $("#create-can-delete-server-checkbox")[0].checked = false;
    $("#create-can-edit-server-checkbox")[0].checked = false;
    $("#create-can-create-channel-checkbox")[0].checked = false;
    $("#create-can-edit-channel-checkbox")[0].checked = false;
}
function resetEditRoleFields() {
    $("#edit-role-name-input").val("");
    $("#edit-can-delete-server-checkbox")[0].checked = false;
    $("#edit-can-edit-server-checkbox")[0].checked = false;
    $("#edit-can-create-channel-checkbox")[0].checked = false;
    $("#edit-can-edit-channel-checkbox")[0].checked = false;
}

function showServerOverviewUI(serverName) {
    $("#main-body").html(overviewUI);
    $("#main-body").find("input[type='text']").val(serverName);
}

export const overviewUI = `
      <h4>Server Name</h4>

      <input type="text" id="edit-server-name-input">

      <div id="save-server-name-change-btn">
        <button id="save-edit-server-name-btn" class="button">Save</button>
        <!-- <button id="delete-server-btn" class="button">Delete Server</button> -->
      </div>
`;

export const rolesUI = `
      <div id="roles-members-cont">
        <h3 id="roles-title">Roles</h3>
        <h3 id="members-title">Members</h3>
        <button id="create-role-btn" class="button">Create Role</button>
      </div>

      <div id="roles-cont">
      </div>
`;
