<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function addBookCanBeAddedToLibrary() {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title'=>'Things',
            'author'=>'David',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function titleRequired() {
        $response = $this->post('/books', [
            'title'=>'',
            'author'=>'David',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function authorRequired() {
        $response = $this->post('/books', [
            'title'=>'Temi loluwa',
            'author'=>'',
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function bookCanBeUpdated() {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title'=>'Things',
            'author'=>'David',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'new Title',
            'author' => 'Olaoye',
        ]);

        $this->assertEquals('new Title', Book::first()->title);
        $this->assertEquals('Olaoye', Book::first()->author);
    }
}
