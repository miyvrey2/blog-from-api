<?php

use App\Models\Author;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->string('username')->after('name')->nullable();
            $table->string('email')->after('username');
            $table->string('company')->after('email')->nullable();
        });

        $authors = Author::where('email', '=', '')->get();

        foreach($authors as $author) {
            $author->email = Str::slug($author->name) . '@email.nl';
            $author->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn(['username', 'email', 'company']);
        });
    }
};
