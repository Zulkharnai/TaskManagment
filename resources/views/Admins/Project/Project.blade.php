@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Project</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#ProjectStoreModal" id="AddBtn">Create New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ProjectStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Project</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="ProjectStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="project_id" name="project_id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="project_name" id="project_name" class="form-control form-control-user">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="categories_id" id="categories_id" class="form-control form-control-user">
                                <option selected disabled>Select Group</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->categories_id}}">{{ $item->categories_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Project Manager</label>
                            <select name="user_id" id="user_id" class="form-control form-control-user">
                                <option selected disabled>Select Project Manager</option>
                            @foreach ($user as $item)
                            <option value="{{ $item->user_id}}">{{ $item->user_first_name}} {{$item->user_last_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Team Member</label>
                            <select name="team_member_id" id="team_member_id" class="form-control form-control-user">
                                <option selected disabled>Select Project Manager</option>
                            @foreach ($team_member as $item)
                            <option value="{{ $item->team_member_id}}">{{$item->team_member_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="from-group">
                            <label>From Date</label><br>
                            <input type="date" name="project_from_date" id="project_from_date" class="form-control form-control-user">
                        </div><br>
                        <div class="from-group">
                            <label>To Date</label><br>
                            <input type="date" name="project_to_date" id="project_to_date" class="form-control form-control-user">
                        </div><br>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="project_status" id="project_status" class="form-control form-control-user">
                                <option selected disabled>Select Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Preparing</option>
                                <option value="2">Processing</option>
                                <option value="3">Completed</option>
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Project Description</label>
                            <textarea type="text" class="form-control" required name="project_description" id="project_description"
                                rows="10"></textarea>
                        </div>

                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="ProjectStore()" class="btn btn-primary">Submit</button>
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
                            <th>Name</th>
                            <th>Category</th>
                            <th>Duration</th>
                            <th>Project Manager</th>
                            <th>Status</th>
                            <th>Date</th>
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
        url: "{{ route('ProjectShow') }}",
        dataSrc: '',
    },
        columns: [{
            data: 'project_id',
        },{
            data: 'project_name',
        },{
            data: 'categories_name',
        },{
            data: 'project_from_date',
            data: 'project_to_date',
        },{
            data: 'user_last_name',
        },{
            data: 'project_status',
            render: (project_status) => {
                    return `${project_status == 0 ? "<p class='btn btn-danger'>Pending</p>" : project_status == 1 ? "<p class='btn btn-info'>Preparing</p>" : project_status == 2 ? "<p class='btn btn-secondary'>Processing</p>": project_status == 3 ? "<p class='btn btn-success'>Completed</p>" : "Null"}`;
                }
        },{
            data: 'created_date',
        }, {
            data: 'project_id',
            render: (project_id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#ProjectStoreModal" onclick="ProjectEdit('${project_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="ProjectRemove('${project_id}')"><i class="fa fa-trash"></i></button>`;
                }
        }
    ]
    });
    $('#project_description').summernote({
                tabDisable: true,
                height: 200,
            });
}

function ProjectStore(){
    $("#btnSubmit").prop("disabled", true);

    $.post("{{ route('ProjectStore') }}", $('#ProjectStoreForm').serialize())
    .done((res) => {
        $("#btnSubmit").prop("disabled", false);
        if (res.success) {
        alertmsg(res.message, "success");
        DataTable.ajax.reload();
        $("#ProjectStoreModal").modal('hide');
        $('#ProjectStoreForm')[0].reset();
        $('#project_description').summernote('code', '');
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

function ProjectEdit(project_id){
        $.get("{{ route('ProjectEdit')}}",{
            project_id: project_id
        }, function(data){
            $("#project_id").val(data.data[0]['project_id']);
            $("#project_name").val(data.data[0]['project_name']);
            $("#categories_id").val(data.data[0]['categories_id']);
            $("#user_id").val(data.data[0]['user_id']);
            $("#team_member_id").val(data.data[0]['team_member_id']);
            $("#project_from_date").val(data.data[0]['project_from_date']);
            $("#project_to_date").val(data.data[0]['project_to_date']);
            $("#project_status").val(data.data[0]['project_status']);
            $('#project_description').summernote('code', data.data[0]['project_description']);
        });
}

function ProjectRemove(project_id)
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
                                        $.get("{{ route('ProjectDelete') }}", {
                                            project_id: project_id
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
