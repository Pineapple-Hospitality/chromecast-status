<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.jqueryui.min.css">
<style>
.f32 .flag {
        vertical-align: middle;
        margin: -8px 0;
    }

    progress {
        width: 100%;
    }
</style>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.jqueryui.min.js"></script>
<script>
$(document).ready(function () {
    var table = $('#table_lsd').DataTable({
        ajax: 'get_lsd_data.php',
	//processing: true,
        //serverSide: true,
	aLengthMenu: [
        	[25, 50, 100, 200, -1],
        	[25, 50, 100, 200, "All"]
    	],
        columns: [
	    {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            {	data: "hotelCode" },
            {	data: 'roomNumber' },
	    {	data: 'activeIP' },
	    {	data: 'seen_date' },
	    {	data: 'chromecast_devicedata' },
	    {   data: 'signalStrength',
	    	render: function (data, type, row, meta) {
                    return type === 'display'
                        ? '<progress value="' + data + '" max="0"></progress>'
                        : data;
                }
	    }
	]
    });

    setInterval(function () {
	$('#table_lsd').DataTable().ajax.reload()
    }, 10000);

    // Add event listener for opening and closing details
    $('#table_lsd tbody').on('click', 'td.dt-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      if (row.child.isShown()) {
         // This row is already open - close it
         row.child.hide();
         tr.removeClass('shown');
      } else {
	var macId = row.data().activeMAC;
	var strReturn = "";
	console.log(macId);
	jQuery.ajax({
    		url: "get_room_data.php?mac="+macId,
    		success: function(data) {
      			strReturn = data;
    		},
    		async:false
  	});
	// Open this row
       	row.child(format(JSON.parse(strReturn))).show();
        tr.addClass('shown');
      }
    });

});

function format(d) {
    return (
        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Room number:</td>' +
        '<td>' +
        d.lastname +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Hotel Info:</td>' +
        '<td>' +
        d.firstname +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Extra info:</td>' +
        '<td>' + d.username + '</td>' +
        '</tr>' +
        '</table>'
    );
}
</script>
</head>
<body>
    <table id="table_lsd" class="display" style="width:100%">
        <thead>
            <tr>
		<th></th>
                <th>Hotel Code</th>
                <th>Room Number</th>
                <th>Current IP</th>
                <th>Last seen</th>
		<th>Device Data</th>
		<th>Signal Strength</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
		<th></th>
                <th>Hotel Code</th>
                <th>Room Number</th>
                <th>Current IP</th>
                <th>Last seen</th>
		<th>Device Data</th>
		<th>Signal Strength</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
