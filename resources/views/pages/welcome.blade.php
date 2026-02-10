@extends('layouts.app')

@section('title')
    AMDK Santri
@endsection

@section('content')
    @include('components.banner')
    @include('components.pengolahan')
    @include('components.detail')
    @include('components.contact')
@endsection
