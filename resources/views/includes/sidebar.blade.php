<!DOCTYPE html>
<html>


<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="">Educare</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('student.dashboard') }}" class="sidebar-link">
                        <i class="lni lni-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(Auth::user()->roles->contains('name', 'Admin') || Auth::user()->roles->contains('name', 'Teacher'))
                <li class="sidebar-item">
                    <a href="{{ route('student.display') }}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Students</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->roles->contains('name', 'Admin'))
                <li class="sidebar-item">
                    <a href="{{ route('teacher.display') }}" class="sidebar-link">
                        <i class="lni lni-pencil"></i>
                        <span>Teachers</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->roles->contains('name', 'Admin') || Auth::user()->roles->contains('name', 'Teacher'))
                <li class="sidebar-item">
                    <a href="{{ route('subject.display') }}" class="sidebar-link">
                        <i class="lni lni-book"></i>
                        <span>Subjects</span>
                    </a>
                </li>
                @endif
                <li class="sidebar-item">
                    <a href="{{ route('lecture.display') }}" class="sidebar-link">
                        <i class="lni lni-blackboard"></i>
                        <span>Lectures</span>
                    </a>
                </li>
                @if(Auth::user()->roles->contains('name', 'Admin'))
                <li class="sidebar-item">
                    <a href="{{ route('role.display') }}" class="sidebar-link">
                        <i class="lni lni-star-empty"></i>
                        <span>Roles</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('permission.display') }}" class="sidebar-link">
                        <i class="lni lni-paddle"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('user.display') }}" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Users</span>
                    </a>
                </li>
                @endif
                <li class="sidebar-item">
                    <a href="{{ route('attendance.display') }}" class="sidebar-link">
                        <i class="lni lni-arrow-right-circle"></i>
                        <span>Attendance</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="{{route('logout')}}" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="{{ asset('script.js') }}"></script>
</body>

</html>