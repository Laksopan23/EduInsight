@echo off
setlocal enabledelayedexpansion

echo ========================================
echo   EduInsight - Start Development Server
echo ========================================
echo.

:: Check if PHP is available
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed or not in PATH
    pause
    exit /b 1
)

:: Clear caches before starting
echo Clearing caches...
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1

echo.
echo ========================================
echo Starting Laravel Development Server
echo ========================================
echo.
echo Server will be available at: http://localhost:8000
echo.
echo Press Ctrl+C to stop the server
echo.

:: Start the server
php artisan serve

pause
