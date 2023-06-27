@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Team Member</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#MemberStoreModal" id="AddBtn">Create New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="MemberStoreModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Team Member</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="teamMemberStoreForm">
                        @csrf
                        <input type="text" style="display: none" id="team_member_id" name="team_member_id">
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
                        <div class="form-group">
                            <label>Designation</label>
                            <select name="designation_id" id="designation_id" class="form-control form-control-user">
                                <option selected disabled>Select Group</option>
                                @foreach ($designation as $item)
                                <option value="{{ $item->designation_id}}">{{ $item->designation_name}}</option>
                                @endforeach
                                {{-- <option value="test">test</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="team_member_name" id="team_member_name" class="form-control form-control-user">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" name="team_member_email" id="team_member_email" class="form-control form-control-user">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="team_member_phone" id="team_member_phone" class="form-control form-control-user">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" id="address" class="form-control form-control-user">
                        </div>
                        <div class="form-group mb-3">
                            <label>Image</label>
                            <input type="file" accept="image/*" class="form-control" name="team_member_image"
                                id="team_member_image">
                            <div class="mt-3" id="image_preview">
                            </div>
                        </div>
                        <div class="formgroup">
                            <label>Status</label>
                            <input type="hidden" name="team_member_status" id="status_value">
                            <input type="checkbox" id="team_member_status" {{$data[0]->team_member_status ?? 1 ? "" : "checked"}}>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <span id="error" style="display: none;" class="m-auto"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit" onclick="MemberStore()" class="btn btn-primary">Submit</button>
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
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Phone</th>
                            <th>Designation</th>
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
        url: "{{ route('TeamMemberShow') }}",
        dataSrc: '',
    },
        columns: [{
            data: 'team_member_id',
        },{
            data: 'team_member_image', render: (img)=>{return `<img class ="datable-img" width="100px" height="100px" src="{{url('public/TeamMember')}}/${img}">`}
        },{
            data: 'team_member_name',
        },{
            data: 'team_member_email',
        },{
            data: 'team_member_phone',
        },{
            data: 'designation_name',
        },{
            data: 'team_member_status',
            render: (team_member_status) => {
                    return `${team_member_status == 0 ? "<p class='btn btn-danger'>Deactivate</p>" : "<p class='btn btn-success'>Active</p>"}`;
                }
        }, {
            data: 'created_date',
        }, {
            data: 'team_member_id',
            render: (team_member_id) => {
                    return `<button class="btn btn-primary mx-1" data-toggle="modal" data-target="#MemberStoreModal" onclick="MemberEdit('${team_member_id}')" ><i class="fa fa-edit"></i></button><button class="btn btn-danger mx-1" onclick="MemberRemove('${team_member_id}')"><i class="fa fa-trash"></i></button>`;
                }
        }
    ]
    });
    $('#designation_description').summernote({
                tabDisable: true,
                height: 200,
            });
}

function MemberStore(){
    $("#btnSubmit").prop("disabled", true);
    $("#status_value").val($("#team_member_status").is(":checked") ? "1" : "0")
    var formData = new FormData($('#teamMemberStoreForm')[0]);


    $.ajax({
        type: "POST",
        url: "{{ route('TeamMemberStore') }}",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
            alertmsg(res.message, "success");
            DataTable.ajax.reload();
            $("#MemberStoreModal").modal('hide');
            $('#teamMemberStoreForm')[0].reset();
            } else if (res.validate) {
                alertmsg(res.message, "warning")
            } else {
                alertmsg(res.message, "danger")
            }
        }
    });
    $("#btnSubmit").prop("disabled", false);

}

function MemberEdit(team_member_id){
        $.get("{{ route('TeamMemberEdit')}}",{
            team_member_id: team_member_id
        }, function(data){
            $("#team_member_id").val(data.data[0]['team_member_id']);
            $("#categories_id").val(data.data[0]['categories_id']);
            $("#designation_id").val(data.data[0]['designation_id']);
            $("#team_member_name").val(data.data[0]['team_member_name']);
            $("#team_member_email").val(data.data[0]['team_member_email']);
            $("#team_member_phone").val(data.data[0]['team_member_phone']);
            $("#address").val(data.data[0]['address']);
            $("#team_member_image").val(data.data[0]['team_member_image']);
            $("#team_member_status").val(data.data[0]['team_member_status']);
        });
}

function MemberRemove(team_member_id)
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
                                        $.get("{{ route('TeamMemberDelete') }}", {
                                            team_member_id: team_member_id
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
