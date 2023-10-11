@extends('layouts.app')

@section('content')
    <h1>Add Review for {{ $book->title }}</h1>

    <form method="POST" action="{{ route('books.reviews.store' , $book) }}">

        @csrf
        <div class="mb-4">
            <label>Review</label>
            <textarea name="review" id="review"  required class="input mb-4 {{$errors->has('review') ? 'border-red-500':'' }}" >
                {{ old('review') }}
            </textarea>
            @error('review')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label>Rating</label>
            <select name="rating"  id="rating" required class="input mb-4">
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') === $i ? 'selected':'' }}>{{ $i }}</option>
                @endfor
            </select>
            @error('rating')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn">Add Review</button>
    </form>
@endsection