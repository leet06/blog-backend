@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')

@section('message')
    <div>
        {{ __($exception->getMessage() ?: 'Forbidden') }}
    </div>
    <div style="margin-top: 15px;">
        <!-- Safe exit form -->
        <form action="{{ route('platform.logout') }}" method="POST">
            @csrf
            <button type="submit" style="background: #e0e0e0; border: 1px solid #a6a6a6; padding: 5px 15px; cursor: pointer; border-radius: 4px;">
                Logout
            </button>
        </form>
    </div>
@endsection
