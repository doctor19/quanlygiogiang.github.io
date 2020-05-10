@extends('backend.layouts.app')
@section('content')
@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        @if($error == 'Vui lòng chọn học kì')
            <script>
                $(document).ready(function(){
                    $('.tem_semester_id').select2({ containerCssClass : "is-invalid" , placeholder: "Vui lòng chọn"});
                });
            </script>
        @endif
    @endforeach
@endif
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.mst_term.list')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                @if(Auth::user()->role == 1)
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom: 15px;">
                            <button class="btn btn-primary pull-right btn-click-add" data-toggle="modal" data-target="#modal-unit">{{trans('labels.backend.mst_term.add')}}</button>
                        </div>
                    </div>
                @endif
                <table class="table table-bordered table-striped dataTable" id="term-table" style="width:100%">
                  <thead>
                        <tr>
                            <!-- <th>{{trans('labels.backend.mst_mission.form.semester')}}</th> -->
                            <th>{{trans('labels.backend.mst_term.form.term_code')}}</th>
                            <th>{{trans('labels.backend.mst_term.form.term_name')}}</th>
                            <th>{{trans('labels.backend.mst_term.form.credit')}}</th>
                            <th>{{trans('labels.backend.mst_term.form.standard_time')}}</th>
                            <th>{{trans('labels.backend.mst_term.form.theoretical_details')}}</th>
                            <th>{{trans('labels.backend.mst_term.form.practice')}}</th>
                            <th>{{trans('labels.backend.mst_term.form.discuss')}}</th>
                            @if(Auth::user()->role == 1) <th></th> @endif
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
                  <h4 class="modal-title">@if(request()->session()->get('screen') == 'edit') {{trans('labels.backend.mst_term.edit')}} @else {{trans('labels.backend.mst_term.add')}} @endif</h4>
              </div>
              <form method="post" @if(request()->session()->get('screen') == 'edit') action="{{route('mst_term.update',['id' => request()->session()->get('id')])}}" @else action="{{route('mst_term.create')}}" @endif>
              {{ csrf_field() }}
              <div class="modal-body">
              @include('includes.error')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_term.form.term_code')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('tem_code') is-invalid @enderror" value="{{ old('tem_code') }}" name="tem_code" placeholder="Nhập mã học phần">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_term.form.term_name')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('tem_name') is-invalid @enderror" value="{{ old('tem_name') }}" name="tem_name" placeholder="Nhập tên học phần">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_term.form.credit')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('tem_credit') is-invalid @enderror" value="{{ old('tem_credit') }}" name="tem_credit" placeholder="Nhập số tín chỉ">
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_term.form.theoretical_details')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('tem_count_theoretical_details') is-invalid @enderror" value="{{ old('tem_count_theoretical_details') }}" name="tem_count_theoretical_details" placeholder="Nhập số tiết lý thuyết">
                            </div>
                        </div>
                    </div>
                </div>

                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_term.form.practice')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('tem_count_practice') is-invalid @enderror" value="{{ old('tem_count_practice') }}" name="tem_count_practice" placeholder="Nhập số tiết thực hành">
                            </div>
                        </div>
                    </div>
                </div>

                </br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_term.form.discuss')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('tem_count_discuss') is-invalid @enderror" value="{{ old('tem_count_discuss') }}" name="tem_count_discuss" placeholder="Nhập số tiết thảo luận">
                            </div>
                        </div>
                    </div>
                </div>
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
        $('#modal-unit').modal({
          show: true
        });
    });
  </script>
@endif
    <script>
$(document).ready(function(){
    var oTable = $('#term-table').DataTable({
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
            url: '{!! route('mst_term.get_data_term') !!}'
        },
        columns: [
            // {data: 'smt_name', name: 'mst_semester.smt_name',class : 'smt_name'},
            {data: 'tem_code', name: 'mst_term.tem_code',class : 'tem_code'},
            {data: 'tem_name', name: 'mst_term.tem_name',class : 'tem_name'},
            {data: 'tem_credit', name: 'mst_term.tem_credit',class : 'tem_credit'},
            {data: 'tem_standard_time', name: 'mst_term.tem_standard_time',class : 'tem_standard_time'},
            {data: 'tem_count_theoretical_details', name: 'mst_term.tem_count_theoretical_details',class : 'tem_count_theoretical_details'},
            {data: 'tem_count_practice', name: 'mst_term.tem_count_practice',class : 'tem_count_practice'},
            {data: 'tem_count_discuss', name: 'mst_term.tem_count_discuss',class : 'tem_count_discuss'},
            <?php if(Auth::user()->role == 1){ ?> {data: 'action', name: '',orderable: false}, <?php } ?>
        ]
    });
    $('.btn-close-modal').click(function(){
        $('.callout').remove();
        $(".tem_semester_id").val(null).trigger("change");
        $('.select2-selection--single').removeClass('is-invalid');
        $('input[name=tem_code],input[name=tem_name],input[name=tem_credit],input[name=tem_count_theoretical_details],input[name=tem_count_practice],input[name=tem_count_discuss]').val('').removeClass('is-invalid');
    });
    $('#term-table tbody').on('click', '.btn-edit-term', function () {
        $('.callout').remove();
        $(".tem_semester_id").val(null).trigger("change");
        $('.select2-selection--single').removeClass('is-invalid');
        $('input[name=tem_code],input[name=tem_name],input[name=tem_credit],input[name=tem_count_theoretical_details],input[name=tem_count_practice],input[name=tem_count_discuss]').val('').removeClass('is-invalid');
        var url = $(this).attr("data-url");
        $('.modal-title').html('{!! trans('labels.backend.mst_term.edit') !!}');
        $('#modal-unit').modal({
          show: true
        }).find('form').attr('action',url);
        var smt_name = $(this).parent().parent().find('.smt_name').html();

        $(".tem_semester_id").select2("val", $(".tem_semester_id option:contains("+smt_name+")").val());

        $('input[name=tem_code]').val($(this).parent().parent().find('.tem_code').html());
        $('input[name=tem_name]').val($(this).parent().parent().find('.tem_name').html());
        $('input[name=tem_credit]').val($(this).parent().parent().find('.tem_credit').html());
        $('input[name=tem_count_theoretical_details]').val($(this).parent().parent().find('.tem_count_theoretical_details').html());
        $('input[name=tem_count_practice]').val($(this).parent().parent().find('.tem_count_practice').html());
        $('input[name=tem_count_discuss]').val($(this).parent().parent().find('.tem_count_discuss').html());
    });
    $('#term-table tbody').on('click', '.btn-delete-term', function () {
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url'))
    });
    $('.btn-click-add').click(function(){
        $('.callout').remove();
        $('.modal-title').html('{{trans('labels.backend.mst_term.add')}}');
        $(".tem_semester_id").val(null).trigger("change");
        $('.select2-selection--single').removeClass('is-invalid');
        $('input[name=tem_code],input[name=tem_name],input[name=tem_credit],input[name=tem_count_theoretical_details],input[name=tem_count_practice],input[name=tem_count_discuss]').val('').removeClass('is-invalid');
        $('form').attr('action','{{route('mst_term.create')}}');
    });
    // $('.select-mst-title,.select-mst-position').select2();
});
</script>
@stop
