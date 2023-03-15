@extends('admin.Base')
@section('title','Thông tin file')
@section('main')
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Thông tin file</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Thông tin file</h1>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Thông tin</div>
                <div class="panel-body">
                    <form method="POST" role="form" enctype="multipart/form-data"
                          action="{{empty($item) ? asset('admin/files/store') : asset('admin/files/update')}}">
                        {{csrf_field()}}
                        <input class="form-control" placeholder="id" name="id" type="hidden"
                               value="{{isset($item->id)?$item->id:''}}">
                        <div class="form-group col-sm-8">
                            <label>Tên file</label>
                            <input class="form-control" placeholder="Tên file" name="title"
                                   value="{{isset($item->title)?$item->title:''}}">
                        </div>
                        <div class="form-group col-sm-8">
                            <label>Mã code</label>
                            <input class="form-control" placeholder="code" name="code"
                                   value="{{isset($item->code)?$item->code:''}}">
                        </div>
                        <div class="form-group col-sm-8">
                            <label>Mô tả</label>
                            <input class="form-control" type="text" placeholder="Mô tả" name="description"
                                   value="{{isset($item->description)?$item->description:''}}">
                        </div>
                        <div class="form-group col-sm-8">
                            <label>Chọn file</label>
                            <input class="form-control" type="file" placeholder="Mô tả" name="file_name"
                                   value="{{isset($item->file_name)?$item->file_name:''}}">
                        </div>
                        <br>
                        <div class="col-sm-12">
                            @if(empty($item))
                                <button class="btn btn-lg btn-primary">Thêm</button>
                            @else
                                <button class="btn btn-lg btn-primary">Chỉnh sửa</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.panel-->
    </div><!-- /.col-->
    <div class="col-sm-12">
        <p class="back-link">Render Theme by <a href="https://kipo.vn">Render</a></p>
    </div>
    </div><!-- /.row -->
@stop
