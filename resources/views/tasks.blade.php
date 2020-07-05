@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Contact List</h3>
              </div>
              <table class="table table-bordered table-striped table-condensed">
                  <tr>
                      <td>NAME</td>
                      <td>PHONE</td>
                  </tr>

                  @foreach($tasks as $row)
                    <tr>
                        <td>
                          <a href="#" class="xedit" 
                             data-pk="{{$row->id}}"
                             data-name="name">
                             {{$row->name}}</a>
                        </td>

                         <td>
                          <a href="#" class="xedit" 
                             data-pk="{{$row->id}}"
                             data-name="phone">
                             {{$row->description}}</a>
                        </td>
                    </tr>
                  @endforeach

              </table>
          </div>

      </div>
  </div>

<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script> -->
      
  <script>
    $(document).ready(function () {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': '{{csrf_token()}}'
                  }
              });

              $('.xedit').editable({
                  url: '{{url("tasks/update")}}',
                  title: 'Update',
                  success: function (response, newValue) {
                      console.log('Updated', response)
                  }
              });

      })
  </script>
@endsection