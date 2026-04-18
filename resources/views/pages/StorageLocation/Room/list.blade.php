@extends ('layout.master')

@section('topNAV')
    @include('layout.topNAV')
@endsection

@section('leftNAV')
    @include('layout.leftNAV')
@endsection

@section('mainContent')
    @include('pages.StorageLocation.Room.dataTable')
@endsection

@section('model')
    @include('pages.StorageLocation.Room.create')
    @include('pages.StorageLocation.Room.update')
@endsection
