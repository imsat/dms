@extends('app')
@push('title', 'Document')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Documents</h1>
        </div>

        <table class="table text-center table-bordered table-sm">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Current Version</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($documents as $document)
                <tr>
                    <td>{{$document?->id}}</td>
                    <td>{{$document?->title}}</td>
                    <td>{{$document?->current_version}}</td>
                    <td>
                        @if($document->document_status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{$documents->links()}}
    </main>
@endsection
