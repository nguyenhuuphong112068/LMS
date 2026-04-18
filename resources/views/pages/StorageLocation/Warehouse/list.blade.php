@extends ('layout.master')

@section('topNAV')
    @include('layout.topNAV')
@endsection

@section('leftNAV')
    @include('layout.leftNAV')
@endsection

@section('mainContent')
    @include('pages.StorageLocation.Warehouse.dataTable')
@endsection

@section('model')
    @include('pages.StorageLocation.Warehouse.create')
    @include('pages.StorageLocation.Warehouse.update')
@endsection
