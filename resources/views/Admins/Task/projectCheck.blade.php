@extends('layout')
@section('content')
<div class="row">
    @foreach ($project as $item)
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$item->project_name}}</h3>

                    <p>@if($item->project_status == 0)
                        <p class="btn btn-danger">Pending</p>
                    @elseif($item->project_status == 1)
                        <p class="btn btn-info">Preparing</p>
                    @elseif($item->project_status == 2)
                        <p class="btn btn-secondary">Processing</p>
                    @elseif($item->project_status == 3)
                        <p class="btn btn-success">Completed</p>
                    @else
                        Null
                    @endif</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('Task')}}?project_id={{$item->project_id}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
    @endforeach
</div>

  <script>
    function Task(project_id){
        $.get("{{ route('Task')}}",{
            project_id: project_id
        }, function(data){
            alert(data);
        });
}
  </script>
@endsection
