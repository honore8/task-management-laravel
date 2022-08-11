@include('includes.head')

<body class="g-sidenav-show  bg-gray-200">

  @include('includes.side-nav')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
    
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">

      @include('includes.alert')

      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            
            <div class="container my-auto">
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                     
                      <div class="card-body">
                        <p>Edit a Task</p>
                        <form action="{{ route('task.update', ['id' => $task->id])}}" method="POST">
                            @csrf
                            {{method_field('PUT')}}
                        <div class="input-group input-group-outline my-3">
                           
                            <select class="form-control @error('project_id') is-invalid @enderror" name="project_id">
                                <option selected>-- Select Project --</option>
                                @if($projects->count() > 0)
                                    @foreach ($projects as $key => $project)
                                    <option value="{{ $project->id }}" {{$task->project_id == $project->id ? "selected" : ""}}>{{ $project->name }}</option>
                                    @endforeach
                                @endif
                               
                              </select>
                            @error('project_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                        </div>

                          <div class="input-group input-group-outline my-3">
                            <label for="name"></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $task->name }}" placeholder="Task Name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>

                          <div class="input-group input-group-outline my-3">
                            <label for="priority"></label>
                            <input type="number" name="priority" class="form-control @error('priority') is-invalid @enderror" value="{{ $task->priority }}" placeholder="Priority">

                            @error('priority')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Update Task</button>
                          </div>
                          
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            
          </div>
        </div>
        
      </div>
      
    
    </div>
  </main>
  
  

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.2"></script>
  
</body>

</html>