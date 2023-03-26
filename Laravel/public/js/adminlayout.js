function resetFields(parentId) {
    $(parentId + " :text").val("");
}

$(".numeric").keypress(function (event) {
    return event.charCode >= 48 && event.charCode <= 57
});

function ScrollTop() {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
}

function showSuccessMessgae(messgae) {
    $.smallBox({
        title: "Success",
        content: messgae,
        color: "#659265",
        iconSmall: "fa fa-check fa-2x fadeInRight animated",
        timeout: 2000
    });

}

function showErrorMessgae(messgae, type) {

    $.smallBox({
        title: "ERROR",
        content: messgae,
        color: "#C46A69",
        iconSmall: "fa fa-times fa-2x fadeInRight animated",
        timeout: 4000
    });

}

function showInfoMessgae(messgae, type) {

    messgae = "INFORMATION!!! " + messgae;
    $.bootstrapGrowl(messgae, {
        type: 'info',
        delay: 2000,
    });
}

function showWarningMessgae(messgae, type) {
    messgae = "WARNING!!! " + messgae;
    $.bootstrapGrowl(messgae, {
        type: 'warning',
        delay: 2000,
    });
}

function CallAjaxService(type, cache, url, dataType, data, onSuccess) {

    if (dataType == undefined)
        dataType = 'JSON';
    if (type == "POST") {
        $.ajax({
            type: type,
            cache: cache,
            dataType: dataType, // from the server
            url: url,
            crossDomain: true,
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: onSuccess,
            error: onAjaxError
        });
    } else {
        $.ajax({
            type: type,
            cache: cache,
            dataType: dataType, // from the server
            url: url,
            crossDomain: true,
            contentType: 'application/json',
            success: onSuccess,
            error: onAjaxError
        });
    }
}

function onAjaxError(data, errorType, error) {

    alert("ajax error");

}

function changeCurrentUserPasswordModal() {

    $.ajax({
        type: "Get",
        url: baseAppLink + "Account/ChangePasssword",
        contentType: "application/json",
        dataType: "html",

        success: function (result) {
            $('#updateCurrentUserPasswordBody').html(result);
            $("#editCurrentUserPasswordModal").modal('show');
            $("#btnUpdateCurrentUserPassword").off().click(updateCurrentUserPassword);

        },
        error: function (err) {
            showErrorMessgae(err.message);

        }
    });

}

var updateCurrentUserPassword = function () {

    if ($("#updateCurrentUserPasswordForm").valid()) {
        var updateCntrls = $(".updateCurrentUserPassword");

        var objUser = new Object();
        for (var i = 0; i < updateCntrls.length; i++) {
            objUser[updateCntrls[i].id.replace("Entity_", "")] = updateCntrls[i].value;
        }
        objUser["IsSuperAdmin"] = false;

        $.ajax({
            type: "POST",
            url: baseApiLink + "User/ChangePassword",
            data: JSON.stringify(objUser),
            contentType: "application/json",
            dataType: "json",

            success: function (result) {
                if (result.StatusCode == 1) {
                    showSuccessMessgae(result.Message);
                    $("#editCurrentUserPasswordModal").modal('hide');
                    $('#updateCurrentUserPasswordBody').html("");
                } else if (result.StatusCode == 0) {
                    showErrorMessgae(result.Message);
                }

            },
            error: function (err) {
                showErrorMessgae(err.message);
            }
        });
    }
}

var postdocumentModal = function (url) {

    $.ajax({
        type: "Get",
        url: url,
        contentType: "application/json",
        dataType: "html",

        success: function (result) {
            $('#commonModalDialog').html(result);
            $("#commonModal").modal('show');
        },
        error: function (err) {
            showErrorMessgae(err.message);
            //$(editItemCategoryModelSelector).modal('hide');
        }
    });

}

var postdocument = function (docId, docTypeId, tableId) {
    $.ajax({
        type: "POST",
        url: baseApiLink + "ItemActivity/Post?docId=" + docId + "&docTypeId=" + docTypeId,
        contentType: "application/json",
        dataType: "json",

        success: function (result) {
            if (result.StatusCode == 1) {

                $("#commonModal").modal('hide');
                showSuccessMessgae(result.Message);
                $('#' + tableId).DataTable().ajax.reload();
                $('#commonModalDialog').html("");


            } else if (result.StatusCode == 0) {
                showErrorMessgae(result.Message);
            }

        },
        error: function (err) {
            showErrorMessgae(err.message);
        }
    });
}
