@extends('layouts.generic')

<?php
$revised_route = '';
$o_format = '';
$c_format = '';
if (url()->full() === route('xdxf-form')) {
    $revised_route = route('xdxf-save');
    $o_format = 'xdxf';
    $c_format = 'dsl';
} else if (url()->full() === route('dsl-form')) {
    $revised_route = route('dsl-save');
    $o_format = 'dsl';
    $c_format = 'xdxf';
}
?>

@section('form')
    <form action="{{ $revised_route }}" method="POST" enctype="multipart/form-data">

        @csrf

        <label for="{{ $o_format }}"></label>
        <input type="file" required name="{{ $o_format }}" id="{{ $o_format }}">
        @if ($o_format === 'dsl')
            <label for="abrv">Add abbreviations file</label>
            <input type="file" name="abrv" id="abrv">
        @endif

        <label for="format">Convert to:</label>
        <select name="format" id="format">
            <option value="dic">dic</option>
            <option value="{{ $c_format }}">{{ $c_format }}</option>
        </select>

        <button>Submit</button>
    </form>
@endsection