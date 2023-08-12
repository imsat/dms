@extends('app')
@push('title', 'Document')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Show Document Difference</h1>
            <a href="{{route('changes.index')}}" class="btn btn-sm btn-warning">Back</a>
        </div>
        <h5>Title: {{$diff?->title}}</h5>

        <table>
            <tr>
                <th style="width: 10%">Body Content</th>
                <td>{!! $bodyContentDiff !!}</td>
            </tr>
            <tr style="width: 10%">
                <th>Tags Content</th>
                <td>{!! $tagsContentDiff !!}</td>
            </tr>
        </table>
    </main>
@endsection
