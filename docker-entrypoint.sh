#!/bin/bash
DB_HOST=${DB_HOST:-"htdocs-database-1"}
DB_PORT=${DB_PORT:-"5432"}
DB_USER=${DB_USER:-"app"}
DB_PASSWORD=${DB_PASSWORD:-"apppass"}
DB_NAME=${DB_NAME:-"regonApi"}

echo "Przed migracją"
set -e

# Oczekiwanie na dostępność bazy danych
echo "Czekam na dostępność bazy danych..."

while ! pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME -t 1; do
    sleep 1
done

echo "Baza danych jest dostępna, kontynuuję migrację."

# Uruchom migracje Doctrine
php bin/console doctrine:migrations:migrate

# Uruchom aplikację
exec "$@"
