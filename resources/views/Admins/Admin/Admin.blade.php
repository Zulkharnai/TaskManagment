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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">User Informations</div>
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
                            <th>Image</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Group</th>
                            <th>Date</th>
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
                    <input type="text" style="display: none" id="user_id" name="user_id">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control form-control-user required " name="user_first_name"
                            id="user_first_name" placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control form-control-user required " name="user_last_name"
                            id="user_last_name" placeholder="Enter Last Name">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="text" class="form-control form-control-user required " name="user_email"
                            id="user_email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label>User Password</label>
                        <input type="password" class="form-control form-control-user required " name="user_password"
                            id="user_password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control form-control-user required " name="user_phone"
                            id="user_phone" placeholder="Enter Phone">
                    </div>
                    <div class="form-group">
                        <label>Group</label>
                        <select name="group_id" id="group_id" class="form-control form-control-user">
                            <option selected disabled>Select Group</option>
                        @foreach ($group as $item)
                        <option value="{{ $item->group_id}}">{{ $item->group_name}}</option>
                        @endforeach
                        {{-- <option value="test">test</option> --}}
                    </select>
                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        <select name="user_type" id="user_type" class="form-control form-control-user">
                            <option selected disabled>Select User Type</option>
                            <option value="0">Admin</option>
                            <option value="1">Employee</option>
                    </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Image</label>
                        <input type="file" accept="image/*" class="form-control" name="user_image"
                            id="user_image">
                    </div>

                    <div class="formgroup">
                        <label>Status</label>
                        <input type="hidden" name="user_status" id="status_value">
                        <input type="checkbox" id="user_status" {{$data[0]->team_member_status ?? 1 ? "" : "checked"}}>
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <span id="error" style="display: none;" class="m-auto"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnSubmit" onclick="AdminStore()" class="btn btn-primary">Submit</button>
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
        url: "{{ route('AdminShow') }}",
        dataSrc: '',
    },
    columns: [{
            data: 'user_id',
        },
        {
            data: 'user_image',
            render: (user_image)=>{return `<img class ="datable-img" width="100px" height="100px" src="{{url('public/Admin')}}/${user_image}">`}
        },
        {
            data: 'user_first_name',
        },
        {
            data: 'user_last_name',
        },
        {
            data: 'user_email',
        },
        {
            data: 'user_phone',
        },
        {
            data: 'user_status',
            render: (user_status) => {
                    return `${user_status == 0 ? "<p class='btn btn-danger'>Deactivate</p>" : "<p class='btn btn-success'>Active</p>"}`;
                }
        },
        {
            data: 'group_name',
        },
        {
            data: 'created_date',
        },
        {
            data: 'user_id',
            render: (user_id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#UserStoreModal" onclick="UserEdit('${user_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="UserRemove('${user_id}')"><i class="fa fa-trash"></i></button>`;
                }
        }

    ]
});
}

function AdminStore() {

    $("#btnSubmit").prop("disabled", true);
    $("#status_value").val($("#user_status").is(":checked") ? "1" : "0")
    var formData = new FormData($('#UserStoreForm')[0]);


    $.ajax({
        type: "POST",
        url: "{{ route('AdminStore') }}",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
            alertmsg(res.message, "success");
            DataTable.ajax.reload();
            $("#btnSubmit").prop("disabled", false);
            $("#UserStoreModal").modal('hide');
            $('#UserStoreForm')[0].reset();
            } else if (res.validate) {
                alertmsg(res.message, "warning")
            } else {
                alertmsg(res.message, "danger")
            }
        }
    });
}

function UserEdit(user_id) {
            $.get("{{ route('AdminEdit') }}", {
                user_id: user_id

            }, function(data) {
                $("#user_id").val(data.data[0]['user_id']);
                $("#user_first_name").val(data.data[0]['user_first_name']);
                $("#user_last_name").val(data.data[0]['user_last_name']);
                $("#user_email").val(data.data[0]['user_email']);
                $("#user_password").val(data.data[0]['user_password']);
                $("#user_phone").val(data.data[0]['user_phone']);
                $("#user_type").val(data.data[0]['user_type']);
                $("#group_id").val(data.data[0]['group_id']);
                $("#user_status").val(data.data[0]['user_status']);
            });
        }

        function UserRemove(user_id)
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
                                        $.get("{{ route('AdminDelete') }}", {
                                            user_id: user_id
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
