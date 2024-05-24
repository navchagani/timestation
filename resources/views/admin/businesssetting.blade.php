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
        width: 600px;
        margin: 0 auto;
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
<div class="container">
   {{-- <div class="menu">
        <a href="#">Home</a>
        <a href="#">Employees</a>
        <a href="#">Departments</a>
        <a href="#">Reports</a>
        <a href="#">Settings</a>
        <a href="#">Support</a>
    </div>--}}

    <div class="settings">
        <h2>Settings</h2>
        <label for="company-name">Company Name:</label>
        <input type="text" id="company-name" value="Texas E Cigarette Inc">

        <label>Attendance Mode:</label>
        <select>
            <option value="attendance-time-tracking">Attendance and Time Tracking</option>
            <option value="attendance-only">Attendance Only</option>
        </select>

        <label>GPS Location Tagging:</label>
        <input type="checkbox" id="gps-location">
        <label for="gps-location">Enable Location Tagging</label>

        <label>COVID-19 Screening:</label>
        <input type="checkbox" id="covid-screening">
        <label for="covid-screening">Enable COVID-19 Screening</label>

        <label for="time-rounding">Time Rounding:</label>
        <select id="time-rounding">
            <option value="6-min">6 Minutes (1/10 of an hour)</option>
        </select>
        <input type="checkbox" id="display-round">
        <label for="display-round">Display round in & out times in reports</label>

        <label for="date-format">Date & Time Format:</label>
        <select id="date-format">
            <option value="mmddyyyy">MM/DD/YYYY</option>
        </select>
        <select id="time-format">
            <option value="12-hours">12 Hours (AM/PM)</option>
        </select>

        <label for="hours-format">Hours display format:</label>
        <select id="hours-format">
            <option value="decimal-hours">Decimal Hours</option>
        </select>

        <label for="time-deduction">Automatic Time Deduction:</label>
        <select id="time-deduction">
            <option value="none">None</option>
        </select>

        <label for="report-range">Default Report Date Range:</label>
        <select id="report-range">
            <option value="last-7-days">Last 7 Days</option>
        </select>
        <input type="checkbox" id="include-today">
        <label for="include-today">Include Today</label>

        <label>Card Information:</label>
        <select>
            <option value="company-name">Company Name</option>
            <option value="employee-name">Employee Name</option>
        </select>

        <label for="font-size">Font Size:</label>
        <select id="font-size">
            <option value="auto">Auto</option>
        </select>

        <div class="save-button">
            <input type="submit" value="Save">
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
