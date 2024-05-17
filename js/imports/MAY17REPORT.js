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
    const topUsersWithLeastMessages = allData.topUsersWithLeastMessages;
    const avgUserCount = allData.avgUserCount;
    const highestUserCount = allData.highestUserCount;
    const serverMemberCount = allData.serverMembers;

    console.log(`Server Count: ${serverCount}`);
    console.log(`User Count: ${userCount}`);

    let string = `
        <h2>Total number of servers: ${serverCount}</h2>
        <h2>Total number of users: ${userCount}</h2>
        
        <h2>Messages per server:</h2>

        <table id='report-table1'>
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

    string = `
        <h2>Top 5 users with the least number of messages:</h2>

        <table id='report-table2'>
            <thead>
                <tr>
                    <th>Display Name</th>
                    <th>Messages Sent</th>
                </tr>
            </thead>

            <tbody>
    `;

    topUsersWithLeastMessages.forEach((data, i) => {
        string += `
            <tr>
                <td>${data.displayname}</td>
                <td>${data.message_count}</td>
            </tr>
        `;
    });

    string += `
    
            
        </tbody>
        </table>

        <h2>Average amount of users per server: ${parseInt(
            avgUserCount.avg_count
        )}</h2>
        <h2>The server with the most number of users: ${
            highestUserCount.servername
        } (${highestUserCount.user_count} users)</h2>

        <br>

        <h2>CHART</h2>
    `;

    $(string).appendTo(div);

    const ctx = $("#myChart");

    let serverNames = [];
    let memberCount = [];

    serverMemberCount.forEach((count, i) => {
        serverNames.push(count.servername);
        memberCount.push(count.userCount);
    });

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: serverNames,
            datasets: [
                {
                    label: "# of members",
                    data: memberCount,
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

const ctx = document.getElementById("myChart");
