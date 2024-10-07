<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Book",
    required: ["title", "publisher", "author", "genre", "publication", "words", "price"],
    properties: [
        new OA\Property(property: "id", type: "integer", readOnly: true),
        new OA\Property(property: "title", type: "string"),
        new OA\Property(property: "publisher", type: "string"),
        new OA\Property(property: "author", type: "string"),
        new OA\Property(property: "genre", type: "string"),
        new OA\Property(property: "publication", type: "string", format: "date"),
        new OA\Property(property: "words", type: "integer"),
        new OA\Property(property: "price", type: "number", format: "decimal"),
    ],
    type: "object"
)]
class BookSchema
{
}
