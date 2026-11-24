$ErrorActionPreference = 'Stop'
$demoDatabase = Join-Path $PSScriptRoot 'storage/app/b2-demostracion.sqlite'
if (-not (Test-Path -LiteralPath $demoDatabase -PathType Leaf)) {
    throw "No se encontró la base de demostración: $demoDatabase"
}
Set-Location -LiteralPath $PSScriptRoot
$env:DB_CONNECTION = 'sqlite'
$env:DB_DATABASE = $demoDatabase
$env:SESSION_DRIVER = 'file'
$env:CACHE_STORE = 'file'
$env:AUTH_GUARD = 'b2'
php artisan config:clear
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }
php artisan serve --host=127.0.0.1 --port=8000
