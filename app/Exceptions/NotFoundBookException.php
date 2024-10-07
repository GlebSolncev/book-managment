<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotFoundBookException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            'error' => 'Book not found',
        ], Response::HTTP_NOT_FOUND);
    }
}
