@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">        
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.mst_class.list')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12" style="margin-bottom: 15px;">
                    <button class="btn btn-primary pull-right btn-click-add" data-toggle="modal" data-target="#modal-class">{{trans('labels.backend.mst_class.add')}}</button>
                  </div>
                </div>
                <table class="table table-bordered table-striped dataTable" id="class-table" style="width:100%">
                  <thead>
                      <tr>
                            <th>{{trans('labels.backend.mst_class.form.name')}}</th>
                            <th>{{trans('labels.backend.mst_class.form.des')}}</th>
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
        <div class="modal fade" id="modal-class">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header btn-primary">
                <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">@if(request()->session()->get('screen') == 'edit') {{trans('labels.backend.mst_class.edit')}} @else {{trans('labels.backend.mst_class.add')}} @endif</h4>
              </div>
              <form method="post" @if(request()->session()->get('screen') == 'edit') action="{{route('mst_unit.update',['id' => request()->session()->get('id')])}}" @else action="{{route('mst_class.create')}}" @endif>
                  {{ csrf_field() }}
              <div class="modal-body">
              @include('includes.error')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_class.form.name')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('cls_name') is-invalid @enderror" value="{{ old('cls_name') }}" name="cls_name" id="inputEmail3" placeholder="Nhập tên lớp">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_class.form.des')}}</label>
                            <div class="col-sm-8">
                              <textarea class="form-controll @error('cls_describe') is-invalid @enderror" name="cls_describe" rows="4" cols="47">{{ old('cls_describe') }}</textarea>
                                <!-- <input type="text" class="form-control @error('cls_count_student') is-invalid @enderror" value="{{ old('cls_count_student') }}" name="cls_count_student" id="inputEmail3" placeholder="Nhập số sinh viên"> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_class.form.count_studen')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('cls_count_student') is-invalid @enderror" value="{{ old('cls_count_student') }}" name="cls_count_student" id="inputEmail3" placeholder="Nhập số sinh viên">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_class.form.coefficien')}}</label>
                            <div class="col-sm-8">
                                <span class="span_cls_coefficient">0</span>
                                <input type="hidden" class="form-control @error('cls_coefficient') is-invalid @enderror" value="{{ old('cls_coefficient',$valueDefault) }}" name="cls_coefficient" id="inputEmail3" placeholder="Nhập hệ số">
                            </div>
                        </div>
                    </div>
                </div> -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-close-modal" data-dismiss="modal">Đóng</button>
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
        $('#modal-class').modal({
          show: true
        });
        //$('.span_cls_coefficient').html($('input[name=cls_coefficient]').val());
    });
  </script>
@endif
    <script>
$(document).ready(function(){
    var oTable = $('#class-table').DataTable({
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
            url: '{!! route('mst_class.get_data_class') !!}'
        },
        columns: [
            {data: 'cls_name', name: 'cls_name',class : 'cls_name'},
            {data: 'cls_describe', name: 'cls_describe' , class: 'cls_describe'},
            {data: 'action', name: '',orderable: false},
        ]
    });
    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('.btn-close-modal').click(function(){
        $('.callout').remove();
        $('input[name=cls_name],textarea[name=cls_describe]').val('').removeClass('is-invalid');
    });
    $('#class-table tbody').on('click', '.btn-edit-class', function () {
        $('.callout').remove();
        $('input[name=cls_name],textarea[name=cls_describe]').val('').removeClass('is-invalid');
        var url = $(this).attr("data-url");
        $('.modal-title').html('{!! trans('labels.backend.mst_class.edit') !!}');
        $('#modal-class').modal({
          show: true
        }).find('form').attr('action',url);
        $('input[name=cls_name]').val($(this).parent().parent().find('.cls_name').html());
        $('textarea[name=cls_describe]').val($(this).parent().parent().find('.cls_describe').html());
    });
    $('.btn-click-add').click(function(){
        $('.callout').remove();
        $('.modal-title').html('{{trans('labels.backend.mst_class.add')}}');
        //$('.span_cls_coefficient').html(0);
        $('input[name=cls_name],textarea[name=cls_describe]').val('').removeClass('is-invalid');
        //$('input[name=cls_coefficient]').val(0);
        $('form').attr('action','{{route('mst_class.create')}}');
    });
    $('#class-table tbody').on('click', '.btn-delete-class', function () {
        $('.modal-confirm').modal({
          show: true
        });
        $('.modal-title').html('{{trans('labels.backend.common.delete')}}');
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    // $('input[name=cls_count_student]').keyup(function(){
    //    var countStudent = $(this).val();
    //    var result = '';
    //     if (countStudent != '' && countStudent > 0) {
    //       if (countStudent <= 50) {
    //         result = '1.0';
    //       }
    //       else if ( 50 < countStudent && countStudent <= 65) {
    //         result = '1.1';
    //       }
    //       else if ( 65 < countStudent && countStudent <= 80) {
    //         result = '1.2';
    //       }
    //       else if ( 80 < countStudent && countStudent <= 100) {
    //         result = '1.3';
    //       }
    //       else if ( 100 < countStudent && countStudent <= 120) {
    //         result = '1.4';
    //       }
    //       else if ( 120 < countStudent && countStudent <= 140) {
    //         result = '1.5';
    //       }
    //       else if ( 140 < countStudent && countStudent <= 160) {
    //         result = '1.6';
    //       }
    //       else if ( 160 < countStudent && countStudent <= 180) {
    //         result = '1.7';
    //       }
    //       else if(countStudent > 180 ) {
    //         result = '1.8';
    //       }
    //    } else {
    //       result = '0'
    //    }
    //    $('.span_cls_coefficient').html(result);
    //    $('input[name=cls_coefficient]').val(result);
    // });
    // $('.select-mst-title,.select-mst-position').select2();
});
</script>
@stop
