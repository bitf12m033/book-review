@extends('layouts.app')

@section('content')
    <h1>Add Review for {{ $book->title }}</h1>

    <form method="POST" action="{{ route('books.reviews.store' , $book) }}">

        @csrf

        <label>Review</label>
        <textarea name="review" id="review" required class="input mb-4">

        </textarea>
        <label>Rating</label>
        <select name="rating"  id="rating" required class="input mb-4">
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        <button type="submit" class="btn">Add Review</button>
    </form>
@endsection