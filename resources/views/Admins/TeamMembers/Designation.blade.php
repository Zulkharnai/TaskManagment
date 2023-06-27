@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Designation</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#DesignationStoreModal" id="AddBtn">Create New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="DesignationStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Designation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="designationStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="designation_id" name="designation_id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="designation_name" id="designation_name" class="form-control form-control-user">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="categories_id" id="categories_id" class="form-control form-control-user">
                                <option selected disabled>Select Category</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->categories_id}}">{{ $item->categories_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Group Description</label>
                            <textarea type="text" class="form-control" required name="designation_description" id="designation_description"
                                rows="10"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="DesignationStore()" class="btn btn-primary">Submit</button>
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
                            <th>Desgination Name</th>
                            <th>Category</th>
                            <th>Desgination Descriptions</th>
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
            ['10 rows', '25 rows', '50 rows', 'show all']
        ],
        "responsive" : true,
        buttons: [
            'copy', 'csv', 'excel', 'print', 'pageLength', 'colvis'
        ],
        ajax: {
            url: "{{ route('DesignationShow') }}",
            dataSrc: '',
        },
        columns: [{
            data: 'designation_id',
        },{
            data: 'designation_name',
        },{
            data: 'categories_name',
        },{
            data: 'designation_description',
        }, {
            data: 'designation_id',
            render: (designation_id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#DesignationStoreModal" onclick="UserEdit('${designation_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="DesignationRemove('${designation_id}')"><i class="fa fa-trash"></i></button>`;
                }
        }
    ]
    });
}

// function Getdata() {
//     DataTable = $("#DataTable").DataTable({
//     dom: '<"top"<"left-col"B><"right-col"f>>r<"table table-striped"t>ip',
//     lengthMenu: [
//         [10, 25, 50, -1],
//         ['10 rows', '25 rows', '50 rows', 'Show all']
//     ],
//     "responsive": true,
//     buttons: ['pageLength'],
//     ajax: {
//         url: "{{ route('DesignationShow') }}",
//         dataSrc: '',
//     },
//         columns: [{
//             data: 'designation_id',
//         },{
//             data: 'designation_name',
//         },{
//             data: 'categories_name',
//         },{
//             data: 'designation_description',
//         }, {
//             data: 'designation_id',
//             render: (designation_id) => {
//                     return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#DesignationStoreModal" onclick="DesignationEdit('${designation_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="DesignationRemove('${designation_id}')"><i class="fa fa-trash"></i></button>`;
//                 }
//         }
//     ]
//     });
//     $('#designation_description').summernote({
//                 tabDisable: true,
//                 height: 200,
//             });
// }

function DesignationStore(){
    $("#btnSubmit").prop("disabled", true);

    $.post("{{ route('DesignationStore') }}", $('#designationStoreForm').serialize())
    .done((res) => {
        $("#btnSubmit").prop("disabled", false);
        if (res.success) {
        alertmsg(res.message, "success");
        DataTable.ajax.reload();
        $("#DesignationStoreModal").modal('hide');
        $('#designationStoreForm')[0].reset();
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

function DesignationEdit(designation_id){
        $.get("{{ route('DesignationEdit')}}",{
            designation_id: designation_id
        }, function(data){
            $("#designation_id").val(data.data[0]['designation_id']);
            $("#designation_name").val(data.data[0]['designation_name']);
            $("#categories_id").val(data.data[0]['categories_id']);
            $('#designation_description').summernote('code', data.data[0]['designation_description']);
        });
}

function DesignationRemove(designation_id)
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
                                        $.get("{{ route('DesignationDelete') }}", {
                                            designation_id: designation_id
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
