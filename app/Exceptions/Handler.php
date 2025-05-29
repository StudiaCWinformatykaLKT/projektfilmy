<?php


// Plik projektu wczytuje wszystko z BD problem z konfiguracja wstepna, aby wychwicic błąd przed ładowaniem widoku

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use PDOException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException) {
            if (in_array($exception->getCode(), [2002, 1049, 1045, 1044])) {
                // 2002 - brak połączenia z serwerem
                // 1049 - nieznana baza danych
                // 1045 - zły użytkownik/hasło
                // 1044 - brak uprawnień do bazy
                return response()->view('errors.db', [], 500);
            }
        }

        // Obsługa PDOException (np. nieprawidłowe dane połączenia)
        if ($exception instanceof PDOException) {
            if (in_array($exception->getCode(), [2002, 1049, 1045, 1044])) {
                return response()->view('errors.db', [], 500);
            }
        }

        return parent::render($request, $exception);
    }
}