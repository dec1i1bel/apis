@extends('layouts.app')
@section('title', 'Главная || APIs')

@section('header')
    @parent
@endsection

@section('content')

<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
    <p>{{ $data }}</p>
</div>
  
@endsection

@section('footer')
    @parent
@endsection