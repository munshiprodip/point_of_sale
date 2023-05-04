@extends('layouts.datatable')
@section('title', 'Dashboard')

@section('content')

                <!-- Responsive Datatable -->
                <div class="card">
                    <h5 class="card-header">Responsive Datatable</h5>
                    <div class="card-datatable table-responsive">
                        <table class="dt-responsive table" id="datatable" >
                        <thead>
                            <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Post</th>
                            <th>City</th>
                            <th>Date</th>
                            <th>Salary</th>
                            <th>Age</th>
                            <th>Experience</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                                <td>sdfd</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Post</th>
                            <th>City</th>
                            <th>Date</th>
                            <th>Salary</th>
                            <th>Age</th>
                            <th>Experience</th>
                            <th>Status</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>
                <!--/ Responsive Datatable --> 
@endsection