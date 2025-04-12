@extends('layouts.master')

@section('content')
<div class="content">
    <h3>Communication List</h3>
    <a href="{{ route('communication/add/page') }}" class="btn btn-primary">Add New Communication</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($communicationList as $communication)
            <tr>
                <td>{{ $communication->title }}</td>
                <td>{{ $communication->sender }}</td>
                <td>{{ $communication->receiver }}</td>
                <td>
                    <a href="{{ route('communication/profile', $communication->id) }}">View</a>
                    <a href="{{ route('communication/edit', $communication->id) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection