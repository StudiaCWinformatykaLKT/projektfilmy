# projektfilmy
# Projekt **Pipsil** i **PSBD**
## Semestr 4, Rok 2025
---
## Wymagania

* Laravel Framework 9.52.20
* PHP 8.0.30
* Composer version 2.8.6

## Instalacja

1. **Otwórz terminal (w PHPStorm Alt+F12).**
2.  **Sklonuj repozytorium:**

    ```bash
    git clone [https://github.com/your-username/projektfilmy.git]
    cd projektfilmy/filmy
    ```

    **Lub dodaj zmiany z `main` do swojego brancha:**

    ```bash
    git pull origin main
    ```

3.  **Skopiuj i uzupełnij plik `.env`:**

    ```bash
    cp .env.example .env
    ```

    Następnie wstaw klucz API w odpowiednie miejsce w pliku `.env`.

4.  **Zainstaluj zależności:**

    ```bash
    composer install
    ```

5.  **Wygeneruj klucz aplikacji (podobno zalecane dla bezpieczeństwa):**

    ```bash
    php artisan key:generate
    ```

6.  **Skonfiguruj bazę danych (jeśli jest już dostępna):**

    * Skonfiguruj dane bazy danych w pliku `.env`.
(proszę o uzupełnienie gdy baza powstanie)
    * Uruchom migracje bazy danych:

        ```bash
        php artisan migrate
        ```

7.  **Uruchom serwer:**

    ```bash
    php artisan serve
    ```

    * Aplikacja będzie dostępna pod adresem: `http://127.0.0.1:8000`.
    * Przykładowy film (zależny od numeru) jest na razie pod adresem: `http://127.0.0.1:8000/movie/630`.

## Praktyczne informacje dotyczące Git i GitHub

* **Alt+F12** - Otwiera terminal w PHPStorm.

### Sprawdzanie gdzie jesteście, tworzenie nowych branchy I poruszanie się:

* `git branch` - Wyświetla listę lokalnych branchy (aktualny branch oznaczony jest gwiazdką `*`).
* `git branch -a` - Wyświetla listę wszystkich branchy (lokalnych i zdalnych).
* `git checkout wasz_branch` - Przełącza na określony branch.
* `git checkout -b nowy_branch` - Tworzy nowy branch z tego na którym jesteście i przełącza na niego.

### Najważniejsze do codziennego użytkowania

* `git pull origin main` - Aktualizuje lokalny branch z `main` (róbcie to jakoś regularnie).
* `git add .` - Dodaje wszystkie zmienione pliki do poczekalni, żeby można było zrobić z nich commita. Można zamiast kropki odnieść się do konkretnych plików
* `git commit -m "Opis commita"` - Tworzy commit z opisem zmian.
* `git push origin wasz_branch` - Wysyła zmiany na zdalny branch na GitHubie.

### Zasady tworzenia opisów commitów

* Opis commita powinien być zwięzły i informacyjny.
* Zalecany format: "If applied, this commit will <your subject line here>". np. Add database

### Wizualizacja historii Git w PHPStorm

* **Alt+9** - Otwiera okno "Version Control" w PHPStorm, takie narysowane drzewko ze strukturą naszego repo, gdzie możecie widzieć swoje commity i się po nich poruszać. Widać tu opisy commitów, więc weźcie to pod uwagę gdy je robicie


### Mergowanie branchy
*Robimy to tylko wtedy gdy jesteśmy pewni, że kod działa

1.  Upewnij się, że Twój branch jest aktualny z `main`: `git pull origin main`.
2.  Przełącz na `main`: `git checkout main`.
3.  Zmerguj zmiany z Twojego brancha: `git merge wasz_branch`.
4.  Wyślij zmiany na GitHub: `git push origin main`.


### Inne informacje organizacyjne

* Nie myślcie o branchach jako o swoich miejscach ale raczej alternatywnych wersjach wspólnego projektu.
* Folder `NotCode` służy do przechowywania wszystkich dodatkowych informacji, dokumentacji i innych materiałów (np. dla Tomka).
* Jeśli nie chcecie, żeby coś z tego folderu było śledzone przez Git, dodajcie to do `.gitignore` (np. plik `NotCode/tajemnicze_sprawy_tomka.php` lub folder`NotCode/tajemnice_tomka/`).

### Czyszczenie cache i autoload w Laravel (przydatne w razie problemów)

* `php artisan config:clear` - Usuwa zapisane ustawienia konfiguracji z cache. Może być przydatne, gdy zmieniasz pliki konfiguracyjne.
* `php artisan cache:clear` - Czyści ogólny cache aplikacji, co może pomóc w usunięciu nieaktualnych danych z pamięci podręcznej.
* `php artisan route:clear` - Usuwa cache routów. Może być użyteczne, gdy zmieniasz pliki tras (routes).
* `php artisan view:clear` - Czyści cache widoków Blade. Przydatne, gdy edytujesz pliki widoków i chcesz upewnić się, że zmiany są widoczne.
* `composer dump-autoload` - Odświeża autoloading klas, aby upewnić się, że wszystkie zmiany w przestrzeni nazw i klasach są prawidłowo zarejestrowane.


Proszę o stosowanie się do tych zasad, aby ułatwić współpracę.

