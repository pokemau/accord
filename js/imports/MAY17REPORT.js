export async function getReportData_17() {
    let response = await $.get(
        "api/MAY17REPORT.php",
        {},
        function (responseInner, status) {
            return responseInner;
        }
    );

    printReportData(response["allData"]);
}

function printReportData(allData) {
    console.log(allData);
}
