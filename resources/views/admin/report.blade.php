@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Reports</b></center>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group col-md-3">
                    <label class="required" for="employee">Select Reports</label>
                    <select class="form-control" name="employeereport" id="employeereport">
                        <option hidden>Please Select</option>
                        <option value="/administrator-list">Administrator list</option>
                        <option value="/attendance-counter">Attendance Counter</option>
                        <option value="/attendance-list">Attendance Only</option>
                        <option value="/department-list">Department list</option>
                        <option value="/department-member">Department Members</option>
                        <option value="/sheet-report">Employee Report</option>
                        <option value="/current-employee">Current Employee Report</option>
                        <option value="/employee-daily">Employee Daily Summary</option>
                        <option value="/daily-absence">Employee Daily & Absence Report</option>
                        <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
                    </select>
                </div>
            </form>
            <div class="table-responsive">

            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#employeereport').change(function () {
                var selectedOption = $(this).val();
                if (selectedOption) {
                    window.location.href = selectedOption;
                }
            });
        });
    </script>
@endsection

