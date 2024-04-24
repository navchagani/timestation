<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            <h4 class="modal-title"><b>Add tasks</b></h4>
            <div class="modal-body">

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('assigntask.store') }}">
                        <input type="hidden" value="{{$userid}}" name="userid">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <textarea class="form-control" placeholder="Please write something here..." name="name" cols="50" rows="10" id="name" required></textarea>
                            </div>
                                <div class="form-group col-md-6">
                                <label for="department" class="col-sm-6 control-label">Assign employees: </label>
                                <select class="form-control" id="employees" name="employees" required>
                                    <option value="" selected>- Employees -</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach

                                </select>
                                            <label for="department" class="col-sm-6 control-label">Duration: </label>
                                            <input type="text" class="form-control" placeholder="Enter Duration" id="duration" name="duration"
                                                   required />

                        </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Submit
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
