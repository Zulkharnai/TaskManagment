@extends('Employeelayout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Task</div>
                        </div>
                        {{-- <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#TaskStoreModal" id="AddBtn">Create New</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="TaskStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="TaskStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="task_id" name="task_id">
                        <div class="form-group">
                            <label>Name</label>
                            <select name="user_id" id="user_id" class="form-control form-control-user" disabled>
                                <option selected disabled>Select Employee</option>
                            @foreach ($user as $item)
                            <option value="{{ $item->user_id}}">{{ $item->user_first_name}} {{$item->user_last_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group">
                            <label>Project</label>
                            <select name="project_id" id="project_id" class="form-control form-control-user" disabled>
                                <option selected disabled>Select Project Manager</option>
                            @foreach ($project as $item)
                            <option value="{{ $item->project_id}}">{{$item->project_name}}</option>
                            @endforeach
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="from-group">
                            <label>From Date</label><br>
                            <input type="date" name="task_from_date" id="task_from_date" class="form-control form-control-user" >
                        </div><br>
                        <div class="from-group">
                            <label>To Date</label><br>
                            <input type="date" name="task_to_date" id="task_to_date" class="form-control form-control-user" >
                        </div><br>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="task_status" id="task_status" class="form-control form-control-user">
                                <option selected disabled>Select Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Complete</option>
                            {{-- <option value="test">test</option> --}}
                        </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Task Description</label>
                            <textarea type="text" class="form-control" required name="task_description" id="task_description"
                                rows="5" disabled></textarea>
                        </div>

                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="TaskStore()" class="btn btn-primary">Submit</button>
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
                            <th>Task</th>
                            <th>From Date</th>
                            <th>To Date</th>
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
    buttons: ['pageLength'],
    ajax: {
        url: "{{ route('PendingTaskShow') }}",
        dataSrc: '',
    },
        columns: [{
            data: 'task_id',
        },{
            data: 'project_name',
        },{
            data: 'task_description',
        },{
            data: 'task_from_date',
        },{
            data: 'task_to_date',
        },{

            data: 'task_status',
            render: (task_status) => {
                    return `${task_status == 0 ? "<p class='btn btn-danger'>Pending</p>" : "<p class='btn btn-success'>Completed</p>"}`;
                }
        },{
            data: 'task_id',
            render: (task_id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#TaskStoreModal" onclick="TaskEdit('${task_id}')" ><i class="fa fa-edit"></i></button>`;
                }
        }
    ]
    });
}

function TaskStore(){
    $("#btnSubmit").prop("disabled", true);

    $.post("{{ route('EmployeeTaskStore') }}", $('#TaskStoreForm').serialize())
    .done((res) => {
        $("#btnSubmit").prop("disabled", false);
        if (res.success) {
        alertmsg(res.message, "success");
        DataTable.ajax.reload();
        $("#TaskStoreModal").modal('hide');
        $('#TaskStoreForm')[0].reset();
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

function TaskEdit(task_id){
        $.get("{{ route('TaskEdit')}}",{
            task_id: task_id
        }, function(data){
            $("#task_id").val(data.data[0]['task_id']);
            $("#user_id").val(data.data[0]['user_id']);
            $("#project_id").val(data.data[0]['project_id']);
            $("#user_id").val(data.data[0]['user_id']);
            $("#task_from_date").val(data.data[0]['task_from_date']);
            $("#task_to_date").val(data.data[0]['task_to_date']);
            $("#task_status").val(data.data[0]['task_status']);
            $('#task_description').val(data.data[0]['task_description'])
        });
}

</script>

@endsection
