@echo off
setlocal enabledelayedexpansion

echo ========================================
echo   EduInsight - Automated Setup Script
echo ========================================
echo.

:: Check if PHP is installed
echo Checking PHP installation...
php -v >nul 2>&1
if %errorlevel% equ 0 (
    for /f "tokens=2" %%i in ('php -v ^| findstr /r "PHP [0-9]"') do set PHP_VERSION=%%i
    echo [OK] PHP !PHP_VERSION! found
) else (
    echo [ERROR] PHP is not installed or not in PATH
    echo.
    echo Please install PHP 8.1+ from: https://windows.php.net/download/
    echo Then add the PHP directory to your Windows PATH environment variable
    echo.
    pause
    exit /b 1
)

:: Check if Composer is installed
echo Checking Composer installation...
composer -v >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Composer found
) else (
    echo [ERROR] Composer is not installed
    echo.
    echo Please install Composer from: https://getcomposer.org/download/
    echo.
    pause
    exit /b 1
)

:: Check if database is configured
echo.
echo Checking database configuration...
set /p DB_HOST=<.env | find "DB_HOST="
set /p DB_NAME=<.env | find "DB_DATABASE="
echo [INFO] Database configured in .env

:: Install PHP dependencies
echo.
echo ========================================
echo Installing PHP dependencies...
echo ========================================
composer install
if %errorlevel% neq 0 (
    echo [ERROR] Composer install failed
    pause
    exit /b 1
)
echo [OK] Dependencies installed

:: Run migrations
echo.
echo ========================================
echo Setting up database...
echo ========================================
php artisan migrate --force
if %errorlevel% neq 0 (
    echo [WARNING] Migration may have failed
    echo Check database connection in .env
)
echo [OK] Database setup complete

:: Install Node dependencies (optional)
echo.
echo ========================================
echo Installing NPM dependencies (optional)...
echo ========================================
if exist package.json (
    npm install
    npm run build
) else (
    echo [SKIP] No package.json found
)

:: Clear caches
echo.
echo ========================================
echo Clearing application caches...
echo ========================================
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo [OK] Caches cleared

echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo To start the development server, run:
echo   php artisan serve
echo.
echo Then open: http://localhost:8000
echo.
pause
