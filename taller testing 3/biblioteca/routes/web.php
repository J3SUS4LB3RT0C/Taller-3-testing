<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibrosController;
use Illuminate\Support\Facades\DB;

Route::get("/", [LibrosController::class, "index"])->name("crud.index");

Route::post("/registrar-libro", [LibrosController::class, "create"])->name("crud.create");
Route::post("/modificar-libro", [LibrosController::class, "update"])->name("crud.update");
Route::get("/eliminar-libro-{id}", [LibrosController::class, "delete"])->name("crud.delete");

Route::get('/buscar', [LibrosController::class, 'buscar'])->name('buscar');