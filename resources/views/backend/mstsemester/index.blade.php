@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.mst_semester.list')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="row">
                    <div class="col-sm-12" style="margin-bottom: 15px;">
                      <button class="btn btn-primary pull-right btn-click-add" data-toggle="modal" data-target="#modal-semester">{{trans('labels.backend.mst_semester.add')}}</button>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable" id="semester-table" style="width:100%">
                  <thead>
                      <tr>
                            <th>{{trans('labels.backend.mst_semester.form.name')}}</th>
                            <th>{{trans('labels.backend.mst_semester.form.created_at')}}</th>
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
        <div class="modal fade" id="modal-semester">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header btn-primary">
                <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@if(request()->session()->get('screen') == 'edit') {{trans('labels.backend.mst_semester.edit')}} @else {{trans('labels.backend.mst_semester.add')}} @endif</h4>
              </div>
              <form method="post" @if(request()->session()->get('screen') == 'edit') action="{{route('mst_semester.update',['id' => request()->session()->get('id')])}}" @else action="{{route('mst_semester.create')}}" @endif>
              {{ csrf_field() }}
              <div class="modal-body">
              @include('includes.error')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_semester.form.name')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('smt_name') is-invalid @enderror" value="{{ old('smt_name') }}" name="smt_name" id="inputEmail3" placeholder="Nhập tên học kỳ">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_semester.form.school_year')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="inputEmail3" placeholder="Nhập năm học">
                            </div>
                        </div>
                    </div>
                </div>         -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-close-modal" data-dismiss="modal">{{trans('labels.backend.common.close')}}</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('labels.backend.common.save')}}</button>
              </div>
            </div>
            </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
@if (count($errors) > 0)
  <script>
    $(document).ready(function(){
        $('#modal-semester').modal({
          show: true
        });
    });
  </script>
@endif
    <script>
$(document).ready(function(){
    var oTable = $('#semester-table').DataTable({
        // processing: true,
        // serverSide: true,
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
            url: '{!! route('mst_semester.get_data_semester') !!}'
        },
        columns: [
            {data: 'smt_name', name: 'smt_name',class : 'smt_name'},
            {data: 'smt_created_at', name: 'smt_created_at',class : 'smt_created_at'},
            {data: 'action', name: '',orderable: false},
        ]
    });
    $('.btn-close-modal').click(function(){
        $('.callout').remove();
        $('input[name=smt_name]').val('').removeClass('is-invalid');
    });
    $('.btn-click-add').click(function(){
        $('.callout').remove();
        $('.modal-title').html('{{trans('labels.backend.mst_semester.add')}}');
        $('input[name=smt_name]').val('').removeClass('is-invalid');
        $('form').attr('action','{{route('mst_semester.create')}}');
    });
    $('#semester-table tbody').on('click', '.btn-edit-semester', function () {
        $('.callout').remove();
        $('input[name=smt_name]').val('').removeClass('is-invalid');
        var url = $(this).attr("data-url");
        $('#modal-semester .modal-title').html('{!! trans('labels.backend.mst_semester.edit') !!}');
        $('#modal-semester').modal({
          show: true
        }).find('form').attr('action',url);
        $('input[name=smt_name]').val($(this).parent().parent().find('.smt_name').html());
    });
    $('#semester-table tbody').on('click', '.btn-delete-semester', function () {
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    // $('.select-mst-title,.select-mst-position').select2();
});
</script>
@stop
