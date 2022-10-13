@extends('emails.layouts.app')
@section('title', 'A tradesperson is interested in your job')

@section('name', $details['user']->name)
@section('phone', $details['company']->business_phone)


@section('company')
    @include('emails.layouts.company', [
        'company' => $details['company'],
    ])
@endsection
