@extends('layouts.master')

@section('page-title', '作業管理|和東資訊教學網')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumbs-->
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ route('index') }}">儀表統計</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ route('admin.index') }}">系統管理</a>
    </li>
    <li class="breadcrumb-item active">作業管理</li>
  </ol>
  <div class="row">
    <div class="col-12">
      <h1><img src="{{ asset('img/title/task.png') }}" alt="作業管理logo" width="60">作業管理</h1>
    </div>
    </div>
  <div class="row">
    <div class="col-12">
      <div class="card-header">
        <span class="fa fa-list"></span> 作業列表</div>
      <div class="card-body">
      <table class="table table-striped">
        <tr>
          <th>
            學期
          </th>
          <th>
            作業類型
          </th>
          <th>
            標題
          </th>
          <th>
            說明
          </th>
          <th>
            對象
          </th>
          <th>
            停用?
          </th>
          <th width="250">
            動作
          </th>
        </tr>
            {{ Form::open(['route' => 'admin.task.store', 'method' => 'POST','id'=>'store_task','onsubmit'=>'return false;']) }}
        <tr>
            <?php
            $y = date('Y');
            $m = date('m');
            if($m > 7 or $m < 2){
                $semester = $y-1911 . "1";
            }

            if($m > 1 and $m < 8){
                $semester = $y-1912 . "2";
            }

            ?>
          <td>
            {{ Form::text('semester',$semester,['id'=>'semester','class' => 'form-control', 'placeholder' => '請輸入學期','required'=>'required','maxlength'=>'4']) }}
          </td>
          <td>
            {{ Form::select('type', $types, null, ['id' => 'types', 'class' => 'form-control','placeholder'=>'請選擇類型']) }}
          </td>
          <td>
            {{ Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => '標題','required'=>'required']) }}
          </td>
          <td>
            {{ Form::text('description', null, ['id' => 'description', 'class' => 'form-control', 'placeholder' => '說明','required'=>'required']) }}
          </td>
          <td>
            {{ Form::select('for[]', $groups, null, ['id' => 'for', 'class' => 'form-control','multiple'=>'multiple','placeholder'=>'請多選群組']) }}
          </td>
          <td>
            <input type="checkbox" name="close" value="1">停用
          </td>
          <td>
            <a href="#" class="btn btn-success" onclick="bbconfirm('store_task','確定新增作業？')"><i class="fa fa-plus"></i> 新增作業</a>
          </td>
        </tr>
        {{ Form::close() }}
        @foreach($tasks as $task)
          <tr>
            <td nowrap>
              <i class="fa fa-folder-open-o"></i> {{ $task->semester }}
            </td>
            <td>
              {{ $types[$task->type] }}
            </td>
            <td>
              {{ $task->title }}
            </td>
            <td>
              {{ $task->description }}
            </td>
            <td>
              id：{{ $task->for }}
            </td>
            <td>
              <?php
                if($task->close==1){
                    $c = "btn-warning";
                    $t = "已停";
                }else{
                    $c = "btn-success";
                    $t = "可用";
                }
              ?>
                {{ Form::open(['route' => ['admin.task.update',$task->id], 'method' => 'POST','id'=>'update'.$task->id,'onsubmit'=>'return false;']) }}
              <a href="#" class="btn {{ $c }}" onclick="bbconfirm('update{{ $task->id }}','確定？')">{{ $t }}</a>
                {{ Form::close() }}
            </td>
            <td>
              <?php
                $data=[
                    'select'=>0,
                    'for'=>$task->for,
                    'task_id'=>$task->id,
                ];
              ?>
              <a href="{{ route('admin.task.view',$data) }}" class="btn btn-primary"><i class="fa fa-eye"></i> 批改作業</a>
              <a href="{{ route('admin.task.destroy',$task->id) }}" class="btn btn-danger" id="delete{{ $task->id }}" onclick="bbconfirm2('delete{{ $task->id }}','確定刪除作業？')"><i class="fa fa-trash"></i> 刪除作業</a>
            </td>
          </tr>
        @endforeach
      </table>
      </div>
    </div>

    </div>
  </div>

</div>
@endsection