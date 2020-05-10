
@extends('backend.layouts.app')
@section('content')
<section class="content">
    <form method="POST" id="search-form" class="form-horizontal" action="{{route('mst_users.postchangepass')}}">
      @csrf
      <div class="row">
        <div class="col-md-9">
          <!-- general form elements -->
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('labels.backend.users.changepass')}}</h3>
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
                            <label for="inputEmail3" class="col-sm-4 control-label">{{trans('labels.backend.users.form.password_old')}}</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control @error('password_old') is-invalid @enderror" name="password_old" placeholder="Nhập mật khẩu cũ">
                            </div>
                        </div>
                    </div>
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
                        <a class="btn btn-app" href="{{route('dashboard')}}">
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
