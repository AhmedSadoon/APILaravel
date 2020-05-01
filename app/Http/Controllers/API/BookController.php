<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Book;
use Illuminate\Support\Facades\Validator;


class BookController extends BaseController
{
//عرض كل الكتب
    public function index(){

        $books=Book::all();
        return $this->sendResponse($books->toArray(),'Books read successfuly');
    }

    //خزن الكتب
    public function store(Request $request){
        # code...
        $input=$request->all();

        $validator=Validator::make($input,
        [
            'name'=>'required',
            'details'=>'required'
        ]

    );

    if ($validator->fails()) {
        # code...
        return $this->sendErorr('error validation',$validator->errors());
    }

    $book= Book::create($input);
    return $this->sendResponse($book->toArray(),'Book created successfuly');

    }

//show one book
    public function show($id){
        # code...

        $book= Book::find($id);


    if (is_null($book)) {
        # code...
        return $this->sendErorr('book not found');
    }

    return $this->sendResponse($book->toArray(),'Book read successfuly');

    }


//update book
    public function update(Request $request,Book $book){

        $input=$request->all();

        $validator=Validator::make($input,
        [
            'name'=>'required',
            'details'=>'required'
        ]);

    if ($validator->fails()) {
        # code...
        return $this->sendErorr('error validation',$validator->errors());
    }

    $book->name= $input['name'];
    $book->details= $input['details'];

    $book->save();

    return $this->sendResponse($book->toArray(),'Book updated successfuly');

    }

    //delete book

    public function destroy(Book $book){

    $book->delete();
    return $this->sendResponse($book->toArray(),'Book deleted successfuly');

    }






}




