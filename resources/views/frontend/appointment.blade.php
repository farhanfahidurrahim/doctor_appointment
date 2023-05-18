@extends('frontend.layouts.master')
@section('content')

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <div class="bigshop_reg_log_area section_padding_100_50">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">

                        <h5 class="mb-3"></h5>

                        <form action="{{ route('appointment_store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Appointment Date</label>
                                <input type="date" class="form-control" name="appointment_date" id="username"
                                    placeholder="mm/ dd / yyyy">
                            </div>

                            <div class="form-group">
                                <label for="">Select Department & Doctor</label>
                                <select class="form-control show-tick" name="doctor_id" id="doctorfee">
                                    <option selected disabled value="">--Choose Department & Doctor--</option>
                                    @foreach ($departments as $department)
                                        @php
                                            $doctors = DB::table('doctors')
                                                ->where('department_id', $department->id)
                                                ->get();
                                        @endphp
                                        <option>{{ $department->name }}</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">---{{ $doctor->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group">
                            <label for="">Select Doctor</label>
                            <select class="form-control show-tick" name="department_id">
                                <option selected disabled value="">-- Choose Doctor --</option>

                                    <option value=""></option>

                            </select>
                        </div> --}}

                            <div class="form-group">
                                <label for="">Fee</label>
                                <select class="form-control" name="fee" id="fee">

                                </select>
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6">

                    <div class="card">
                        <div class="body">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>App. Date</th>
                                        <th>Doctor</th>
                                        <th>Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @for ($i = 0; Session::has('appointment_details') && $i < count(Session::get('appointment_details')); $i++)
                                        {
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>

                                                @if (Session::has('appointment_details'))
                                                    {{ Session::get('appointment_details')[$i]['appointment_date'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (Session::has('appointment_details'))
                                                    {{ Session::get('appointment_details')[$i]['doctor_name'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (Session::has('appointment_details'))
                                                    {{ Session::get('appointment_details')[$i]['fee'] }}
                                                @endif
                                            </td>
                                            <td class="">
                                                <form class="px-3"
                                                    onclick="return confirm('Are you sure you want to delete?')"
                                                    method="POST" action="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Delete"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        }
                                    @endfor

                                </tbody>
                            </table>
                        </div>


                        <div class="col-12 col-md-10">
                            <div class="card">
                                <div class="body">

                                    <h5 class="mb-3">Patient Information</h5>
                                    <form action="{{ route('appointment_submit') }}" method="post">
                                        @csrf

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Patient Name</label>
                                            <input type="text" class="form-control" name="patient_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Patient Phone</label>
                                            <input type="text" class="form-control" name="patient_phone">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Total Amount</label>
                                            <input type="text" class="form-control" name="total_fee"
                                                value="@if (Session::has('total_appointment_fee')) {{ Session::get('total_appointment_fee') }} @endif" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Paid Amount</label>
                                            <input type="number" class="form-control" name="paid_amount">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        //ajax request : collect fee
        $("#doctorfee").change(function() {
            var id = $(this).val();
            //alert(id);
            $.ajax({
                url: "{{ url('/get-doctor-fee/') }}/" + id,
                type: 'get',
                success: function(data) {
                    $('select[name="fee"]').empty();
                    $.each(data, function(key, data) {
                        $('select[name="fee"]').append('<option value="' + data.fee +
                            '">' + data.fee + '</option>');
                    });
                }
            });
        });
    </script>

@endsection
