@extends('layouts.admin')
@section('content')
<div class="x-body">
    <form class="layui-form">

        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="title" value="{{$data->title}}" required="" autocomplete="off" class="layui-input">
            </div>
        </div>
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>短标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="short_title" required=""  autocomplete="off" class="layui-input" value="{{$data->short_title}}">
            </div>
        </div>

        <input type="hidden" name="picture" id="mpicture" value="{{$data->picture}}">
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>图片
            </label>
            <div class="layui-upload-drag" id="test10">
                <img width="100px" height="100px" id="loadimg" src="{{$data->picture}}" @if ($data->picture == '')style="display:none;" @endif>
                <i class="layui-icon" id="icon"></i>
                <p id="notic">点击上传，或将文件拖拽到此处</p>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>排序
            </label>
            <div class="layui-input-inline">
                <input type="text" name="sort" autocomplete="off" class="layui-input" value="{{$data->title}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>关键字
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_email" name="keywords" required="" autocomplete="off" class="layui-input" value="{{$data->title}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>简介
            </label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea">{{$data->abstract}}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>内容
            </label>
            <div class="layui-input-inline">
                <script id="editor" name="content" type="text/plain" style="width:860px;height:300px;">{!!$data->content!!}</script>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                更新
            </button>
        </div>

    </form>
</div>
<script>
layui.use(['form','layer','upload'], function(){
    $ = layui.jquery;
    var form = layui.form
    ,layer = layui.layer
    ,upload = layui.upload;

    //拖拽上传
    upload.render({
        elem: '#test10'
        ,url: '{{url("admin/upload")}}'
        ,data: {'timestamp' : '<?php echo time();?>',
                '_token'    : "{{csrf_token()}}",
                'name'      : "article"
            }
        ,field: "upfile"
        ,done: function(res){
            //如果上传失败
            if(res.code !=  200){
                return layer.msg(res.msg);
            }else {
                //上传成功
                $('#mpicture').val(res.msg);
                $('#icon').hide();
                $('#notic').hide();
                $('#loadimg').show();
                $('#loadimg').attr('src',res.msg);

            }
        }
    });

    //监听提交
    form.on('submit(add)', function(data){
        //发异步，把数据提交给php
        $.post("{{url('admin/substance/'.$data->id)}}",data.field,function(res){

    		if(res.code == 200){
                layer.alert(res.msg, {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                });
            }else{
    			layer.msg(res.msg, {time: 2000});
    		}
        },'json');

        return false;
    });
});
</script>
<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
<script type="text/javascript">
    var ue = UE.getEditor('editor');
</script>
@endsection
