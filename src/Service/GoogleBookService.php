<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\BookAuthor;
use App\Repository\BookAuthorRepository;

class GoogleBookService
{
    public function __construct(private readonly BookAuthorRepository $bookAuthorRepository)
    {
    }

    public function getByISBN(string $isbn, string $apiKey): ?Book
    {
        $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $isbn . "&key=" . $apiKey; // Remplacez VOTRE_CLE_API par votre clé d'API
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        if ($data['totalItems'] > 0) {
            $volume = $data['items'][0];
            $bookFromData = $volume['volumeInfo'];
            $book = new Book();
            $book->setTitle($bookFromData['title']);
            $book->setBarcode($isbn);
            $bookFromData['authors'] = $bookFromData['authors'] ?? [];

            foreach ($bookFromData['authors'] as $author) {
                $auth = explode(' ', $author);
                $firstname = array_shift($auth);
                $lastname = implode(' ', $auth);
                $author = $this->bookAuthorRepository->findOneBy([
                    'firstname' => $firstname,
                    'lastname'  => $lastname
                ]);

                if (!$author) {
                    $author = new BookAuthor();
                    $author->setFirstname($firstname);
                    $author->setLastname($lastname);
                }

                $author->addBook($book);
            }

            $book->setDescription($bookFromData['description'] ?? null);
            $book->setMoreInformation($volume['selfLink'] ?? null);
            $book->setCover($bookFromData['imageLinks']['thumbnail'] ?? null);

            return $book;
        }

        return null;
    }
}