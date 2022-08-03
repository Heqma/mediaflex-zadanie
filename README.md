# Zadanie 
Stworzenie systemu do zarządzania użytkownikami z zewnętrznym REST api dla aplikacji

### System ma umożliwić:  

- dodawanie nowych użytkowników,  
- dodawanie nowych aplikacji,  
- dodawanie uprawnień do aplikacji konkretnym użytkownikom,  
- pobieranie listy użytkowników,  
- pobieranie listy aplikacji.  

### Użyte narzędzia i technologie:

- Symfony
- Doctrine
- Mysql
- PHP

# Komendy

```
composer install
```
```
symfony server:start
```
# Uprawnienia i role
Relacja ManyToOne, Użytkownik posiada jedną role a rola wielu użytkowników.

## Administrator
- pełny dostęp do zarządzania.
## Moderator
- Zablokowany dostęp do modyfikacji użytkowników za wyjątkiem dostępu do podglądu danego użytkownika.
## Klient
- Brak dostępu do panelu zarządzania.
- Podgląd własnego profilu oraz listy dostępnych aplikacji.

# REST api
Dostęp ogólny, za wyjątkiem metody POST,PUT oraz DELETE

Metoda GET dla wszystkich rekordów.
```
/app/
```
Metoda GET dla pojedynczego rekordu.
```
/app/get/{id}
```
Metoda POST do utworzenia rekordu.
```
/app/post
```
Metoda PUT do edycji rekordu.
```
/app/update/{id}
```
Metoda DELETE do usunięcia rekordu.
```
/app/delete/{id}
```
