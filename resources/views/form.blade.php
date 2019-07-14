@extends('layouts.generic')

@section('form')
    <form action="/xdxf" method="POST" enctype="multipart/form-data">

        @csrf

        <label for="xdxf"></label>
        <input type="file" required multiple name="xdxf" id="xdxf">

        <label for="format">Convert to:</label>
        <select name="format" id="format">
            <option value="xdxf">xdxf</option>
            <option value="dic">dic</option>
            <option value="pbi" disabled>pbi</option>
            <option value="tei" disabled>tei</option>
        </select>

        <button>Submit</button>
    </form>
@endsection