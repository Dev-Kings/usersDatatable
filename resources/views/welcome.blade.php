<!DOCTYPE html>
<html>

<head>
    <title>Laravel 8|7 Datatables Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Laravel Users</h2>
        <div class="table-responsive">
            <div class="row">
                <div class="col-md-3">
                    <label for="">From Date</label>
                    <input type="date" id="from_date" value="">
                </div>

                <div class="col-md-3">
                    <label for="">To Date</label>
                    <input type="date" id="to_date" value="">
                </div>

                <div class="col-md-3">
                    <button type="button" onclick="reload_table()" class="btn btn-info">Filter</button>
                </div>

            </div>
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr>
                        <th><button type="button" class="bulk_delete" id="bulk_delete"
                                class="delete btn btn-danger btn-sm">Delete</button></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        "info": true,
        ajax: {
            "type": "GET",
            "url": "{{ route('users.list') }}",
            "data": function( d ){
                d.from_date = document.getElementById("from_date").value;
                d.to_date = document.getElementById("to_date").value;
            },
            "dataFilter": function( data ) {
                var json = jQuery.parseJSON( data );
                json.draw = json.draw;
                json.recordsFiltered = json.total;
                json.recordsTotal = json.total;
                json.data = json.data;

                return JSON.stringify( json );
            }
        },
        "lengthMenu": [
            [25, 50, 100],
            [25, 50, 100]
        ],
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'id', name: 'id', orderable: true, searchable: true},
            {data: 'name', name: 'name', searchable: true, orderable: true},
            {data: 'phone_no', name: 'phone_no', searchable: true, orderable: true},
            {data: 'date_of_birth', name: 'date_of_birth', searchable: true, orderable: true},
            {data: 'email', name: 'email', searchable: true, orderable: true},            
            {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });

    $(document).on('click', '#bulk_delete', function(){
        var id = [];
        
        if(confirm("Are you sure you want to delete?")){
            $('.users_checkbox:checked').each(function(){
            id.push($(this).val());
        });
        if(id.length > 0){
            //alert(id);
            $.ajax({
                url: "{{ route('users.bulkdelete') }}",
                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                method: "get",
                data: {id:id},
                success: function(data){
                    console.log(data);
                    alert(data);
                    window.location.assign('users-data');
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        }else{
            alert("Please select at least one record");
        }
        }
    });
    
  });

  function reload_table(){
        $('.yajra-datatable').DataTable().ajax.reload();
    }
</script>

</html>