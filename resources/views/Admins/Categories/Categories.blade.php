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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Category</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#CategoryStoreModal" id="AddBtn">Create New</button>
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
                            <th>Category Name</th>
                            <th>Category Note</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="CategoryStoreModal">
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
                        <input type="text" style="display: none" id="categories_id" name="categories_id">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control form-control-user required " name="categories_name"
                                id="categories_name" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label>Category Note</label>
                            <input type="text" class="form-control form-control-user required " name="categories_note"
                                id="categories_note" placeholder="Enter Last Name">
                        </div>

                        <div class="formgroup">
                            <label>Status</label>

                            <input type="checkbox" name="categories_status" id="categories_status" {{($data[0]->categories_status ?? 0 )== 1 ? "checked" : ""}}>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="CategoryStore()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {

        Getdata();

    });

    function CategoryStore() {

        $("#btnSubmit").prop("disabled", true);

        $.post("{{ route('CategoriesStore') }}", $('#UserStoreForm').serialize())
            .done((res) => {
                $("#btnSubmit").prop("disabled", false);
                if (res.success) {
                alertmsg(res.message, "success");
                DataTable.ajax.reload();
                $("#CategoryStoreModal").modal('hide');
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

    function Getdata() {

        var DataTable = $("#DataTable").DataTable({
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
            url: "{{ route('CategoriesShow') }}",
            dataSrc: '',
        },
        columns: [{
                data: 'categories_id',
            },
            {
                data: 'categories_name',
            },
            {
                data: 'categories_note',
            },
            {
                data: 'categories_status',
                render: (categories_status) => {
                    return `${categories_status == 0 ? "<p class='btn btn-danger'>Deactivate</p>" : "<p class='btn btn-success'>Active</p>"}`
                }
            },
            {
                data: 'created_date',
            },
            {
                data: 'categories_id',
                render: (categories_id) => {
                        return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#CategoryStoreModal" onclick="CategoryEdit('${categories_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="CategoryRemove('${categories_id}')"><i class="fa fa-trash"></i></button>`;
                    }
            }

        ]
        });
    }


    function CategoryEdit(categories_id){
        $.get("{{route('CategoriesEdit')}}", {
            categories_id: categories_id
        },function (data) {
            $("#categories_id").val(data.data[0]["categories_id"]);
            $("#categories_name").val(data.data[0]["categories_name"]);
            $("#categories_note").val(data.data[0]["categories_note"]);
            $("#categories_status").val(data.data[0]["categories_status"]);
        });
    }

    function CategoryRemove(categories_id)
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
                                        $.get("{{ route('CategoriesDelete') }}", {
                                            categories_id: categories_id
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
