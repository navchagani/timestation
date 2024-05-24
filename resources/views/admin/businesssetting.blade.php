@extends('layouts.master')

@section('css')
    <!-- Table css -->
    <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
        type="text/css" media="screen">
@endsection

@section('breadcrumb')
    <div class="col-sm-12">
        <h4 class="page-title text-left px-3">Settings</h4>
        <ol class="breadcrumb px-3">
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
<div class="container-fluid mt-5">
    {{--<h1 class="text-primary">TimeStation</h1>
    <nav class="nav mb-4">
        <a class="nav-link" href="#">Home</a>
        <a class="nav-link" href="#">Employees</a>
        <a class="nav-link" href="#">Departments</a>
        <a class="nav-link" href="#">Reports</a>
        <a class="nav-link" href="#">Settings</a>
        <a class="nav-link" href="#">Support</a>
    </nav>--}}

    <div class="card shadow">
        <div class="card-header">
            <h2>Settings</h2>
        </div>
        <div class="card-body">
            <form>

                <div class="row mb-3 mt-4">
                    <div class="col-2">
                        <label for="company-name">Company Name:</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="company-name" value="Texas E Cigarette Inc">
                    </div>

                    <div class="col-2">
                        <label for="attendance-mode">Attendance Mode:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" id="attendance-mode">
                            <option value="attendance-time-tracking">Attendance and Time Tracking</option>
                            <option value="attendance-only">Attendance Only</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="" class="fw-bold" >GPS Location Tagging:</label>
                    </div>
                    <div class="col-4">
                        <input type="checkbox" class="" id="gps-location">
                        <label class="form-check-label" for="gps-location">Enable Location Tagging</label>
                    </div>

                    <div class="col-2">
                        <label for="attendance-mode" class="fw-bold">COVID-19 Screening:</label>
                    </div>
                    <div class="col-4">
                        <input type="checkbox" class="" id="covid-screening">
                        <label class="form-check-label" for="covid-screening">Enable COVID-19 Screening</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-2">
                        <label for="time-rounding">Time Rounding:</label>
                    </div>
                    <div class="col-4">
                        <select  class="form-control" name="TimeRounding" id="TimeRounding" onchange="">
                            <option value="0">None</option>
                            <option value="5">5 Minutes</option>
                            <option value="6" selected="">6 Minutes (1/10th of an hour)</option>
                            <option value="10">10 Minutes</option>
                            <option value="15">15 Minutes (7-minute rule)</option>
                            <option value="30">30 Minutes</option>
                        </select>
                    </div>

                    <div class="col-2">
                        <label for="attendance-mode">Display time round:</label>
                    </div>
                    <div class="col-4">
                        <input type="checkbox" class=" " id="display-round">
                        <label class="form-check-label" for="display-round">Display round in & out times in reports</label>
                    </div>
                </div>

                <div class="row mb-3 mt-5">
                    <div class="col-2">
                        <label class="fw-bold">Date & Time Format:</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-2">
                        <label class="form-label" for="date-format">Date:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="DateFormat" id="DateFormat" onchange="">
                            <option value="mm/dd/yyyy" selected="selected">MM/DD/YYYY</option>
                            <option value="dd/mm/yyyy">DD/MM/YYYY</option>
                            <option value="yyyy/mm/dd">YYYY/MM/DD</option>
                            <option value="mm.dd.yyyy">MM.DD.YYYY</option>
                            <option value="dd.mm.yyyy">DD.MM.YYYY</option>
                            <option value="yyyy.mm.dd">YYYY.MM.DD</option>
                            <option value="mm-dd-yyyy">MM-DD-YYYY</option>
                            <option value="dd-mm-yyyy">DD-MM-YYYY</option>
                            <option value="yyyy-mm-dd">YYYY-MM-DD</option>
                            <option value="yyyymmdd">YYYYMMDD</option>
                        </select>
                    </div>

                    <div class="col-2">
                        <label for="attendance-mode">Time:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="TimeFormat" id="TimeFormat" onchange="">
                            <option value="hh:mmAMPM" selected="selected">12 Hours (AM/PM)</option>
                            <option value="hh:mm">24 Hours</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-2">
                        <label for="hours-format">Hours display format:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" id="hours-format">
                            <option value="decimal-hours">Decimal Hours</option>
                            <option value="hours-mints">Hours and Minutes (HH:MM)</option>
                        </select>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-2">
                        <label for="report-range">Default Report Date Range:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" id="report-range">
                            <option value="last-7-days">Last 7 Days</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="checkbox" class="" id="include-today">
                        <label class="form-check-label" for="include-today">Include Today</label>
                    </div>
                </div>
                <div class="row mb-3 mt-5">
                    <div class="col-2">
                        <label class="fw-bold">Automatic Time Deduction:</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-2">
                        <label for="time-deduction">Deduct: </label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="automaticTimeDeduction" id="automaticTimeDeduction" onchange="automaticTimeDeductionChanged();">
                            <option value="0">None</option>
                            <option value="10">10 Minutes</option>

                            <option value="15">15 Minutes</option>

                            <option value="30">30 Minutes</option>

                            <option value="45">45 Minutes</option>

                            <option value="60">1 Hour</option>

                            <option value="90">90 Minutes</option>
                            <option value="120">2 Hours</option>
                          </select>
                    </div>

                    <div class="col-2">
                        <label for="time-deduction">Deduct: </label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" name="automaticTimeDeductionThreshold" id="automaticTimeDeductionThreshold" onchange=""  >
                            <option value="0">-</option>
                            <option value="60">1</option>
                            <option value="120">2</option>
                            <option value="180">3</option>
                            <option value="240">4</option>
                            <option value="300">5</option>
                            <option value="360">6</option>
                            <option value="420">7</option>
                            <option value="480">8</option>
                            <option value="540">9</option>
                            <option value="600">10</option>
                            <option value="660">11</option>
                            <option value="720">12</option>

                        </select>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-2">
                        <label for="card-info">Card Information:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" id="card-info">
                            <option value="company-name">Company Name</option>
                            <option value="employee-name">Employee Name</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="font-size">Font Size:</label>
                    </div>
                    <div class="col-4">
                        <select class="form-control" id="font-size">
                            <option value="auto">Auto</option>
                            <option value="small">small</option>
                            <option value="medium">medium</option>
                            <option value="large">large</option>
                        </select>
                    </div>
                </div>


                <div class="form-group text-center mb-3 mt-4">
                    <button type="submit" class="btn btn-success w-100">Save</button>
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
