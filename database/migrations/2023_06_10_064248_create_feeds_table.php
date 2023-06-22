<?php

use App\Models\Collector;
use App\Models\Source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            // $table->string('collector_identifier')->nullable(); // nullable because I can't control what the collector does
            $table->string('title');
            $table->string('slug')->unique(); // Uses Sluggable trait
            $table->text('description');
            $table->text('url'); // Using text because of data inconsistense from collectors
            $table->text('image_url'); // Using text because of data inconsistense from collectors
            $table->integer('views')->default(0);
            $table->foreignIdFor(Source::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Collector::class)->constrained()->onDelete('cascade');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
