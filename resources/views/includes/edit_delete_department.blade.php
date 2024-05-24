<!-- Edit -->
<div class="modal fade" id="edit{{ $empgname['did'] }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <h4 class="modal-title"><b><span class="employee_id">Edit Department</span></b></h4>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('department.update', $empgname['position'] ) }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="did" value="{{$empgname['did']}}">
                    <div class="form-group">
                        <label for="name">Department Name:</label>
                        <input type="text" class="form-control" placeholder="Enter Department Name" id="name" name="name"
                               required value="{{ $empgname['position'] }}" />
                    </div>
                    <div class="form-group">
                        <label for="name">Department Type:</label>
                        <select class="form-control" name="DepartmentType" id="DepartmentType" style="margin-left:0px;">
                            <option selected>{{ $empgname['type'] }}</option>
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
                        <input type="checkbox" name="reporting" value="1" @if($empgname['reporting'] == 1) checked @endif> Exclude from Reports
                    </div>
                    <div class="form-group">
                        <label for="name">Automatic Time Deduction :    </label>
                        <input type="checkbox" name="deduction" value="1" @if($empgname['timededuction'] == 1) checked @endif> Use Company Settings
                    </div>
                    <div class="form-group">
                        <label for="name">Assign to All :     </label>
                        <input type="checkbox" name="assign" value="1" @if($empgname['assign'] == 1) checked @endif> Assign to All Employees
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                    Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete{{ $empgname['did'] }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">

              <h4 class="modal-title "><span class="employee_id">Delete Department</span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('department.destroy',$empgname['position'] ) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <h6>Are you sure you want to delete:</h6>
                        <h2 class="bold del_employee_name">{{ $empgname['position'] }}</h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
