<!-- Add -->
<script>
    $(document).ready(function() {
        $('#pin').on('input', function() {
            var valueToCheck = $(this).val();

            $.ajax({
                url: '{{ route("check-duplicate") }}', // The URL where the Ajax request will be sent
                method: 'POST', // Using the POST method
                data: {
                    value: valueToCheck, // The value to check for duplicates
                    _token: '{{ csrf_token() }}' // CSRF token for Laravel security
                },
                success: function(response) { // Handling the response from the server
                    if (response.duplicate) {
                        $('#error-message').show(); // Show the error message
                    } else {
                        $('#error-message').hide(); // Hide the error message if no duplicate found
                    }
                },
                error: function(xhr, status, error) { // Handling errors, if any
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Create New Employee</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>


            <div class="modal-body">

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="name">Name: </label>
                            <input type="text" class="form-control" placeholder="Enter Employee Name" id="name" name="name"
                                required />
                        </div>
                            <div class="form-group col-md-6">
                            <label for="department" class="col-sm-3 control-label">Department: </label>
                            <select class="form-control" id="position" name="position" required>
                                <option value="" selected>- Select -</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->name}}">{{$department->name}}</option>
                                @endforeach

                            </select>

                        </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="position">Employees ID: </label>
                            <input type="text" class="form-control" placeholder="Enter Employee ID" id="empid" name="empid"
                                   required />
                        </div>
                            <div class="form-group col-md-6">
                            <label for="position">Title: </label>
                            <input type="text" class="form-control" placeholder="Enter Title" id="title" name="title"
                                   required />
                        </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="position">Hour rate: </label>
                            <input type="text" class="form-control" placeholder="Enter Hour rate" id="hrate" name="hourrate"
                                   required />
                        </div>

                            <div class="form-group col-md-6">

                            <label for="position">4 Digit pin: </label>
                                <span id="error-message" style="display: none; color: red;font-size: large;">Pin Already exist!</span>
                            <input type="text" class="form-control" placeholder="Enter 4 Digit pin" id="pin" name="pin"
                                   required />
                        </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">Notifications : </div>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="notification">
                                    <label class="form-check-label" for="gridCheck1">
                                        Send email notification when employee checks-in or out
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                            <label for="email" class="col-sm-3 control-label">Email : </label>
                            <input type="email" class="form-control" id="email" name="email">

                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="password" class="col-sm-3 control-label">Password :</label>
                            <label for="password" class="col-sm-8 control-label">An eMail invitation will be sent to create an account password</label>
                        </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">Permissions : </div>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="Papp">
                                    <label class="form-check-label" for="gridCheck1">
                                        Login to the TimStation App
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="Psite">
                                    <label class="form-check-label" for="gridCheck1">
                                        Login to the TimeStation Site
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{--<div class="form-group">
                            <label for="schedule" class="col-sm-3 control-label">Schedule</label>


                            <select class="form-control" id="schedule" name="schedule" required>
                                <option value="" selected>- Select -</option>
                                @foreach($schedules as $schedule)
                                <option value="{{$schedule->slug}}">{{$schedule->slug}} -> from {{$schedule->time_in}}
                                    to {{$schedule->time_out}} </option>
                                @endforeach

                            </select>

                        </div>--}}

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Create New Employee
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5" data-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>

    </div>
</div>
</div>

