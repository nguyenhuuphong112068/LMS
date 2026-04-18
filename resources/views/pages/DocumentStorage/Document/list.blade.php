@extends('layout.master')
@section('mainContent')
    @include('pages.DocumentStorage.Document.dataTable')
    @include('pages.DocumentStorage.Document.create')
    @include('pages.DocumentStorage.Document.update')
@endsection
