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
                    <select class="form-control" name="employee" id="employee">
                        <option hidden>Please Select</option>
                        <option>  Employee Report</option>
                        <option> Current Employee Report</option>
                        <option> Employee Daily Report</option>
                        <option> Employee Daily & Absence Report</option>
                        <option> Multiple Employee Summary Report</option>
                    </select>
                </div>
            </form>
            <div class="table-responsive">

            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#employee').change(function () {
                $(this).parents('form').submit();
            });
        });
    </script>
@endsection

