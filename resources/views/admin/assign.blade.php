@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
        type="text/css" media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <h4 class="page-title text-left">List of tasks</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);"> List of uncompleted tasks</a></li>


        </ol>
    </div>
@endsection
@section('button')
    <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Add task</a>


@endsection

@section('content')
@include('includes.flash')

<!--Show Validation Errors here-->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!--End showing Validation Errors here-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                    <tr>
                                        <th data-priority="1">Task</th>
                                        <th data-priority="2">Assigned Employee</th>
                                        <th data-priority="5">Duration</th>
                                        <th data-priority="5">Task Assigned Date</th>
                                        <th data-priority="5">Status</th>
                                        <th data-priority="5">Completed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assigns as $assign)
                                        <tr>
                                            <td> {{ $assign->name }} </td>
                                            <td> {{ $assign->ename}}</td>
                                            <td> {{ $assign->duration}} days</td>
                                            <td>{{ $assign->created_at}} </td>
                                            <td> @if ($assign->is_active== 1)
                                                    <span class="badge badge-success badge-pill">Active</span>
                                                   @else
                                                    <span class="badge badge-danger badge-pill">Active</span>
                                                   @endif</td>
                                            <td> @if ($assign->completed== 1)
                                                    <span class="badge badge-success badge-pill">Complete</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Pending</span>
                                                @endif
                                            </td>
                                            {{--<td>

                                                <a href="#edit{{ $assign->employee_id}}" data-toggle="modal"
                                                    class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i>
                                                    Edit</a>
                                                <a href="#delete{{ $departments->name }}" data-toggle="modal"
                                                    class="btn btn-danger btn-sm delete btn-flat"><i
                                                        class='fa fa-trash'></i> Delete</a>

                                            </td>--}}
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

   {{-- @foreach ($department as $departments)
        @include('includes.edit_delete_department')
    @endforeach--}}

    @include('includes.add_assign')

@endsection


@section('script')
    <!-- Responsive-table-->
    <script src="{{ URL::asset('plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>
@endsection

@section('script')
    <script>
        $(function() {
            $('.table-responsive').responsiveTable({
                addDisplayAllBtn: 'btn btn-secondary'
            });
        });
    </script>
@endsection
