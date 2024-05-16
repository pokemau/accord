// import { clicked, clickedServerID } from "./live.js"

export async function getReportData_17() {
    let response = await $.get(
        "api/MAY17REPORT.php",
        {},
        function (responseInner, status) {
            return responseInner;
        }
    );

    console.log(response["allData"]);
    printReportData(response["allData"]);
}

function printReportData(allData) {}
