<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[OA\Info(
    version: '1.0',
    description: 'An API of books',
    title: 'Book API',
)]
class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {}

    #[OA\Get(
        path: '/api/books',
        summary: 'Get list of all books',
        tags: ['Books'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
            ),
        ]
    )]
    public function index(Request $request): JsonResource
    {
        return BookResource::collection(
            $this->bookService->getPaginatedBooks(
                $request->query('per_page', config('app.per_page'))
            )
        );
    }

    #[OA\Post(
        path: '/api/books',
        summary: 'Create a new book',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'publisher', 'author', 'genre', 'publication', 'words', 'price'],
                properties: [
                    new OA\Property(property: 'title', description: 'Title of the book', type: 'string'),
                    new OA\Property(property: 'publisher', description: 'Publisher of the book', type: 'string'),
                    new OA\Property(property: 'author', description: 'Author of the book', type: 'string'),
                    new OA\Property(property: 'genre', description: 'Genre of the book', type: 'string'),
                    new OA\Property(property: 'publication', description: 'Publication date', type: 'string', format: 'date'),
                    new OA\Property(property: 'words', description: 'Number of words', type: 'integer'),
                    new OA\Property(property: 'price', description: 'Price in USD', type: 'number', format: 'float'),
                ]
            )
        ),
        tags: ['Books'],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: 'Book created successfully', content: new OA\JsonContent(ref: '#/components/schemas/Book')),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error'),
        ]
    )]
    public function store(BookStoreRequest $request): JsonResponse
    {
        return BookResource::make(
            $this->bookService->createBook(
                $request->validated()
            )
        )->response()->setStatusCode(Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: '/api/books/{id}',
        summary: 'Get a book by ID',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(ref: '#/components/schemas/Book')
            ),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Book not found'),
        ]
    )]
    public function show(int $id): JsonResource
    {
        return BookResource::make(
            $this->bookService->getBookById($id)
        );
    }

    #[OA\Patch(
        path: '/api/books/{id}',
        summary: 'Update a book',
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                ref: '#/components/schemas/Book'
            )
        ),
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Book updated successfully'),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Book not found'),
        ]
    )]
    public function update(BookUpdateRequest $request, int $id): JsonResource
    {
        return BookResource::make(
            $this->bookService->updateBook(
                $this->bookService->getBookById($id),
                $request->validated()
            )
        );
    }

    #[OA\Delete(
        path: '/api/books/{id}',
        summary: 'Delete a book',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: Response::HTTP_NO_CONTENT, description: 'Book deleted successfully'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Book not found'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->bookService->deleteBook(
            $this->bookService->getBookById($id)
        );

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
