@extends('layouts.generic')

@section('form')
    <form action="">
        @csrf
        <label for=""></label>
        <input type="file" required multiple >
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