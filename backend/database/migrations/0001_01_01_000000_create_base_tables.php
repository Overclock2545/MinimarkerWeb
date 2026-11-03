<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); $table->string('password');
            $table->rememberToken(); $table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); $table->string('token'); $table->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable(); $table->text('user_agent')->nullable();
            $table->longText('payload'); $table->integer('last_activity')->index();
        });
        Schema::create('cache', function (Blueprint $table) { $table->string('key')->primary(); $table->mediumText('value'); $table->integer('expiration'); });
        Schema::create('cache_locks', function (Blueprint $table) { $table->string('key')->primary(); $table->string('owner'); $table->integer('expiration'); });
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); $table->string('queue')->index(); $table->longText('payload');
            $table->unsignedTinyInteger('attempts'); $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at'); $table->unsignedInteger('created_at');
        });
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); $table->string('uuid')->unique(); $table->text('connection'); $table->text('queue');
            $table->longText('payload'); $table->longText('exception'); $table->timestamp('failed_at')->useCurrent();
        });
        Schema::create('categorias', function (Blueprint $table) { $table->id(); $table->string('nombre', 35)->unique(); });
        Schema::create('product', function (Blueprint $table) {
            $table->string('id', 20)->primary(); $table->string('nombre');
            $table->foreignId('categoria_id')->constrained('categorias'); $table->decimal('precio', 8, 2);
            $table->text('descripcion')->nullable(); $table->string('imagen')->nullable();
        });
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('product_id', 20); $table->foreign('product_id')->references('id')->on('product')->cascadeOnDelete();
            $table->unsignedInteger('cantidad')->default(1); $table->timestamps(); $table->unique(['user_id', 'product_id']);
        });
    }
    public function down(): void
    {
        foreach (['carrito_items', 'product', 'categorias', 'failed_jobs', 'jobs', 'cache_locks', 'cache', 'sessions', 'password_reset_tokens', 'users'] as $table) Schema::dropIfExists($table);
    }
};
