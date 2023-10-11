<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter','');


        $books = Book::when($title , function ($query, $title) {
            return $query->title($title);
        });


        $books = match($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6monthe' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()->withAvgRating()->withReviewsCount(),
        };
       
        
        $cacheKey = 'books:'.$filter. ':'.$title;
        $books = cache()->remember($cacheKey,3600 , fn() => $books->paginate(10));
        return view('books.index',['books' =>$books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $cacheKey = 'book:'.$id;
        
        $book = cache()->remember($cacheKey , 3600 , 
                fn() => Book::with(['reviews' => fn($query) =>$query->latest()])->withAvgRating()->withReviewsCount()->findOrFail($id));
        // $reviews = $book->load('reviews');
       
        return view('books.show' , ['book' => $book]); //Eager Loading
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}