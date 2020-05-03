@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="col-sm-12">
                <div>
                    <h1 class="display-3">Employees</h1>
                    <a href="{{ route('employees.create')}}" class="btn btn-success" style="float: right; padding: 10px 50px 10px 50px;">Add</a>
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>No</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Company</td>
                        <td colspan = 2>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $index => $employee)
                        <tr>
                            <td>{{ $index + $employees->firstItem() }}</td>
                            <td>{{$employee->first_name}}</td>
                            <td>{{$employee->last_name}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>{{$employee->company->name}}</td>
                            <td>
                                <a href="{{ route('employees.show',$employee->id)}}" class="btn btn-warning">Show</a>
                            </td>
                            <td>
                                <a href="{{ route('employees.edit',$employee->id)}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('employees.destroy', $employee->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                </div>
            </div>
                {{ $employees->links() }}
        </div>
    </div>
@endsection
