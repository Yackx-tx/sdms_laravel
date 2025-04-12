@extends('layouts.app')
@include('layouts.topbar')
@section('content')
<div class="container" style="margin-top:80px;">
    <div class="row">
        <div class="card">
            <div class="card-header shadow-sm">
                <h1 class="text-primary">Edit Attendance</h1>
                <button type="button">
                    <a href="{{ route('attendance.index')  }}" class="text-nowrap">Back to Attendance</a>
                </button>
            </div>

            <div class="card-body">

            </div>
        </div>
    </div>
</div>

@endsection
