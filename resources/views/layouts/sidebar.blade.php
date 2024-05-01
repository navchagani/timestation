      <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="slimscroll-menu" id="remove-scroll">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <!-- Left Menu Start -->
                        <ul class="metismenu" id="side-menu">
                            <li class="menu-title">Main</li>
                            <li class="">
                                <a href="{{route('admin')}}" class="waves-effect {{ request()->is("admin") || request()->is("admin/*") ? "mm active" : "" }}">
                                    <i class="ti-home"></i><span class="badge badge-primary badge-pill float-right">2</span> <span> Dashboard </span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i><span> User <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="submenu">
                                    <li>
                                        <a href="https://opaltimecard.com/users" class="waves-effect {{ request()->is("user") || request()->is("/user") ? "mm active" : "" }}"><i class="dripicons-view-apps"></i><span>User List</span></a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i><span> Employees <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="submenu">
                                    <li>
                                        <a href="https://opaltimecard.com/employees" class="waves-effect {{ request()->is("employees") || request()->is("/employees") ? "mm active" : "" }}"><i class="dripicons-view-apps"></i><span>Employees List</span></a>
                                    </li>

                                </ul>
                            </li>
                            <li class="">
                                <a href="https://opaltimecard.com/department" class="waves-effect {{ request()->is("schedule") || request()->is("schedule/*") ? "mm active" : "" }}">
                                    <i class="ti-time"></i> <span> Department </span>
                                </a>
                            </li>


                            <li class="menu-title">Management</li>

                            <li class="">
                                <a href="https://opaltimecard.com/schedule" class="waves-effect {{ request()->is("schedule") || request()->is("schedule/*") ? "mm active" : "" }}">
                                    <i class="ti-time"></i> <span> Schedule </span>
                                </a>
                            </li>
                            <li class="">
                                <a href="https://opaltimecard.com/assigntask" class="waves-effect {{ request()->is("schedule") || request()->is("schedule/*") ? "mm active" : "" }}">
                                    <i class="ti-time"></i> <span> Assign Task </span>
                                </a>
                            </li>
                            <li class="menu-title">Report</li>
                            <li class="">
                                <a href="https://opaltimecard.com/sheet-report" class="waves-effect {{ request()->is("sheet-report") || request()->is("sheet-report/*") ? "mm active" : "" }}">
                                    <i class="dripicons-to-do"></i> <span> Employee Report </span>
                                </a>
                            </li>

                            {{--<li class="">
                                <a href="http://localhost/ts/timestation/public/check" class="waves-effect {{ request()->is("check") || request()->is("check/*") ? "mm active" : "" }}">
                                    <i class="dripicons-to-do"></i> <span> Attendance Sheet </span>
                                </a>
                            </li>

                            <li class="">
                                <a href="http://localhost/ts/timestation/public/attendance" class="waves-effect {{ request()->is("attendance") || request()->is("attendance/*") ? "mm active" : "" }}">
                                    <i class="ti-calendar"></i> <span> Attendance Logs </span>
                                </a>
                            </li>
                            <li class="">
                                <a href="http://localhost/TimeStation/public/latetime" class="waves-effect {{ request()->is("latetime") || request()->is("latetime/*") ? "mm active" : "" }}">
                                    <i class="dripicons-warning"></i><span> Late Time </span>
                                </a>
                            </li>
                            <li class="">
                                <a href="http://localhost/TimeStation/public/leave" class="waves-effect {{ request()->is("leave") || request()->is("leave/*") ? "mm active" : "" }}">
                                    <i class="dripicons-backspace"></i> <span> Leave </span>
                                </a>
                            </li>
                            <li class="">
                                <a href="http://localhost/TimeStation/public/overtime" class="waves-effect {{ request()->is("overtime") || request()->is("overtime/*") ? "mm active" : "" }}">
                                    <i class="dripicons-alarm"></i> <span> Over Time </span>
                                </a>
                            </li>
                            <li class="menu-title">Tools</li>
                            <li class="">
                                <a href="{{ route("finger_device.index") }}" class="waves-effect {{ request()->is("finger_device") || request()->is("finger_device/*") ? "mm active" : "" }}">
                                    <i class="fas fa-fingerprint"></i> <span> Biometric Device </span>
                                </a>
                            </li>--}}

                        </ul>

                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
