@extends('frontend.layouts.master')
@section('content')

    <div class="container">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <br/>
                <hr>
            <ul class="breadcrumb">
                <h2><a href="" class="btn btn-xs btn-link btn-toggle-fullwidth"></a>Total Doctors: {{App\Models\Doctor::count()}}
                </h2>
            </ul>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All Doctor</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Phone</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->department->name }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>{{ $row->fee }}</td>
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

@endsection

