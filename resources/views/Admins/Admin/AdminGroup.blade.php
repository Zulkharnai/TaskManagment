@extends('layout')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">User Groups</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#UserStoreModal" id="AddBtn">Create New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="DataTable" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Group Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="UserStoreModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="UserStoreForm">
                    @csrf
                    <input type="text" style="display: none" id="group_id" name="group_id">
                    <div class="form-group">
                        <label>Group Name</label>
                        <input type="text" class="form-control form-control-user required " name="group_name"
                            id="group_name" placeholder="Enter First Name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Group Description</label>
                        <textarea type="text" class="form-control" required name="group_description" id="group_description"
                            rows="10"></textarea>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <span id="error" style="display: none;" class="m-auto"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSubmit" onclick="AdminGroupStore()" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(function() {

Getdata();

});
var DataTable ='';
function Getdata() {

    DataTable = $("#DataTable").DataTable({
    dom: '<"top"<"left-col"B><"right-col"f>>r<"table table-striped"t>ip',
    lengthMenu: [
        [10, 25, 50, -1],
        ['10 rows', '25 rows', '50 rows', 'Show all']
    ],
    "responsive": true,
    buttons: [
            'copy', 'csv', 'excel', 'print', 'pageLength', 'colvis'
        ],
    ajax: {
        url: "{{ route('AdminGroupShow') }}",
        dataSrc: '',
    },
    columns: [{
            data: 'group_id',
        },
        {
            data: 'group_name',
        },
        {
            data: 'group_description',
        },
        {
            data: 'group_id',
            render: (id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#UserStoreModal" onclick="AdminGroupEdit('${id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="AdminGroupDelete('${id}')"><i class="fa fa-trash"></i></button>`;
                }
        }

    ]
});

$('#group_description').summernote({
                tabDisable: true,
                height: 200,
            });
}

function AdminGroupStore() {

    $("#btnSubmit").prop("disabled", true);

    $.post("{{ route('AdminGroupStore') }}", $('#UserStoreForm').serialize())
        .done((res) => {
            $("#btnSubmit").prop("disabled", false);
            if (res.success) {
            alertmsg(res.message, "success");
            DataTable.ajax.reload();
            $("#UserStoreModal").modal('hide');
            $('#UserStoreForm')[0].reset();
            } else if (res.validate) {
                alertmsg(res.message, "warning")
            } else {
                alertmsg(res.message, "danger")
            }
        })
        .fail((err) => {
            alertmsg("Something went wrong", "danger");
        });
}

function AdminGroupEdit(group_id) {
            $.get("{{ route('AdminGroupEdit') }}", {
                group_id: group_id

            }, function(data) {
                $("#group_id").val(data.data[0]['group_id']);
                $("#group_name").val(data.data[0]['group_name']);
                $('#group_description').summernote('code', data.data[0]['group_description']);
            });
        }
function AdminGroupDelete(group_id)
    {
        swal({
                title : "Are You Sure?",
                text : "Once Deleted You will not be able to recover this file",
                icon : "warning",
                buttons : true,
                dangerMode : true,
            })
            .then((willDelete) => {
                        if (willDelete) {
                            $.get("{{ route('AdminGroupDelete') }}", {
                                group_id: group_id
                            }, function(res) {
                                if (res['success']) {
                                    swal({
                                        title: "Successful...",
                                        text: res.message,
                                        icon: "success"
                                    })
                                    Getdata();
                                }
                            });
                        }
                    });
    }
</script>

@endsection
