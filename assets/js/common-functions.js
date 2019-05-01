var serverAddress = 'http://localhost/experiments/spotify/spotify-list-top-songs'
var api = serverAddress + "/api/v1"

function renderTableData(template, uri, table, successCallback = null, errorCallback = null) {
    $.ajax({
        type: "get",
        url: api + uri,
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
            let status = jqXHR.status
            let templateStructure = $(template).html()
            let output = Mustache.render(templateStructure, data)
            table = $(table)
            table.find('tbody').html(output)
            table.DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            })
            if (successCallback != null) {
                successCallback(data, textStatus, jqXHR)
            }
        },
        error: function (jqXHR) {
            let status = jqXHR.status
            showNotification('danger', 'Something went wrong')
            if (errorCallback != null) {
                errorCallback()
            }
        }
    })
}

function renderData(template, uri, target, isToAppend = false, successPreCall = null, successCallback = null, errorCallback = null) {
    $.ajax({
        type: "get",
        url: api + uri,
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
            if (successPreCall != null) {
                data = successPreCall(data)
            }
            let status = jqXHR.status
            let templateStructure = $(template).html()
            let output = Mustache.render(templateStructure, data)
            if (isToAppend) {
                $(target).append(output)
            } else {
                $(target).hide().html(output).fadeIn('slow')
            }
            if (successCallback != null) {
                successCallback(data, textStatus, jqXHR)
            }
        },
        error: function (jqXHR) {
            let status = jqXHR.status
            console.log(jqXHR)
            showNotification('danger', 'Something went wrong')
            if (errorCallback != null) {
                errorCallback()
            }
        }
    })
}

function renderDataWithObject(template, target, object, isToAppend = false, successCallback = null,) {
    let templateStructure = $(template).html()
    let output = Mustache.render(templateStructure, object)
    if (isToAppend) {
        $(target).append(output)
    } else {
        $(target).hide().html(output).fadeIn('slow')
    }
    if (successCallback != null) {
        successCallback(object)
    }
}


function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=')

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1]
        }
    }
}

function showNotification(type, message, timer = 2000) {
    $.notify({
        message: message
    }, {
        type: type,
        timer: timer,
        placement: {
            from: 'top',
            align: 'right'
        }
    })
}
