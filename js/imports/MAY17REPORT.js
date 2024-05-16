// import { clicked, clickedServerID } from "./live.js"

$(document).ready(function () {
    getReportData()
        .then(function (res) {
            printData(res["allData"]);
        })
        .catch((err) => {
            console.error(err);
        });
});

async function getReportData() {
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
    console.log(allData);
}
