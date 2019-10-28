$(document).ready(function(){
    $(function () {
        changeDatatable();
    });
});


function changeDatatable()
{
    $('#dtmenu').DataTable().destroy();
    $('#tbobymenu').html('');

        $('#dtmenu').show();
        $.fn.dataTable.ext.errMode = 'throw';
        $('#dtmenu').DataTable(
            {
                responsive: true,"oLanguage":
                    {
                        "sUrl": "/js/config/datatablespanish.json"
                    },
                "lengthMenu": [[5,10,20 -1], [5,10,20, "All"]],
                "order": [[ 1, 'desc' ]],
                "searching": true,
                "info":  false,
                "ordering": false,
                "bPaginate": true,
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "destroy": true,
                "ajax": "/admin/postulantes/data",
                "columns":[

                    {data: 'identificacion', "width": "10%"},
                    {data: 'nombres', "width": "12%"},
                    {data: 'apellidos',   "width": "12%"},
                    {data: 'semestre',   "width": "10%"},
                    {data: 'request.id', "width": "10%"},
                    {data: 'request.state.descripcion', "width": "10%"},
                    {
                        data: 'actions',
                        "width": "10%",
                        "bSortable": false,
                        "searchable": false,
                        "targets": 0,
                        "render": function (data, type, row) {
                            return $('<div />').html(row.actions).text();
                        }
                    }
                ],

            }).ajax.reload();


}
