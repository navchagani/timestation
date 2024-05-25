@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Administrator List Reports</b></center>
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
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th> Name</th>
                        <th>eMail</th>
                        <th>Departments</th>
                        <th>Permissions</th>
                        <th>Date Created</th>
                        <th>Last Login</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (sizeof($users))
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email  }}</td>
                                <td>[ALL]</td>
                                <td>[FULL]</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="6"><center>No Administrator List records found</center></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
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

