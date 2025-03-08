@extends('admin.main.main')

@section('admin-content')
    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert" id="success-message">
            {{ Session::get('success') }}
        </div>
    @endif
    <!-- Error Message -->
    @if (session('fail'))
        <div class="alert alert-danger" id="error-message">
            {{ session('fail') }}
        </div>
    @endif

    {{-- <div class="row">

        <div class="col-2">
            <a href="{{ url('dashboard') }}" class="btn-submit ml-3 mt-4" style="text-decoration: none; padding: 4px 14px;">
                <i class="fa-solid fa-left-long"></i>
            </a>
        </div>
        <div class="col-1">
            <label class="mt-4"><b>Filters :</b></label>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label for="vendor_name"><b>Vendor Name</b></label>
                <input type="text" class="form-control" id="vendor_name" placeholder="search by vendor name">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="gstin"><b>GSTIN</b></label>
                <input type="text" class="form-control" id="gstin" placeholder="search by GSTIN number">
            </div>
        </div>
        <div class="col-3">
            <!--<label for="gstin"><b>Filter</b></label>-->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="pending" value="Active" checked>
                <label class="form-check-label" for="exampleRadios1">
                    <b>Active Entries</b>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="approved" value="De-Active">
                <label class="form-check-label" for="exampleRadios2">
                    <b>De-Active Entries</b>
                </label>
            </div>
            <div class="form-check disabled">
                <input class="form-check-input" type="radio" name="exampleRadios" id="all" value="all">
                <label class="form-check-label" for="exampleRadios3">
                    <b>All Entries</b>
                </label>
            </div>
        </div>
    </div> --}}

    <div class="container mb-4 mt-3">
        <div class="row mt-4">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <!-- Table Displaying Users Data -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="myTable"
                                style="background-color: #333333; color: #ffffff;">
                                <thead style="background-color: rgba(84, 0, 123, 0.916); color: white;">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">No Of Listing</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="vendor-data">
                                    <?php
                                    $i = 1;
                                    ?>
                                    @foreach ($userDetail as $item)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('Y-m-d') }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['email'] }}</td>
                                            <td>{{ $item['phone_number'] }}</td>
                                            <td>{{ $item['total_sales'] }}</td>
                                            <td>
                                                @if ($item->status == 'Active')
                                                    <a href="" class="btn-submit" data-toggle="modal"
                                                        data-target="#updateModal{{ $item->id }}">
                                                        <b>{{ $item->status }}</b>
                                                    </a>
                                                @elseif($item->status == 'De-Active')
                                                    <a href="" class="btn-submit btn-pending" data-toggle="modal"
                                                        data-target="#updateModal{{ $item->id }}">
                                                        <b>{{ $item->status }}</b>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('edit-user-detail/' . $item->id) }}"
                                                    class="btn-submit"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals for Updating User Status -->
    @foreach ($userDetail as $user)
        <!-- Looping through users -->
        <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update User Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('update-user-status') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="user_status" id="inlineRadio1"
                                    value="De-Active" {{ $user->status == 'De-Active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inlineRadio1">De-Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="user_status" id="inlineRadio2"
                                    value="Active" {{ $user->status == 'Active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inlineRadio2">Active</label>
                            </div>

                            <button type="submit" class="btn-submit mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- jQuery to handle AJAX call and fadeout success/error messages -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        // Fade out success and error messages after 4 seconds
        setTimeout(function() {
            $('#success-message').fadeOut('fast')
        }, 4000);

        setTimeout(function() {
            $('#error-message').fadeOut('fast')
        }, 4000);
    </script>
    <style>
        /* Style for the tbody section */
        #vendor-data {
            background-color: #230bde;  /* Dark gray background for tbody */
        }
    
        /* Alternating row colors */
        #vendor-data tr:nth-child(even) {
            background-color: #422281;  /* Darker gray for even rows */
        }
    
        #vendor-data tr:nth-child(odd) {
            background-color: #ffffff;  /* Slightly lighter gray for odd rows */
        }
    
        /* Hover effect for rows */
        #vendor-data tr:hover {
            background-color: #3b2bb8;  /* Darker shade on hover */
        }
    </style>
@endsection
