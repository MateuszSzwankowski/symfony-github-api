# działanie
każdy request powinien zawierać w headerze token 
> Authorization: token (github token)

[Instrukcja generowania tokenu](https://docs.github.com/en/github/authenticating-to-github/creating-a-personal-access-token)

Wystarczy podstawowy scope, żadne dodatkowe uprawnienia nie są potrzebne. Chodzi tylko o limit requestów, bez uwierzytelniania jest to jedynie 60req/h.

W commandach token jest opcjonalny, jeżeli żaden nie zostanie przekazany to command korzysta z tokenu zapisanego w zmiennych środowiskowych.

# deploy
Projekt nie korzysta z żadnej bazy danych, co upraszcza sprawę. Trzeba jedynie utworzyć na serwerze pliki `.env.local` i `.env.test.local` i nadpisać w nich wrażliwe dane (`APP_SECRET`, `GITHUB_API_TOKEN`). Dodatkowo należy jeszcze zmienić `APP_ENV` na prod w `.env.local`.

# co bym zrobił lepiej/inaczej (gdybym miał więcej czasu)
- docker
- lepsze testy - przede wszystkim unit testy z mockiem do serwisu, w e2e porównywanie zwracanych wartości z tym co api githuba faktycznie zwraca, a nie zapisanymi stałymi
- formatowanie kodu - używałem słabo skonfigurowanego vscode zamiast phpstorma
- github oauth app + logowanie przez githuba + baza danych i konta użytkowników - nie trzeba by przesyłać tokenu z githuba w headerze
- jeżeli api ma być wykorzystywane przez aplikację frontendową, należałoby jeszcze dodać do projektu `nelmio cors bundle`.
