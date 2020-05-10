
@extends('backend.layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <form method="POST" id="search-form" class="form-horizontal">
          <div class="box" style="border-top:0px;">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body bg-from">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">{{trans('labels.backend.mst_mission.form.semester_name')}}</label>
                            <div class="col-sm-7">
                                <select class="form-control msn_id_semester select2" style="width: 100%;height:100%"  name="msn_id_semester">
                                    @foreach($dataDefault['MstSemester'] as $k => $val)
                                        @if($val != '')
                                            <option value="{{$k}}" >{{$val}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn bg-orange btn-submit-search"><i class="fa fa-search"></i>{{trans('labels.backend.common.search')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
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
          <div class="box box-primary box-solid mst-mission">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('labels.backend.mst_mission.list')}}</h3>
            </div>
            <div class="box-body">
                <a href="javacript::void(0)" data-url="{{route('mst_mission.delete',['id'=>''])}}" class="btn btn-danger pull-right btn-click-delete-mission"><i class="fa fa-remove"></i>{{trans('labels.backend.common.delete')}}</a>
                <a href="{{route('mst_mission.add')}}" class="btn btn-info pull-right" style="margin-right: 10px;"><i class="fa fa-user-plus"></i>{{trans('labels.backend.common.add')}}</a>
                </br>
                <table class="table table-bordered table-striped dataTable" id="mission-table" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{trans('labels.backend.mst_mission.form.stt')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.batch')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.term')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.count_periods')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.class')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.count_student')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.msn_cls_coefficient')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.count_periods_in_calculated')}}</th>
                            <th>{{trans('labels.backend.mst_mission.form.des')}}</th>
                            <th></th>
                            <!-- <th>{{trans('labels.backend.mst_mission.form.all_total')}}</th> -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="9" style="text-align:right">{{trans('labels.backend.mst_mission.form.all_total')}} :</th>
                            <th></th>
                        </tr>
                    </tfoot>
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
    var oTable = $('#mission-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        scrollX: true,
        scroller: true,
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
            url: '{!! route('mst_mission.get_data_mission') !!}',
            data: function (d) {
                d.msn_id_semester = $('select[name=msn_id_semester]').val();
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox',orderable: false},
            {data: 'rownum', name: 'rownum',orderable: false},
            {data: 'msn_batch', name: 'msn_batch'},
            {data: 'tem_name', name: 'tem_name'},
            {data: 'tem_standard_time', name: 'tem_standard_time'},
            {data: 'msn_cls_name', name: 'msn_cls_name'},
            {data: 'msn_cls_count_student', name: 'msn_cls_count_student'},
            {data: 'msn_cls_coefficient', name: 'msn_cls_coefficient'},
            {data: 'count_periods_in_calculated', name: 'count_periods_in_calculated',orderable: false},
            {data: 'msn_describe', name: 'msn_describe'},
            {data: 'action', name: '',orderable: false},
            // {data: 'action', name: '',orderable: false},
        ],
        //  "rowsGroup": [9],
        // // "aoColumnDefs": [
        // //    {
        // //         "aTargets": [9],
        // //         "mData": null,
        // //         "mRender": function (data, type, full) {
        // //             return '<span clss="span_count">Edit</span>';
        // //         }
        // //     }
        // // ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // // Remove the formatting to get integer data for summation
            // var intVal = function ( i ) {
            //     return typeof i === 'string' ?
            //         i.replace(/[\$,]/g, '')*1 :
            //         typeof i === 'number' ?
            //             i : 0;
            // };
            // Total over all pages
            total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
            }, 0 );
            // Total over this page
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return (parseFloat(a) + parseFloat(b)).toFixed(2);
                }, 0 );
            // Update footer
            $('.span_count').html(total);
            $( api.column(9).footer() ).html(
                pageTotal + ' {!! trans('labels.backend.common.house') !!}'
            );
        }
    });
    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    // $('.select-mst-title,.select-mst-position').select2();
    var arrCheck = [];
    $('#mission-table tbody').on('click', '.btn-click-checkbox', function () {
        if ($(this).is(":checked")) {
            arrCheck.push($(this).val());
        } else {
            arrCheck.splice( $.inArray($(this).val(), arrCheck), 1);
        }
        console.log(arrCheck);
    });
    $('.btn-click-delete-mission').click(function(){
        $('.modal-confirm').modal({
          show: true
        });
        $('.btn-click-delete').attr('href',$(this).attr('data-url')+arrCheck.join(','));
    });
    var MstSemester = $('.msn_id_semester').select2('data');
    $('.box-title').html($('.box-title').html() + MstSemester[0].text);
    $('.btn-submit-search').click(function(){
        $('.box-title').html('');
        var MstSemester = $('.msn_id_semester').select2('data');
        $('.box-title').html('{!! trans('labels.backend.mst_mission.list') !!}' + MstSemester[0].text);
    });
});
</script>
@stop
