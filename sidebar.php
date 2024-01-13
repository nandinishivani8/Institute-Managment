<ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center bg-gradient-primary  justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="icon.png" style="width:auto;height:150px; border-radius:100%;">
    </div>
    <div class="sidebar-brand-text mx-3">NS_Institute</div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item active">
    <a class="nav-link" href="home.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Course
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true"
      aria-controls="collapseBootstrap">
      <i class="fas fa-chalkboard"></i>
      <span>Manage Course</span>
    </a>
    <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Course</h6>
        <a class="collapse-item" href="class.php">Create Course</a>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Teachers
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapassests"
      aria-expanded="true" aria-controls="collapseBootstrapassests">
      <i class="fas fa-chalkboard-teacher"></i>
      <span>Manage Teachers</span>
    </a>
    <div id="collapseBootstrapassests" class="collapse" aria-labelledby="headingBootstrap"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Class Teachers</h6>
        <a class="collapse-item" href="CreateTeacher.php">Create Class Teachers</a>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Students
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2" aria-expanded="true"
      aria-controls="collapseBootstrap2">
      <i class="fas fa-user-graduate"></i>
      <span>Manage Students</span>
    </a>
    <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Students</h6>
        <a class="collapse-item" href="CreateStu.php">Create Students</a>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Attendance
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
      aria-expanded="true" aria-controls="collapseBootstrapcon">
      <i class="fa fa-calendar-alt"></i>
      <span>Manage Attendance</span>
    </a>
    <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Manage Attendance</h6>
        <a class="collapse-item" href="markattendance.php">Take Attendance</a>
        <a class="collapse-item" href="viewattendance.php">View Class Attendance</a>
        <a class="collapse-item" href="viewStudentAttendance.php">View Student Attendance</a>
        <a class="collapse-item" href="downloadRecord.php">Today's Report (xls)</a>
      </div>
    </div>
  </li>
  <hr class="sidebar-divider">
</ul>