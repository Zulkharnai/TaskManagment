@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Productivities</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#productStoreModal" id="AddBtn">Create New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="productStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Productivities</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="ProductStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="product_id" name="product_id">
                        <div class="form-group">
                            <label>Project</label>
                            <select name="project_id" id="project_id" class="form-control form-control-user">
                                <option selected disabled>Select Project Manager</option>
                            @foreach ($project as $item)
                            <option value="{{ $item->project_id}}">{{$item->project_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Task</label>
                            <select name="task_id" id="task_id" class="form-control form-control-user">
                                <option selected disabled>Select Task</option>
                            @foreach ($task as $item)
                            <option value="{{ $item->task_id}}">{{$item->task_description}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="product_subject" id="product_subject" class="form-control form-control-user">
                        </div>
                        <div class="from-group">
                            <label>From Date</label><br>
                            <input type="date" name="product_from_date" id="product_from_date" class="form-control form-control-user">
                        </div><br>
                        <div class="from-group">
                            <label>To Date</label><br>
                            <input type="date" name="product_to_date" id="product_to_date" class="form-control form-control-user">
                        </div><br>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="product_status" id="product_status" class="form-control form-control-user">
                                <option selected disabled>Select Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Complete</option>
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Product Description</label>
                            <textarea type="text" class="form-control" required name="product_description" id="product_description"
                                rows="10"></textarea>
                        </div>

                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="ProductStore()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="DataTable" class="table table-bordered" width="100%" cellspacing="0" style="text-align: center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Project</th>
                            <th>Subject</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    $(function () {
        Getdata();
    })

    var DataTable = '';

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
        url: "{{ route('ProductivitiesShow') }}",
        dataSrc: '',
    },
        columns: [{
            data: 'product_id',
        },{
            data: 'project_name',
        },{
            data: 'product_subject',
        },{
            data: 'product_from_date',
        },{
            data: 'product_status',
            render: (product_status) => {
                    return `${product_status == 0 ? "<p class='btn btn-danger'>Pending</p>" : "<p class='btn btn-success'>Completed</p>"}`;
                }
        },{
            data: 'product_id',
            render: (product_id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#productStoreModal" onclick="ProductEdit('${product_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="ProductRemove('${product_id}')"><i class="fa fa-trash"></i></button>`;
                }
        }
    ]
    });
    $('#product_description').summernote({
                tabDisable: true,
                height: 200,
            });
}

function ProductStore(){
    $("#btnSubmit").prop("disabled", true);

    $.post("{{ route('ProductivitiesStore') }}", $('#ProductStoreForm').serialize())
    .done((res) => {
        $("#btnSubmit").prop("disabled", false);
        if (res.success) {
        alertmsg(res.message, "success");
        DataTable.ajax.reload();
        $("#productStoreModal").modal('hide');
        $('#ProductStoreForm')[0].reset();
        $('#task_description').summernote('code', '');
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

function ProductEdit(product_id){
        $.get("{{ route('ProductivitiesEdit')}}",{
            product_id: product_id
        }, function(data){
            $("#product_id").val(data.data[0]['product_id']);
            $("#project_id").val(data.data[0]['project_id']);
            $("#task_id").val(data.data[0]['task_id']);
            $("#product_subject").val(data.data[0]['product_subject']);
            $("#product_from_date").val(data.data[0]['product_from_date']);
            $("#product_to_date").val(data.data[0]['product_to_date']);
            $("#product_status").val(data.data[0]['product_status']);
            $('#product_description').summernote('code', data.data[0]['product_description']);
        });
}

function ProductRemove(product_id)
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
                                        $.get("{{ route('ProductivitiesDelete') }}", {
                                            product_id: product_id
                                        }, function(res) {
                                            if (res['success']) {
                                                swal({
                                                    title: "Successful...",
                                                    text: res.message,
                                                    icon: "success"
                                                })
                                                DataTable.ajax.reload();
                                            }
                                        });
                                    }
                                });
                }
</script>

@endsection
