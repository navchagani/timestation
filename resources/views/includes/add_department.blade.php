<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            <h4 class="modal-title"><b>Add Department</b></h4>
            <div class="modal-body">

                <div class="card-body text-left">

                    <form method="POST" action="{{ route('department.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Department Name:</label>
                            <input type="text" class="form-control" placeholder="Enter Department Name" id="name" name="name"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="name">Department Type:</label>
                            <select class="form-control" name="DepartmentType" id="DepartmentType" style="margin-left:0px;">
                                <option value="Class">Class</option>
                                <option value="Client">Client</option>
                                <option value="Department" >Department</option>
                                <option value="Group">Group</option>
                                <option value="Job">Job</option>
                                <option value="Job-Site">Job-Site</option>
                                <option value="Location">Location</option>
                                <option value="Office">Office</option>
                                <option value="Project">Project</option>
                                <option value="Task">Task</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Reporting :    </label>
                            <input type="checkbox" name="reporting" value="1"> Exclude from Reports
                        </div>
                        <div class="form-group">
                            <label for="name">Automatic Time Deduction :    </label>
                            <input type="checkbox" name="deduction" value="1"> Use Company Settings
                        </div>
                        <div class="form-group">
                            <label for="name">Assign to All :     </label>
                            <input type="checkbox" name="assign" value="1"> Assign to All Employees
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
