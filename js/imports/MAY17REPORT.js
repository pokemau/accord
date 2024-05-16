// import { clicked, clickedServerID } from "./live.js"

$(document).ready(function () {
    getReportData_17()
        .then(function (res) {
            printData(res["allData"]);
        })
        .catch((err) => {
            console.error(err);
        });
});

export async function getReportData_17() {
    try {
        let response = await $.get(
            "api/MAY17REPORT.php",
            function (responseInner, status) {
                return responseInner;
            }
        );
        return response;
    } catch (error) {
        throw error;
    }
}

function printData(allData) {
    const div = $("#report-main-cont");
    console.log(allData);
    const serverCount = allData.serverCount;
    const userCount = allData.userCount;
    const messages = allData.msgCount;

    console.log(`Server Count: ${serverCount}`);
    console.log(`User Count: ${userCount}`);

    let string = `
        <h2>Total number of servers: ${serverCount}</h2>
        <h2>Total number of users: ${userCount}</h2>
        
        <h2>Messages per server:</h2>

        <table id='report-table'>
            <thead>
                <tr>
                    <th>Server Name</th>
                    <th>Total messages</th>
                </tr>
            </thead>

            <tbody>
    `;

    messages.forEach((msg, i) => {
        string += `
            <tr>
                <td>${msg.servername}</td>
                <td>${msg.totalMessages}</td>
            </tr>
        `;
        // console.log(`${msg.servername}\nMessage Count: ${msg.totalMessages}`);
    });

    string += `
    
            
        </tbody>
        </table>
    `;

    $(string).appendTo(div);
}
