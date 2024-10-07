<?php

namespace Tests\Unit;

use App\Http\Requests\BookStoreRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreBookRequestTest extends TestCase
{
    public function test_it_validates_required_fields()
    {
        $request = new BookStoreRequest;

        $rules = $request->rules();

        $validator = Validator::make([], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->messages());
    }

    public function test_it_validates_field_types()
    {
        $data = [
            'title' => 123,
            'publisher' => 456,
            'author' => 789,
            'genre' => null,
            'publication' => 'invalid-date',
            'words' => 'not-a-number',
            'price' => 'not-a-number',
        ];

        $request = new BookStoreRequest;

        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('title', $validator->errors()->messages());
        $this->assertArrayHasKey('publication', $validator->errors()->messages());
    }
}
