@extends('layouts.master')
@section('content')
    <form method="POST" action="{{ route('filter') }}">
        @csrf
        <div class="form-group row">
            <div class="col-md-2">
                <label class="required" for="employee">Select Reports</label>
                <select class="form-control" name="employeereport" id="employeereport">
                    <option hidden>Please Select</option>
                    <option value="/administrator-list">Administrator list</option>
                    <option value="/attendance-counter">Attendance Counter</option>
                    <option value="/attendance-list">Attendance Only</option>
                    <option value="/department-list">Department list</option>
                    <option value="/sheet-report">Employee Report</option>
                    <option value="/current-employee">Current Employee Report</option>
                    <option value="/employee-daily">Employee Daily Summary</option>
                    <option value="/daily-absence">Employee Daily & Absence Report</option>
                    <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="required" for="employee">Employee</label>
                <select class="form-control" name="employee">
                    <option hidden>Select an employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request()->input('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="time_in" class="col-sm-6 control-label">Start Date</label>
                <div class="bootstrap-timepicker">
                    <input type="date" class="form-control timepicker" id="start" name="start" required>
                </div>
            </div>
            <div class="col-md-2">
                <label for="time_out" class="col-sm-6 control-label">End Date</label>
                <div class="bootstrap-timepicker">
                    <input type="date" class="form-control timepicker" id="end" name="end" required>
                </div>
            </div>
            <div class="col-md-2">
                <label for="time_out" class="col-sm-6 control-label"><br></label>
                <button type="submit" class="btn btn-primary form-control">
                    Run Report
                </button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Employee Daily & Absence</b></center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                       {{-- <th><input type="checkbox" id="checkAll"></th>--}}
                        <th>#</th>
                        <th>Month</th>
                        <th> Name</th>
                        <th>Department</th>
                        <th>Total Hours</th>
                        <th>Hourly Rate</th>
                        <th>Total Pay</th>

                        <th>Payment</th>
                        <th>balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form method="POST" action="{{ route('paynow') }}">
                        @csrf
                    @php
                        $grandTotal = 0; // Initialize grand total outside the loop
                        $grandTotaltwo = 0;
             @endphp
                    @foreach ($employees as $employee)
                        <tr>
                            {{--<td><input type="checkbox" name="employee_checkbox[]" value="{{ $employee->id }}"></td>--}}
                            @php
                                $totalValue = 0;
                                $totalValuepay =0;
                                $today = today();
                            @endphp


                            @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)
                                @php
                                    $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                    $check_attd = \App\Models\Attendance::query()
                                        ->where('emp_id', $employee->id)
                                        ->where('attendance_date', $date_picker)
                                        ->get();

                                @endphp
                                @foreach ($check_attd as $check_attds)
                                    @if ($check_attds->status=='OUT')
                                        @php
                                            $checkattd = \App\Models\Attendance::query()
                                                ->where('emp_id', $employee->id)
                                                ->where('attendance_date', $date_picker)
                                                ->where('status', 'IN')
                                                ->first();

                                            $existingAttendanceTime = DateTime::createFromFormat('H:i:s', $check_attds->attendance_time);
                                            $existingAttendanceend = DateTime::createFromFormat('H:i:s', $checkattd->attendance_time);
                                            $difference = $existingAttendanceTime->diff($existingAttendanceend);
                                            $totalSecondsDifference = $difference->h;
                                            $totalValue += $totalSecondsDifference;
                                        @endphp
                                    @endif

                                            @php
                                                $checkattd = \App\Models\Attendance::query()
                                                    ->where('emp_id', $employee->id)
                                                    ->where('attendance_date', $date_picker)
                                                     ->where('pay', '1')
                                                    ->first();

                                                if ($checkattd) {

                                                $existingAttendanceTime = DateTime::createFromFormat('H:i:s', $check_attds->attendance_time);
                                                $existingAttendanceend = DateTime::createFromFormat('H:i:s', $checkattd->attendance_time);
                                                $difference = $existingAttendanceTime->diff($existingAttendanceend);
                                                $totalSecondsDifference = $difference->h;
                                                $totalValuepay += $totalSecondsDifference;

                                                }
                                            @endphp

                                @endforeach
                            @endfor
                            @php
                                $tpbs = $employee->hourrate * $totalValue ?? 0
                            @endphp
                            <td><input type="checkbox" class="employee-checkbox" data-pay="{{$tpbs}}" name="employee_checkbox[]" value="{{ $employee->id }}"></td>
                            <td>{{ $d = date('Y-M') }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $totalValue ?? 0 }}</td>
                            <td>${{ $employee->hourrate }}</td>
                            <td>${{$tp = $employee->hourrate * $totalValue ?? 0 }}</td>
                            {{--<td><input type="checkbox" class="employee-checkbox" data-pay="{{$tp}}"></td>--}}
                            <td>${{$tpb = $employee->hourrate * $totalValuepay ?? 0 }}</td>
                            <td>${{$tp - $tpb}}</td>
                        </tr>
                        @php
                            $grandTotal += $employee->hourrate * $totalValue; // Calculate the subtotal for each employee and add it to the grand total
                            $grandTotaltwo += $employee->hourrate * $totalValuepay;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="6"><strong>Total Payment Amount:</strong></td>
                        <td>${{ $grandTotal }}</td> <!-- Display the grand total -->
                        <td>${{ $grandTotaltwo }}</td>
                        <td>${{ $g = $grandTotal - $grandTotaltwo }}</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div class="col-md-4">

                                   {{-- <input type="hidden" name="emp" value="{{$empi}}">
                                    <input type="hidden" name="sta" value="{{$sta}}">
                                    <input type="hidden" name="dend" value="{{$dend}}">--}}
                                    {{--<button type="submit"  @if($grandTotal == 0) disabled @elseif($checkattd !== null && isset($checkattd->pay)== 1) disabled   @else class="btn btn-primary form-control" @endif >--}}
                                <button type="submit" id="submit-button" disabled class="btn btn-primary form-control">
                                        {{--Pay Amount ${{$g}}--}}
                                        Total Pay Amount: $<span id="total-pay">0</span>
                                    </button>
                                @if($checkattd !== null && isset($checkattd->pay) == 1)
                                    <div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong> Already! </strong>{{ $error }}
                                    </div>
                                @endif

                            </div>
                        </td>
                    </tr>
                    </form>
                    </tbody>
                </table>
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
    {{--<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Select the "Check All" checkbox
            const checkAllCheckbox = document.getElementById('checkAll');

            // Select all employee checkboxes
            const employeeCheckboxes = document.querySelectorAll('input[name="employee_checkbox[]"]');

            // Add event listener to the "Check All" checkbox
            checkAllCheckbox.addEventListener('change', function () {
                // Iterate over each employee checkbox
                employeeCheckboxes.forEach(function (checkbox) {
                    // Set the state of each employee checkbox to match the state of the "Check All" checkbox
                    checkbox.checked = checkAllCheckbox.checked;
                });
            });

            // Add event listener to each employee checkbox to update the "Check All" checkbox state
            employeeCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    // If any of the employee checkboxes are unchecked, uncheck the "Check All" checkbox
                    if (!checkbox.checked) {
                        checkAllCheckbox.checked = false;
                    }
                    // If all employee checkboxes are checked, check the "Check All" checkbox
                    else {
                        const allChecked = Array.from(employeeCheckboxes).every(function (cb) {
                            return cb.checked;
                        });
                        checkAllCheckbox.checked = allChecked;
                    }
                });
            });
        });
    </script>--}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            const totalPayElement = document.getElementById('total-pay');
            const submitButton = document.getElementById('submit-button');

            let totalPay = 0;

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const pay = parseFloat(this.dataset.pay);
                    if (this.checked) {
                        totalPay += pay;
                    } else {
                        totalPay -= pay;
                    }
                    totalPayElement.textContent = totalPay.toFixed(2);

                    // Enable submit button if total pay amount is greater than 0
                    submitButton.disabled = totalPay <= 0;
                });
            });
        });
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

