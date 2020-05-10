@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.mst_title.list')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12" style="margin-bottom: 15px;">
                    <button class="btn btn-primary pull-right btn-click-add" data-toggle="modal" data-target="#modal-unit">{{trans('labels.backend.mst_title.add')}}</button>
                </div>
              </div>
              <table class="table table-bordered table-striped dataTable" id="title-table" style="width:100%">
                <thead>
                  <tr>
                      <th>{{trans('labels.backend.mst_title.form.name')}}</th>
                      <th>{{trans('labels.backend.mst_title.form.quota')}}</th>
                      <th>{{trans('labels.backend.mst_title.form.group_learn')}}</th>
                      <th></th>
                  </tr>
                </thead>
              </table>
            </div>
              <!-- /.box-body -->
              <!-- /.box-footer -->
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
                  <h4 class="modal-title">@if(request()->session()->get('screen') == 'edit') {{trans('labels.backend.mst_title.edit')}} @else {{trans('labels.backend.mst_title.add')}} @endif</h4>
              </div>
              <form method="post" @if(request()->session()->get('screen') == 'edit') action="{{route('mst_title.update',['id' => request()->session()->get('id')])}}" @else action="{{route('mst_title.create')}}" @endif>
              {{ csrf_field() }}
              <div class="modal-body">
              @include('includes.error')
              <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_title.form.name')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('ttl_name') is-invalid @enderror" value="{{ old('ttl_name') }}" name="ttl_name" id="inputEmail3" placeholder="Nhập tên chức danh">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_title.form.quota')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('ttl_quota') is-invalid @enderror" value="{{ old('ttl_quota') }}" name="ttl_quota" id="inputEmail3" placeholder="Nhập đinh mức">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_title.form.group_learn')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('ttl_group_learn') is-invalid @enderror" value="{{ old('ttl_group_learn') }}" name="ttl_group_learn" id="inputEmail3" placeholder="Nhập nhóm môn giảng dạy">
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-close-modal" data-dismiss="modal">Đóng</button>
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
    var oTable = $('#title-table').DataTable({
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
            url: '{!! route('mst_title.get_data_title') !!}'
        },
        columns: [
            {data: 'ttl_name', name: 'ttl_name',class : 'ttl_name'},
            {data: 'ttl_quota', name: 'ttl_quota',class : 'ttl_quota'},
            {data: 'ttl_group_learn', name: 'ttl_group_learn',class : 'ttl_group_learn'},
            {data: 'action', name: '',orderable: false},
        ]
    });
    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('.btn-close-modal').click(function(){
        $('.callout').remove();
        $('input[name=ttl_name],input[name=ttl_quota],input[name=ttl_group_learn]').val('').removeClass('is-invalid');
    });
    $('#title-table tbody').on('click', '.btn-edit-title', function () {
        $('.callout').remove();
        $('input[name=ttl_name],input[name=ttl_quota],input[name=ttl_group_learn]').val('').removeClass('is-invalid');
        var url = $(this).attr("data-url");
        $('.modal-title').html('{!! trans('labels.backend.mst_title.edit') !!}');
        $('#modal-unit').modal({
          show: true
        }).find('form').attr('action',url);
        $('input[name=ttl_name]').val($(this).parent().parent().find('.ttl_name').html());
        $('input[name=ttl_quota]').val($(this).parent().parent().find('.ttl_quota').html());
        $('input[name=ttl_group_learn]').val($(this).parent().parent().find('.ttl_group_learn').html());
    });
    $('#title-table tbody').on('click', '.btn-delete-title', function () {
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    $('.btn-click-add').click(function(){
        $('.callout').remove();
        $('.modal-title').html('{{trans('labels.backend.mst_title.add')}}');
        $('input[name=ttl_name],input[name=ttl_quota],input[name=ttl_group_learn]').val('').removeClass('is-invalid');
        $('form').attr('action','{{route('mst_title.create')}}');
    });
    // $('.select-mst-title,.select-mst-position').select2();
});
</script>
@stop
