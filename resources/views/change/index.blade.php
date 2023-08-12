@extends('app')
@push('title', 'Document')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Document Difference</h1>
        </div>

        <table class="table text-center table-bordered table-sm">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($changes as $change)
                <tr>
                    <td>{{$change?->id}}</td>
                    <td>{{$change?->document?->title}}</td>
                    <td>
                        <a href="{{route('changes.show', $change->id)}}" class="btn btn-primary btn-sm">Show</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{$changes->links()}}
    </main>
@endsection
