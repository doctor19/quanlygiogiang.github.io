@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.mst_position.list')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12" style="margin-bottom: 15px;">
                    <button type="button" class="btn btn-primary pull-right btn-click-add" data-toggle="modal" data-target="#modal-unit">
                      {{trans('labels.backend.mst_position.add')}}
                    </button>
                  </div>
                </div>
                <table class="table table-bordered table-striped dataTable" id="position-table" style="width:100%">
                  <thead>
                      <tr>
                            <th>{{trans('labels.backend.mst_position.form.name')}}</th>
                            <th>{{trans('labels.backend.mst_position.form.coefficient')}}</th>
                          <th></th>
                      </tr>
                  </thead>
                </table>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
              </form>
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
                  <h4 class="modal-title">@if(request()->session()->get('screen') == 'edit') {{trans('labels.backend.mst_position.edit')}} @else {{trans('labels.backend.mst_position.add')}} @endif</h4>
              </div>
              <form method="post" @if(request()->session()->get('screen') == 'edit') action="{{route('mst_position.update',['id' => request()->session()->get('id')])}}" @else action="{{route('mst_position.create')}}" @endif>
                {{ csrf_field() }}
                <div class="modal-body">
                  @include('includes.error')
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-3 control-label">{{trans('labels.backend.mst_position.form.name')}}</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control @error('pst_name') is-invalid @enderror" name="pst_name" value="{{ old('pst_name') }}" id="inputEmail3" placeholder="Nhập tên chức vụ">
                              </div>
                          </div>
                      </div>
                  </div>
                  </br>
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label for="inputEmail3" class="col-sm-3 control-label">{{trans('labels.backend.mst_position.form.coefficient')}}</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control @error('pst_coefficient') is-invalid @enderror" name="pst_coefficient" value="{{ old('pst_coefficient') }}" id="inputEmail3" placeholder="Hệ số">
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left btn-close-modal" data-dismiss="modal">{{trans('labels.backend.common.close')}}</button>
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
    var oTable = $('#position-table').DataTable({
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
            url: '{!! route('mst_position.get_data_position') !!}'
        },
        columns: [
            {data: 'pst_name', name: 'pst_name',class : 'pst_name'},
            {data: 'pst_coefficient', name: 'pst_coefficient',class : 'pst_coefficient'},
            {data: 'action', name: '',orderable: false},
        ]
    });
    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('.btn-close-modal').click(function(){
        $('.callout').remove();
        $('input[name=pst_name],input[name=pst_coefficient]').val('').removeClass('is-invalid');
    });
    $('#position-table tbody').on('click', '.btn-edit-position', function () {
        $('.callout').remove();
        $('input[name=pst_name],input[name=pst_coefficient]').val('').removeClass('is-invalid');
        var url = $(this).attr("data-url");
        $('.modal-title').html('{!! trans('labels.backend.mst_position.edit') !!}');
        $('#modal-unit').modal({
          show: true
        }).find('form').attr('action',url);
        $('input[name=pst_name]').val($(this).parent().parent().find('.pst_name').html());
        $('input[name=pst_coefficient]').val($(this).parent().parent().find('.pst_coefficient').html());
    });
    $('#position-table tbody').on('click', '.btn-delete-position', function () {
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    $('.btn-click-add').click(function(){
        $('.callout').remove();
        $('.modal-title').html('{{trans('labels.backend.mst_position.add')}}');
        $('input[name=pst_name],input[name=pst_coefficient]').val('').removeClass('is-invalid');
        $('form').attr('action','{{route('mst_position.create')}}');
    });
    // $('.select-mst-title,.select-mst-position').select2();
});
</script>
@stop
