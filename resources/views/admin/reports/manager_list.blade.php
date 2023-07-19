@extends('layouts.admin')


@section('title', 'Eco Bohol - Reports')


@section('content')

<div class="common-background flex-1 p-5">
    List of Managers
</div>


@stop

@section('additional_scripts')
    @include('admin.reports.report_scripts')
@stop