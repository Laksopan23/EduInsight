@extends('layouts.master')

@section('content')
<div class="content">
    <h3>Add New Communication</h3>
    <form method="POST" action="{{ route('communication/add/save') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="sender">Sender</label>
            <input type="text" name="sender" id="sender" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="receiver">Receiver</label>
            <input type="text" name="receiver" id="receiver" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection