# vsm
Virtual Scrum Meetings


# Instalacja
1. Skopiować zawartość niniejszego katalogu na serwer. Należy nie zapomnieć o ukrytych
   plikach (np. .htaccess).

2. Wgrać schemat bazy danych z pliku db/vsm_standalone_database.sql.

   Polecana metoda uzyskania konta administratora:
   Zarejestrować użytkownika, a następnie ręcznie podnieść poziom uprawnień
   (tabela 'users', kolumna 'level') na administracyjne (wartość '2').

3. Dostosować pliki konfiguracyjne w katalogu app/Config:
   * core.php: ustawić zmienną 'debug' na 0 (linia 36),
               ustawić sól (linie 227 i 232).
   * database.php: podać dane do bazy.
   * email.php: podać dane do serwera pocztowego.

4. Utworzyć katalog app/tmp z uprawnieniami 0777.
