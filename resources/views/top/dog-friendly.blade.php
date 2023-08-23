@extends('layouts.html')

@section('content')
@extends('layouts.header')

<style>
#map{
    width: 100%;
    height: 500px;

}
</style>

@include('top.map.map')

<div container class="mx-5">
    <div class="mt-2">
        @include('top.map.select')
    </div>
    <div class="mt-5">
        @include('top.map.selection')
    </div>
</div>
 
<div container>
    <div class="row justify-content-center">
        <div class="col-md-6">

        </div>
    </div>
</div>




@endsection