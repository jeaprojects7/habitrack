function safe(value) {
    return (value === null || value === undefined || value === "") ? " " : value;
}

$(document).ready(function () {
    loadClientInfo();
});

function loadClientInfo() {
    $.ajax({
        url: "/habitrack/ajax/clientInfoSheet.get.ajax.php",
        method: "POST",
        dataType: "json",

        success: function (data) {

            $("#clientFName").val(safe(data.clientFName));
            $("#clientMName").val(safe(data.clientMName));
            $("#clientLName").val(safe(data.clientLName));
            $("#clientSuffix").val(safe(data.clientSuffix));

            $("#clientFullName").text(
                `${data.clientFName || ""} ${data.clientMName || ""} ${data.clientLName || ""} ${data.clientSuffix || ""}`
            );
            
            $("#clientGender").val(safe(data.clientGender));

            $("#clientBirthdate").val(
                data.clientBirthdate ? data.clientBirthdate.substring(0, 10) : ""
            );

            $("#clientPhoneNum").val(safe(data.clientPhoneNum));
            $("#clientEmail").val(safe(data.clientEmail));
            $("#clientAddress").val(safe(data.clientAddress));
        }
    });
}