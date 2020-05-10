
@extends('backend.layouts.app')
@section('content')
<section class="content">
    <form method="POST" id="search-form" class="form-horizontal" action="{{route('mst_users.create')}}">
      @csrf
      <div class="row">
        <div class="col-md-9">
          <!-- general form elements -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.users.add')}}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                @include('includes.error')
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.code')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" value="{{old('code')}}" name="code"  placeholder="Nhập mã giảng viên">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.name')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" name="name"  placeholder="Nhập họ tên">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.email')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" name="email" id="inputEmail3" placeholder="Nhập địa chỉ email">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.gender')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                    @foreach($dataDefault['MstGender'] as $k => $val)
                                        <option value="{{$k}}" {{(old('gender') == $k) ? 'selected' : ''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.date_of_birth')}}</label>
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <div class="input-group-addon  @error('date_of_birth') is-invalid @enderror">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right @error('date_of_birth') is-invalid @enderror" value="{{(old('date_of_birth')) ? old('date_of_birth') : date('d/m/Y')}}" name="date_of_birth" id="datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.password')}}</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Nhập mật khẩu">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.password_confirm')}}</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.mst_semester.form.name')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control select-mst-title @error('smt_name') is-invalid @enderror" name="id_semester">
                                    @foreach($dataDefault['MstSemester'] as $key => $valueMstSemester)
                                        <option value="{{$key}}" {{(old('id_semester') == $key) ? 'selected' : ''}}>{{$valueMstSemester}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.title')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control select-mst-title @error('mst_title') is-invalid @enderror" name="mst_title">
                                    @foreach($dataDefault['MstTitle'] as $key => $valueTitle)
                                        <option value="{{$key}}" {{(old('mst_title') == $key) ? 'selected' : ''}}>{{$valueTitle}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.position')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control select-mst-position @error('mst_position') is-invalid @enderror" name="mst_position">
                                    @foreach($dataDefault['MstPosition'] as $key => $valuePosition)
                                        <option value="{{$key}}"  {{(old('mst_position') == $key) ? 'selected' : ''}}>{{$valuePosition}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.unit')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control @error('mst_unit') is-invalid @enderror" name="mst_unit">
                                    @foreach($dataDefault['MstUnit'] as $key => $valueUnit)
                                        <option value="{{$key}}" {{(old('mst_unit') == $key) ? 'selected' : ''}}>{{$valueUnit}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.role')}}</label>
                            <div class="col-sm-8">
                                <select class="form-control @error('role') is-invalid @enderror" name="role">
                                    @foreach($dataDefault['MstRole'] as $key => $value)
                                        <option value="{{$key}}" {{(old('role') == $key) ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="box-footer">
                <button type="submit" class="btn btn-primary margin pull-right"><i class="fa fa-save"></i>{{trans('labels.backend.common.back')}}</button>
            </div> -->
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
            <!-- /.box-body -->
          <!-- /.box -->
        </div>
        <!-- left column -->
        <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-app">
                            <i class="fa fa-save"></i> {{trans('labels.backend.common.save')}}
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-app" href="{{route('mst_users.index')}}">
                            <i class="fa fa-repeat"></i> {{trans('labels.backend.common.back')}}
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      </form>
      <!-- /.row -->
    </section>
@stop
