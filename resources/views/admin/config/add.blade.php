@extends('layouts.admin')
@section('content')
<div class="x-body">

    <form class="layui-form">

        <div class="layui-form-item">
            <label for="title" class="layui-form-label">
                <span class="x-red">*</span>标题
            </label>
            <div class="layui-input-inline">
                <input type="text" name="title" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>名称
            </label>
            <div class="layui-input-inline">
                <input type="text" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>排序
            </label>
            <div class="layui-input-inline">
                <input type="text" name="name" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="action_name" class="layui-form-label">
                <span class="x-red">*</span>类　　型：
            </label>
            <div class="layui-input-block">
                <input type="radio" name="field_type"  value="input" title="input" checked lay-filter="type">
                <input type="radio" name="field_type"  value="textarea" title="textarea" lay-filter="type">
                <input type="radio" name="field_type" value="radio" title="radio" lay-filter="type">
            </div>
        </div>

          <div class="layui-form-item" id="field_value" style="display:none;">
              <label for="action_name" class="layui-form-label">
                  <span class="x-red">*</span>类　型　值：
              </label>
              <div class="layui-input-inline">
                  <input type="text" name="field_value" value="" autocomplete="off" class="layui-input">该选项只有在Radio中使用！格式为：1|开启，0|关闭
              </div>
          </div>

          <div class="layui-form-item">
              <label for="controller_name" class="layui-form-label">
                  <span class="x-red">*</span>是否系统预留字段：
              </label>
              <div class="layui-input-inline">
                  <input type="checkbox" name="is_system" value="1" title="是">
              </div>
          </div>

          {{csrf_field()}}

          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>说明
              </label>
              <div class="layui-input-inline">
                  <textarea placeholder="请输入内容" class="layui-textarea" name="tips"></textarea>
              </div>
          </div>

          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  增加
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

    // 提交数据
    form.on('submit(add)', function(data){
        //发异步，把数据提交给php
        $.post("{{url('admin/config')}}",data.field,function(res){

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

    form.on('radio(type)', function(data){
        var type = data.value;
        if(type=='radio'){
            $('#field_value').show();
        }else if(type=='input'){
            $('#field_value').hide();
        }else if(type=="textarea"){
            $('#field_value').hide();
        }
    });
});
</script>
@endsection
