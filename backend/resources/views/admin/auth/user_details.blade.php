@extends('admin.main.main')

@section('admin-content')
    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert" id="success-message">
            {{ Session::get('success') }}
        </div>
    @endif
    <!-- User Details Section -->
    <div class="row mt-5">
        <div class="d-flex justify-content-between">
            <h6>User Details</h6>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table ">
            <thead class="table-color">
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-data">
                @foreach ($userDetail as $user)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_no }}</td>

                        <td>
                            <a href="">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modals for Updating User Status -->
    @foreach ($userDetail as $user)
        <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update User Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('update-user-status') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="user_status" value="De-Active"
                                    {{ $user->status == 'De-Active' ? 'checked' : '' }}>
                                <label class="form-check-label">De-Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="user_status" value="Active"
                                    {{ $user->status == 'Active' ? 'checked' : '' }}>
                                <label class="form-check-label">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center">
              <h6>Pick Objectives</h6>
              <p class="in-progress"><span class="dot">•</span>In Progress</p>
            </div>
      
            <div class="pick-objective">
              <div class="d-flex">
                <div class="col-lg-7">
                  <p># of Picks</p>
                </div>
                <div class="col-lg-5">
                  <p>8/25</p>
                </div>
              </div>
            </div>
          </div> --}}

   
    <!-- jQuery to handle AJAX call and fadeout success/error messages -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        setTimeout(function() {
            $('#success-message').fadeOut('fast');
        }, 4000);
        setTimeout(function() {
            $('#error-message').fadeOut('fast');
        }, 4000);
    </script>
@endsection
