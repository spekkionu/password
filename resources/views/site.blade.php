@extends('layouts.app')

@section('content')
    <site :site_id="{{ $site->id }}"></site>
@endsection
