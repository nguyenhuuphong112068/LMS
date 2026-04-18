@extends ('layout.master')

@section('topNAV')
    @include('layout.topNAV')
@endsection

@section('leftNAV')
    @include('layout.leftNAV')
@endsection

@section('mainContent')
    @include('pages.StorageLocation.Shelf.dataTable')
@endsection

@section('model')
    @include('pages.StorageLocation.Shelf.create')
    @include('pages.StorageLocation.Shelf.update')
@endsection
