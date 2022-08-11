
@include('includes.head')
<body class="g-sidenav-show  bg-gray-200">
  @include('includes.side-nav')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">

    </nav>
    <!-- End Navbar -->
    
    <div class="container-fluid py-4">

      @include('includes.alert')

      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <a href="{{ route('task.create') }}" class="btn btn-success">
                Create Task
              </a> 
            </div>
              <div class="col-md-4">
                <select class="form-select" name="projects" aria-label="Default select example">
                       <option value="">Select a Project to view Task(s)</option>
                       @foreach( $projects as $project )
                       <option value="{{ $project->id }}">{{ $project->name }}</option>
                       @endforeach
                </select>
              </div>
          </div>
      </div>
        <div class="row">
          <div class="col-12">
            <div class="card my-4">
            
              <div class="card-body px-0 pb-2">
               
              
                <div class="table-responsive p-0">
                 
                  <table class="table align-items-center mb-0">
                    
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Created</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Updated</th>
                        <th class="text-secondary opacity-7"></th>
                        <th class="text-secondary opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody class="tasks" id="sortable">
                      @forelse ($tasks  as $task)
                      <tr data-task-id="{{ $task->id }}" data-project-id="{{ $task->project ? $task->project->id : '' }}">
                        <td>
                          <div class="d-flex px-2 py-1">
                          
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $task->name }}</h6>
  
                            </div>
                          </div>
                        </td>
  
                        <td>
                         
                          <p class="text-xs font-weight-bold mb-0"> {{ $task->project->name }}</p>
                         
                        </td>
                        
                        <td class="align-middle text-center text-sm">
                          <span class="text-secondary text-xs font-weight-bold">{{ date('M d, Y / H:i:s', strtotime($task->created_at)) }}</span>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-xs font-weight-bold">{{ date('M d, Y / H:i:s', strtotime($task->created_at)) }}</span>
                        </td>
                        <td class="align-middle">
                          <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="text-white font-weight-bold text-xs btn btn-info" data-toggle="tooltip" data-original-title="Edit user">
                            Edit
                          </a> 
                        </td>
                        <td>
                          <form action="{{ route('task.destroy', ['id' => $task->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white font-weight-bold text-xs btn btn-danger">
                               delete
                            </button>
                        </form>
                        </td>
                       
                      </tr>
                      @empty
                     
                        <td class="text-center">There are currently no tasks</td>
                      
                      @endforelse
                     
                  
                    </tbody>
                   
                  </table>
                  {{ $tasks->onEachSide(5)->links() }}
                </div>
                
              </div>
            </div>
          </div>
          
        </div>
      </div>
      
    </div>
  </main>
  
  

  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
 
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.2') }}"></script>
  <script src="{{ asset('assets/js/drag-drop.js?v=3.0.2') }}"></script>
  
    <script>
        $("#sortable").sortable({
            stop: function( event, ui ) {
                var $e        = $(ui.item);
                var $prevItem = $e.prev();
                var $nextItem = $e.next();

                $.ajax({
                    url: "{{ route('task.reaOrderTask') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        task_id: $e.data('task-id'),
                        prev_id: $prevItem ? $prevItem.data('task-id') : null,
                        next_id: $nextItem ? $nextItem.data('task-id') : null
                    } 
                });
            }
        });

        $('[name="projects"]').on('change', function(){
            var $this = $(this);
            
            if( $this.val() ){
                $('.tasks tr').hide();

                $('.tasks tr')
                    .filter( $(`[data-project-id="${$this.val()}"]`) )
                    .show();

                return;
            }

            $('.tasks tr').show();
        });
      
    </script>
</body>

</html>