@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
        type="text/css" media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-12">
        <h4 class="page-title text-left">Settings</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>


        </ol>
    </div>
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
<style>

    .container {
        width: 800px;
       /* margin: 0 auto;*/
    }
    h1 {
        color: #1a9bcb;
    }
    .menu {
        margin-bottom: 20px;
    }
    .menu a {
        margin-right: 15px;
        text-decoration: none;
        color: #1a9bcb;
    }
    .menu a:hover {
        text-decoration: underline;
    }
    .settings {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 8px;
    }
    .settings label {
        display: block;
        margin-top: 10px;
    }
    .settings input, .settings select {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
    }
    .save-button {
        margin-top: 20px;
        text-align: center;
    }
    .save-button input {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .save-button input:hover {
        background-color: #45a049;
    }
</style>
<div class="container mt-5">
    {{--<h1 class="text-primary">TimeStation</h1>
    <nav class="nav mb-4">
        <a class="nav-link" href="#">Home</a>
        <a class="nav-link" href="#">Employees</a>
        <a class="nav-link" href="#">Departments</a>
        <a class="nav-link" href="#">Reports</a>
        <a class="nav-link" href="#">Settings</a>
        <a class="nav-link" href="#">Support</a>
    </nav>--}}

    <div class="card">
        <div class="card-header">
            <h2>Settings</h2>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="company-name">Company Name:</label>
                    <input type="text" class="form-control" id="company-name" value="Texas E Cigarette Inc">
                </div>

                <div class="form-group">
                    <label for="attendance-mode">Attendance Mode:</label>
                    <select class="form-control" id="attendance-mode">
                        <option value="attendance-time-tracking">Attendance and Time Tracking</option>
                        <option value="attendance-only">Attendance Only</option>
                    </select>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="gps-location">
                    <label class="form-check-label" for="gps-location">Enable Location Tagging</label>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="covid-screening">
                    <label class="form-check-label" for="covid-screening">Enable COVID-19 Screening</label>
                </div>

                <div class="form-group">
                    <label for="time-rounding">Time Rounding:</label>
                    <select class="form-control" id="time-rounding">
                        <option value="6-min">6 Minutes (1/10 of an hour)</option>
                    </select>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="display-round">
                        <label class="form-check-label" for="display-round">Display round in & out times in reports</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date-format">Date & Time Format:</label>
                    <select class="form-control" id="date-format">
                        <option value="mmddyyyy">MM/DD/YYYY</option>
                    </select>
                    <select class="form-control mt-2" id="time-format">
                        <option value="12-hours">12 Hours (AM/PM)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="hours-format">Hours display format:</label>
                    <select class="form-control" id="hours-format">
                        <option value="decimal-hours">Decimal Hours</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="time-deduction">Automatic Time Deduction:</label>
                    <select class="form-control" id="time-deduction">
                        <option value="none">None</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="report-range">Default Report Date Range:</label>
                    <select class="form-control" id="report-range">
                        <option value="last-7-days">Last 7 Days</option>
                    </select>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="include-today">
                        <label class="form-check-label" for="include-today">Include Today</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="card-info">Card Information:</label>
                    <select class="form-control" id="card-info">
                        <option value="company-name">Company Name</option>
                        <option value="employee-name">Employee Name</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="font-size">Font Size:</label>
                    <select class="form-control" id="font-size">
                        <option value="auto">Auto</option>
                    </select>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
