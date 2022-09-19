function initializeDatatable(d) {
    const tableList = $('#tableList');
    const { Url, Columns } = d;
    tableList.bootstrapTable('destroy').bootstrapTable({
            url: Url.replace(/&amp;/g, '&'),
            showFullscreen: true,
            
            // exportDataType: $(this).val(),
            exportTypes: [ 'csv', 'txt','excel'],
            columns: Columns,
            search: true
        })
    tableToolbar.onclick = () => {
        tableList.bootstrapTable('refresh');
    }
}

window.eventAjax = {
    beforeSend: function (xhr) {
        $("#tableRefreshBtn").html("Refreshing <i class='fa fa-refresh fa-spin'></i>").prop("disabled", true);
        $("#tableUpdatedDate").html(new Date().toLocaleString());
    },
    complete: function (xhr) {
        $("#tableRefreshBtn").html("Refresh <i class='fas fa-sync'></i>").prop("disabled", false);
        $("#tableUpdatedDate").html(new Date().toLocaleString());
    }
}