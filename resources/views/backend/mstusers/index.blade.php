
@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <form method="POST" id="search-form" class="form-horizontal">
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.common.search')}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body bg-from">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.email')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="inputEmail3" placeholder="Nhập địa chỉ email">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.name')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.gender')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="gender">
                                    <option value=""></option>
                                    @foreach($dataDefault['MstGender'] as $k => $val)
                                        <option value="{{$k}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.position')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control select-mst-position select2" style="width:100%" name="mst_position">
                                    @foreach($dataDefault['MstPosition'] as $k => $val)
                                        <option value="{{$k}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.title')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control select-mst-title select2" style="width:100%" name="mst_title">
                                    @foreach($dataDefault['MstTitle'] as $k => $val)
                                        <option value="{{$k}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.active')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="active">
                                    <option value=""></option>
                                    @foreach($dataDefault['MstActive'] as $k => $val)
                                        <option value="{{$k}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.unit')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_unit">
                                    @foreach($dataDefault['MstUnit'] as $k => $val)
                                        <option value="{{$k}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer bg-from">
                <button type="submit" class="btn bg-orange margin pull-right"><i class="fa fa-search"></i>{{trans('labels.backend.common.search')}}</button>
            </div>
              <!-- /.box-body -->
          </div>
          </form>
          <!-- /.box -->
            <!-- /.box-body -->
          <!-- /.box -->
        </div>
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('labels.backend.users.list')}}</h3>
            </div>
            <div class="box-body">
                <a href="javascript::void()" data-url="{{route('mst_users.delete',['id'=>''])}}" class="btn btn-danger pull-right btn-click-delete-user"><i class="fa fa-remove"></i>{{trans('labels.backend.common.delete')}}</a>
                <a href="{{route('mst_users.add')}}" class="btn btn-info pull-right" style="margin-right: 10px;"><i class="fa fa-user-plus"></i>{{trans('labels.backend.common.add')}}</a>
                </br>
                <table class="table table-bordered table-striped dataTable" id="users-table" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th >{{trans('labels.backend.users.form.code')}}</th>
                            <th >{{trans('labels.backend.users.form.name')}}</th>
                            <th >{{trans('labels.backend.users.form.email')}}</th>
                            <th >{{trans('labels.backend.users.form.date_of_birth')}}</th>
                            <th >{{trans('labels.backend.users.form.gender')}}</th> 
                            <th >{{trans('labels.backend.users.form.role')}}</th>
                            <th >{{trans('labels.backend.users.form.position')}}</th>
                            <th >{{trans('labels.backend.users.form.title')}}</th>
                            <th>{{trans('labels.backend.users.form.active')}}</th>
                            
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
            <!-- /.box-body -->
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
<script>
$(document).ready(function(){
    var oTable = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        scrollX: true,
        scrollCollapse: true,
        language: {
            "processing": "Đang tải...",
            "lengthMenu":   "Hiển thị _MENU_ bản ghi",
            "info":        "Hiển thị từ _START_ đến _END_ trong  _TOTAL_ bản ghi",
            "paginate": {
                "first":      "Trang Đầu",
                "last":       "Trang Cuối",
                "next":       "Trang Tiếp",
                "previous":   "Trang Sau"
            },
            "zeroRecords":    "Không có bản ghi nào",
            "infoEmpty":      "",
            "infoFiltered":   "",
        },
        ajax: {
            url: '{!! route('mst_users.get_data_user') !!}',
            data: function (d) {
                d.name = $('input[name=name]').val();
                d.email = $('input[name=email]').val();
                d.gender = $('select[name=gender]').val();
                d.mst_position = $('select[name=mst_position]').val();
                d.mst_title = $('select[name=mst_title]').val();
                d.active = $('select[name=active]').val();
                d.id_unit = $('select[name=id_unit]').val();
            }
        },
        columns: [
            {data: 'checkbox',name:'',ordertable: false},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'date_of_birth', name: 'date_of_birth'},
            {data: 'gender', name: 'gender'},
            {data: 'role', name: 'role'},
            {data: 'pst_name', name: 'pst_name'},
            {data: 'ttl_name', name: 'ttl_name'},
            {data: 'active', name: 'active'},
            //{data: 'created_at', name: 'created_at'},
            {data: 'action', name: '',orderable: false},
        ],
        columnDefs: [{
            targets: [0,1,2,3,4,5,6,7,8,9,10],
            className: 'dt-body-nowrap'
        }]
    });
    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('#users-table tbody').on('click', '.btn-click-deactive', function () {
        $('.modal-confirm .modal-title').html('{!! trans('labels.backend.common.deactive') !!}');
        $('.modal-confirm .modal-body p').html('{!! trans('labels.backend.common.msg_deactive') !!}');
        $('.btn-click-delete').html('{!! trans('labels.backend.common.yes') !!}');
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    $('#users-table tbody').on('click', '.btn-click-active', function () {
        $('.modal-confirm .modal-title').html('{!! trans('labels.backend.common.active') !!}');
        $('.modal-confirm .modal-body p').html('{!! trans('labels.backend.common.msg_active') !!}');
        $('.btn-click-delete').html('{!! trans('labels.backend.common.yes') !!}');
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    var arrCheck = [];
    $('#users-table tbody').on('click', '.btn-click-checkbox', function () {
        if ($(this).is(":checked")) {
            arrCheck.push($(this).val());
        } else {
            arrCheck.splice( $.inArray($(this).val(), arrCheck), 1);
        }
    });
    $('.btn-click-delete-user').click(function(){
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url')+arrCheck.join(','));
    });
    $('#users-table tbody').on('click', '.btn-click-reset', function () {
        $('.modal-confirm .modal-title').html('{!! trans('labels.backend.common.reset_pass') !!}');
        $('.modal-confirm .modal-body p').html('{!! trans('labels.backend.common.msg_reset_pass') !!}');
        $('.btn-click-delete').html('{!! trans('labels.backend.common.yes') !!}');
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
});
</script>
@stop
