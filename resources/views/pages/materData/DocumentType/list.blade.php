@extends ('layout.master')

@section('topNAV')
    @include('layout.topNAV')
@endsection

@section('leftNAV')
    @include('layout.leftNAV')
@endsection

@section('mainContent')
    @include('pages.materData.DocumentType.dataTable')
@endsection

@section('model')
    @include('pages.materData.DocumentType.create')
    @include('pages.materData.DocumentType.update')
@endsection
