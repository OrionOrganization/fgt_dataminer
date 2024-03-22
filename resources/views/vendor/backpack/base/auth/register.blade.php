@extends('errors.layout')

@php
  $error_number = 404;
@endphp

@section('title')
  Page not found.
@endsection

@section('description')
  @php
    $default_error_message = "Por favor <a href='javascript:history.back()''>volte</a> à página anterior</a>.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?e($exception->getMessage()):$default_error_message): $default_error_message !!}
@endsection
