/* TODO:
 * fill server name input with current server name
 *
 *
 *
 *
 *
 */
import { getServerDetails } from "./imports/serversettings.js";

$(document).ready(() => {
    const currServerID = sessionStorage.getItem("serverID");
    let serverName = getServerDetails(currServerID).then((res) => {
        $("#server-name").text(res);
        $("#main-body").find("input[type='text']").val(res);
        serverName = res;
    });

    // get server details
    // fill overview details
    const serverOverviewSetting = $("#server-overview-setting");
    const serverRolesSetting = $("#server-roles-setting");

    serverOverviewSetting.click(() => {
        serverRolesSetting.removeClass("hovered");
        serverOverviewSetting.addClass("hovered");
        showServerOverviewUI();
    });

    serverRolesSetting.click(() => {
        serverRolesSetting.addClass("hovered");
        serverOverviewSetting.removeClass("hovered");
        showServerRolesUI();
    });

    ///////////////////////// OVERVIEW ///////////////////////
    // $("#save-edit-server-name-btn").click(() => {
    //     console.log("EDIT");
    // });
    $("#main-body").on("click", "#save-edit-server-name-btn", () => {
        const inputVal = $("#main-body").find("input[type='text']").val();

        if (inputVal == serverName) {
            return;
        }

        console.log("YES");
    });

    $("#main-body").on("click", "#create-role-btn", () => {
        const createRoleModal = $("#create-role-modal")[0];

        createRoleModal.showModal();

        editRoleModal.css({
            display: "flex",
            flexDirection: "column",
            alignItems: "center",
            justifyContent: "center",
        });
    });

    $("#main-body").on("click", "#edit-role-btn", () => {
        const editRoleModal = $("#edit-role-modal")[0];

        editRoleModal.showModal();

        editRoleModal.css({
            display: "flex",
            flexDirection: "column",
            alignItems: "center",
            justifyContent: "center"
        });
    });

    $("#main-body").on("click", "#delete-role-btn", () => {
        const deleteRoleModal = $("#delete-role-modal")[0];
        deleteRoleModal.showModal();
    });

    $("#cancel-create-role-btn").click(() => {
        $("#create-role-modal")[0].close();
    });
    $("#cancel-edit-role-btn").click(() => {
        $("#edit-role-modal")[0].close();
    });
    $("#deny-delete-role-modal").click(() => {
        $("#delete-role-modal")[0].close();
    });

    // $("#create-role-btn").click(() => {
    //     const roleName = $("#role-name-input").val();
    //     const canEditServer = $("#server-role-edit-server").is(":checked")
    //         ? 1
    //         : 0;
    //     const canDeleteServer = $("#server-role-delete-server").is(":checked")
    //         ? 1
    //         : 0;

    //     if (
    //         (canEditServer == 0 && canDeleteServer == 0) ||
    //         roleName.length == 0
    //     ) {
    //         return;
    //     }

    //     createServerRole(roleName, canEditServer, canDeleteServer)
    //         .then((res) => {
    //             console.log(res);
    //             $("#role-name-input").val("");
    //             $("#server-role-edit-server").prop("checked", false);
    //             $("#server-role-delete-server").prop("checked", false);
    //         })
    //         .catch((error) => {
    //             console.log("ERR");
    //         });
    // });
});

function showServerOverviewUI() {
    $("#main-body").html(overviewUI);
}

function showServerRolesUI() {
    $("#main-body").html(rolesUI);
}

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

export const overviewUI = `
      <h4>Server Name</h4>

      <input type="text" id="edit-server-name-input">

      <div id="save-server-name-change-btn">
        <button id="save-edit-server-name-btn" class="button">Save</button>
        <button id="delete-server-btn" class="button">Delete Server</button>
      </div>
`;

export const rolesUI = `
      <div id="roles-members-cont">
        <h3 id="roles-title">Roles</h3>
        <h3 id="members-title">Members</h3>
        <button id="create-role-btn" class="button">Create Role</button>
      </div>

      <div id="roles-cont">
        <div id="role-cont">
          <h2 id="role-name">Me</h2>
          <h2 id="role-member-count">1</h2>

          <div>
            <button id="edit-role-btn"><img src="images/edit_icon.png" alt="Edit Icon"></button>
            <button id="delete-role-btn"><img src="images/delete_icon.png" alt="Delete Icon"></button>
          </div>
        </div>

        <div id="role-cont">
          <h2 id="role-name">Transcended</h2>
          <h2 id="role-member-count">4</h2>

          <div>
            <button id="edit-role-btn"><img src="images/edit_icon.png" alt="Edit Icon"></button>
            <button id="delete-role-btn"><img src="images/delete_icon.png" alt="Delete Icon"></button>
          </div>
        </div>
      </div>
`;
