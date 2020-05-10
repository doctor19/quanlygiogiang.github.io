
@extends('backend.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
            @if(Auth::user()->role == 2) <h3 class="box-title">{{trans('labels.backend.common.statistical_of_year')}} {{$smtName}}</h3> @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                  @if(Auth::user()->role == 2)
                  <div class="col-sm-3">
                      <div class="info-box bg-green">
                            <div class="info-box-content" style="margin-left:0px">
                              <span class="info-box-text">{{trans('labels.backend.dashboard.count_teaching_norms')}}</span>
                              <span class="info-box-number">{{$countTeachingNorms}} {{trans('labels.backend.common.house')}}</span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                              </div>
                              <!-- <span class="progress-description">
                                20% Increase in 30 Days
                              </span> -->
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="info-box bg-yellow">
                        <div class="info-box-content" style="margin-left:0px">
                          <span class="info-box-text">{{trans('labels.backend.dashboard.count_actual_hours')}}</span>
                          <span class="info-box-number">{{$countActualHours}} {{trans('labels.backend.common.house')}}</span>
                          <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                          </div>
                          <!-- <span class="progress-description">
                            50% Increase in 30 Days
                          </span> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="info-box bg-aqua">
                        <div class="info-box-content" style="margin-left:0px">
                          <span class="info-box-text">{{trans('labels.backend.dashboard.count_overtime')}}</span>
                          <span class="info-box-number">@if($countActualHours - $countTeachingNorms > 0) {{$countActualHours - $countTeachingNorms}} @else 0 @endif {{trans('labels.backend.common.house')}}</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                          </div>
                          <span class="progress-description">
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="info-box bg-red">
                          <div class="info-box-content" style="margin-left:0px">
                            <span class="info-box-text">{{trans('labels.backend.dashboard.count_lack_of_hours')}}</span>
                            <span class="info-box-number">@if($countActualHours - $countTeachingNorms > 0) 0 {{trans('labels.backend.common.house')}} @else {{$countActualHours - $countTeachingNorms}} {{trans('labels.backend.common.house')}} @endif</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 50%"></div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="info-box bg-green">
                          <div class="info-box-content" style="margin-left:0px">
                            <span class="info-box-text">{{trans('labels.backend.mst_mission.count_misstion')}}</span>
                            <span class="info-box-number">{{$countMission}}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 50%"></div>
                            </div>
                          </div>
                      </div>
                    </div>
                  @else
                    <div class="col-sm-3">
                      <div class="info-box bg-yellow">
                        <!-- <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span> -->
                        <div class="info-box-content" style="margin-left:0px">
                          <span class="info-box-text">{{trans('labels.backend.dashboard.count_user')}}</span>
                          <span class="info-box-number">{{$countUsers}}</span>
                          <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                          </div>
                          <!-- <span class="progress-description">
                            50% Increase in 30 Days
                          </span> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="info-box bg-green">
                          <!-- <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span> -->
                            <div class="info-box-content" style="margin-left:0px">
                              <span class="info-box-text">{{trans('labels.backend.dashboard.count_term')}}</span>
                              <span class="info-box-number">{{$countMstTerm}}</span>

                              <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                              </div>
                              <!-- <span class="progress-description">
                                20% Increase in 30 Days
                              </span> -->
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="info-box bg-aqua">
                        <!-- <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span> -->
                        <div class="info-box-content" style="margin-left:0px">
                          <span class="info-box-text">{{trans('labels.backend.dashboard.count_class')}}</span>
                          <span class="info-box-number">{{$countMstClass}}</span>

                          <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                          </div>
                          <span class="progress-description">
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="info-box bg-red">
                          <!-- <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span> -->
                          <div class="info-box-content" style="margin-left:0px">
                            <span class="info-box-text">{{trans('labels.backend.dashboard.count_unit')}}</span>
                            <span class="info-box-number">{{$countMstUnit}}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 50%"></div>
                            </div>
                          </div>
                      </div>
                    </div>
                  @endif
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        @if(Auth::user()->role == 2)
        <div class="col-sm-12">
        <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.common.statistical_of_year')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                  <table class="table table-bordered text-align table-responsive table-striped">
                    <tbody>
                      <tr>
                        <th style="width: 10px" class="text-align">{{trans('labels.backend.mst_mission.form.stt')}}</th>
                        <th class="text-align">{{trans('labels.backend.mst_semester.form.school_year')}}</th>
                        <th class="text-align">{{trans('labels.backend.dashboard.count_teaching_norms')}}</th>
                        <th class="text-align">{{trans('labels.backend.dashboard.count_actual_hours')}}</th>
                        <th class="text-align">{{trans('labels.backend.dashboard.count_overtime')}}</th>
                        <th class="text-align">{{trans('labels.backend.dashboard.count_lack_of_hours')}}</th>
                        <th class="text-align">{{trans('labels.backend.mst_mission.count_misstion')}}</th>
                      </tr>
                      @if(!@empty($dataTable['arrDataTable']))
                        <?php $i = 1; ?>
                          @foreach(array_reverse($dataTable['arrDataTable']) as $key => $value)
                            <tr>
                              <td>{{$i}}</td>
                              <td>{{$key}}</td>
                              <td>{{$dataTable['teachingNorms'][$key]}} {{trans('labels.backend.common.house')}}</td>
                              <td>{{$value}} {{trans('labels.backend.common.house')}}</td>
                              @if($value - $dataTable['teachingNorms'][$key] > 0)
                                <td>{{$value - $dataTable['teachingNorms'][$key]}} {{trans('labels.backend.common.house')}}</td>
                              @else
                                <td>0 {{trans('labels.backend.common.house')}}</td>
                              @endif
                              @if($value - $dataTable['teachingNorms'][$key] < 0)
                                <td>{{$value - $dataTable['teachingNorms'][$key]}} {{trans('labels.backend.common.house')}}</td>
                              @else
                                <td>0 {{trans('labels.backend.common.house')}}</td>
                              @endif
                              <td>{{$dataTable['countMission'][$key]}}</td>
                            </tr>
                            <?php $i++; ?>
                          @endforeach()
                      @else
                        <!-- @foreach($dataTable['teachingNorms'] as $key => $value)
                          <tr>
                              <td>{{$i}}</td>
                              <td>{{$key}}</td>
                              <td>{{$value}} {{trans('labels.backend.common.house')}}</td>
                              <td>0 {{trans('labels.backend.common.house')}}</td>
                              <td>0 {{trans('labels.backend.common.house')}}</td>
                              <td>{{0 - $value}} {{trans('labels.backend.common.house')}}</td>
                              <td>0</td>
                          </tr>
                        @endforeach -->
                        <tr>
                          <td colspan='7'>{{trans('labels.backend.common.msg_data_empty')}}</td>
                        </tr>
                      @endif
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
          </div>
        </div>
      </div>
      @endif
      <!-- /.row -->
    </section>
    <!-- /.content -->
@stop
