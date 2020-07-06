@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card card-new-task">
                <div class="card-header">
                  New Task
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="form-group">
                            <input id="mainTableOn" name="mainTableOn" class="form-control text-right" type="checkbox" checked data-toggle="toggle" data-on="Create on Main Table" data-off="Create on Mirror Table" data-onstyle="success" data-offstyle="danger">
                            <span class="row"></span>                            
                            <label for="name">name</label>
                            <input id="name" name="name" type="text" maxlength="255" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                          <label for="description" > Description</label>
                          <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description" rows="3" col="4">                          
                          </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="text-right">
                  <input id="mainTableOnU" name="mainTableOnU" class="form-control pull-right" type="checkbox" checked data-toggle="toggle" data-on="Show from Main Table" data-off="Show from Mirror Table" data-onstyle="success" data-offstyle="danger">  
                </div>
                <div class="card-header">Tasks</div>
                
                
                <div class="card-body">
                   
                   <table class="table table-striped" id="mainTable">
                        
                       <tr>
                          <td>NAME</td>
                          <td>DESCRIPTION</td>
                          <td>DELETE</td>
                      </tr>
                       @foreach ($tasks as $task)
                           <tr>
                        <td>
                          <a href="#" class="xedit" 
                             data-pk="{{$task->id}}"
                             data-name="name">
                             {{$task->name}}</a>
                        </td>

                         <td>
                          <a href="#" class="xedit" 
                             data-pk="{{$task->id}}"
                             data-name="description">
                             {{$task->description}}</a>
                        </td>
                        <td id="deleteFromMain" data-id="{{$task->id}}" data-url="{{ route('task.destroy',$task->id) }}" data-from="0"><i class="fa fa-trash" aria-hidden="true"></i></td>

                           </tr>
                       @endforeach
                   </table>

                   <table class="table table-striped" style="display: none;" id="mirrorTable">
                      <tr>
                          <td>NAME</td>
                          <td>DESCRIPTION</td>
                          <td>DELETE</td>
                      </tr>
                       @foreach ($tasksMirror as $task)
                           <tr>
                        <td>
                          <a href="#" class="xeditM" 
                             data-pk="{{$task->id}}"
                             data-name="name">
                             {{$task->name}}</a>
                        </td>

                         <td>
                          <a href="#" class="xeditM" 
                             data-pk="{{$task->id}}"
                             data-name="description">
                             {{$task->description}}</a>
                        </td>
                        <td id="deleteFromMain" data-id="{{$task->id}}" data-url="{{ route('task.destroy',$task->id) }}" data-from="1"><i class="fa fa-trash" aria-hidden="true"></i></td>
                           </tr>
                       @endforeach
                   </table>

                </div>
            </div>
        </div>
    </div>
</div>
  
  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

  <script>
    $(document).ready(function () {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': '{{csrf_token()}}'
                  }
              });

              $('.xedit').editable({

                  url: "{{url('tasks/update')}}",
                  title: 'Update',
                  params: function(params) {
                          params.mirror = 0;       
                          return params;
                      },
                  success: function (response, newValue) {
                      location.reload();

                  }
              });
 
              $('.xeditM').editable({

                  url: "{{url('tasks/update')}}",
                  title: 'Update',
                  params: function(params) {
                          params.mirror = 1;       
                          return params;
                      },                  
                  success: function (response, newValue) {
                      location.reload();

                  }
              });
    
      })
  
             $('#mainTableOnU').change(function() {
              if ($(this).prop('checked')) {
                  $('#mirrorTable').hide();
                  $('#mainTable').show();
              } else {
                  $('#mirrorTable').show();
                  $('#mainTable').hide();
              }
            });

 $("body").on("click","#deleteFromMain",function(e){

    if(!confirm("Do you really want to do this?")) {
       return false;
     }

    e.preventDefault();
    var id = $(this).data("id");
    var url = $(this).data("url");
    var from = $(this).data("from");
    // alert(from);
    var token = $("meta[name='csrf-token']").attr("content");
   
    $.ajax(
        {
          url: url,
          type: 'DELETE',
          data: {
            _token: token,
                id: id,
                from:from
        },
        success: function (response){

            // alert(response);
            location.reload();
        }
     });
      return false;
   });


  </script>

@endsection