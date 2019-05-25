@extends('layouts.generic')

@section('form')
    <form action="/xdxf" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="xdxf"></label>
        <input type="file" required multiple name="xdxf" id="xdxf">
        <label for="format">Convert to:</label>
        <select name="format" id="format">
            <option value="pbi">pbi</option>
            <option value="dic">dic</option>
            <option value="xdxf">xdxf</option>
            <option value="tei">tei</option>
        </select>
        <button>Submit</button>
    </form>
@endsection