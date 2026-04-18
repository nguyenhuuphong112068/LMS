@extends ('layout.master')

@section('topNAV')
    @include('layout.topNAV')
@endsection

@section('leftNAV')
    @include('layout.leftNAV')
@endsection

@section('mainContent')
    @include('pages.StorageLocation.Location.dataTable')
@endsection

@section('model')
    @include('pages.StorageLocation.Location.create')
    @include('pages.StorageLocation.Location.update')
@endsection
