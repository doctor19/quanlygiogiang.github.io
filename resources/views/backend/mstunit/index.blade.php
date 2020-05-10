@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.mst_unit.list')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12" style="margin-bottom: 15px;">
                    <button class="btn btn-primary pull-right btn-click-add" data-toggle="modal" data-target="#modal-unit">{{trans('labels.backend.mst_unit.add')}}</button>
                  </div>
                </div>
                <table class="table table-bordered table-striped dataTable" id="unit-table" style="width:100%">
                  <thead>
                      <tr>
                            <th>{{trans('labels.backend.mst_unit.form.name')}}</th>
                            <th>{{trans('labels.backend.mst_unit.form.created')}}</th>
                          <th></th>
                      </tr>
                  </thead>
                </table>
              </div>
              <!-- /.box-body -->
              <!-- /.box-footer -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      <!-- /.row -->
        <div class="modal fade" id="modal-unit">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header btn-primary">
                <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@if(request()->session()->get('screen') == 'edit') {{trans('labels.backend.mst_unit.edit')}} @else {{trans('labels.backend.mst_unit.add')}} @endif</h4>
              </div>
                <form method="post" @if(request()->session()->get('screen') == 'edit') action="{{route('mst_unit.update',['id' => request()->session()->get('id')])}}" @else action="{{route('mst_unit.create')}}" @endif>
                  {{ csrf_field() }}
                  <div class="modal-body">
                    @include('includes.error')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">{{trans('labels.backend.mst_unit.form.name')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('unt_name') is-invalid @enderror" name="unt_name" id="inputEmail3" placeholder="Nhập tên đơn vị" value="{{ old('unt_name') }}" maxlength = "150">
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-close-modal pull-left" data-dismiss="modal">{{trans('labels.backend.common.close')}}</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('labels.backend.common.save')}}</button>
                  </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
@if (count($errors) > 0)
  <script>
    $(document).ready(function(){
        $('#modal-unit').modal({
          show: true
        });
    });
  </script>
@endif
<script>
$(document).ready(function(){
    var oTable = $('#unit-table').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
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
            "search" : "Tìm kiếm",
        },
        ajax: {
            url: '{!! route('mst_unit.get_data_unit') !!}'
        },
        columns: [
            {data: 'unt_name', name: 'unt_name',class : 'unt_name'},
            {data: 'unt_created_at', name: 'unt_created_at'},
            {data: 'action', name: '',orderable: false},
        ]
    });
    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('.btn-close-modal').click(function(){
        $('.callout').remove();
        $('input[name=unt_name]').val('').removeClass('is-invalid');
    });
    $('#unit-table tbody').on('click', '.btn-edit-unit', function () {
        $('.callout').remove();
        $('input[name=unt_name]').val('').removeClass('is-invalid');
        var url = $(this).attr("data-url");
        $('.modal-title').html('{!! trans('labels.backend.mst_unit.edit') !!}');
        $('#modal-unit').modal({
          show: true
        }).find('form').attr('action',url);
        $('input[name=unt_name]').val($(this).parent().parent().find('.unt_name').html());
    });
    $('#unit-table tbody').on('click', '.btn-delete-unit', function () {
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    $('.btn-click-add').click(function(){
        $('.callout').remove();
        $('.modal-title').html('{{trans('labels.backend.mst_unit.add')}}');
        $('input[name=unt_name]').val('').removeClass('is-invalid');
        $('form').attr('action','{{route('mst_unit.create')}}');
    });
});
</script>
@stop
