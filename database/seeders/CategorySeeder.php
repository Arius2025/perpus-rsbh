<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Book::$categories;

        foreach ($categories as $catName) {
            \App\Models\Category::firstOrCreate(['name' => $catName]);
        }

        // Migrate existing books
        $books = \App\Models\Book::whereNull('category_id')->get();
        foreach ($books as $book) {
            $category = \App\Models\Category::where('name', $book->category)->first();
            if ($category) {
                $book->update(['category_id' => $category->id]);
            } else {
                // If not found, map to 'Lainnya' if exists or first category
                $lainnya = \App\Models\Category::where('name', 'Lainnya')->first();
                if ($lainnya) {
                    $book->update(['category_id' => $lainnya->id]);
                }
            }
        }
    }
}
