@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <h1 class="display-3">Companies</h1>
                    <a href="{{ route('companies.create')}}" class="btn btn-success" style="float: right; padding: 10px 50px 10px 50px;">Add</a>
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>No</td>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td colspan = 2>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $index => $company)
                        <tr>
                            <td>{{ $index + $companies->firstItem() }}</td>
                            <td>{{$company->id}}</td>
                            <td>{{$company->name}}</td>
                            <td>{{$company->email}}</td>
                            <td>
                                <a href="{{ route('companies.show',$company->id)}}" class="btn btn-warning">Show</a>
                            </td>
                            <td>
                                <a href="{{ route('companies.edit',$company->id)}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('companies.destroy', $company->id)}}" method="post">
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
        </div>
            {{ $companies->links() }}
    </div>
@endsection
