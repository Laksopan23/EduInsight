# EduInsight - PowerShell Setup Script
# Run: powershell -ExecutionPolicy Bypass -File setup.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  EduInsight - Setup Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check PHP
Write-Host "Checking PHP installation..." -ForegroundColor Yellow
$phpCheck = & php -v 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "[OK] PHP is installed" -ForegroundColor Green
    Write-Host $phpCheck[0]
} else {
    Write-Host "[ERROR] PHP is not installed or not in PATH" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please install PHP 8.1+ from: https://windows.php.net/download/" -ForegroundColor Yellow
    Write-Host "Then add the PHP directory to your Windows PATH environment variable" -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Press Enter to exit"
    exit 1
}

# Check Composer
Write-Host ""
Write-Host "Checking Composer installation..." -ForegroundColor Yellow
$composerCheck = & composer -v 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "[OK] Composer is installed" -ForegroundColor Green
} else {
    Write-Host "[ERROR] Composer is not installed" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please install Composer from: https://getcomposer.org/download/" -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Press Enter to exit"
    exit 1
}

# Install PHP dependencies
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Installing PHP dependencies..." -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

& composer install
if ($LASTEXITCODE -ne 0) {
    Write-Host "[ERROR] Composer install failed" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}
Write-Host "[OK] Dependencies installed" -ForegroundColor Green

# Run migrations
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Setting up database..." -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

& php artisan migrate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "[WARNING] Migration may have failed" -ForegroundColor Yellow
    Write-Host "Check database connection in .env" -ForegroundColor Yellow
}

Write-Host "[OK] Database setup complete" -ForegroundColor Green

# Install NPM dependencies
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Installing NPM dependencies (optional)..." -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

if (Test-Path "package.json") {
    Write-Host "package.json found. Installing NPM dependencies..." -ForegroundColor Yellow
    & npm install
    Write-Host "[OK] NPM dependencies installed" -ForegroundColor Green
    
    Write-Host ""
    Write-Host "Building frontend assets..." -ForegroundColor Yellow
    & npm run build
    Write-Host "[OK] Assets built" -ForegroundColor Green
} else {
    Write-Host "[SKIP] No package.json found" -ForegroundColor Yellow
}

# Clear caches
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Clearing application caches..." -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

& php artisan cache:clear 2>&1 | Out-Null
& php artisan config:clear 2>&1 | Out-Null
& php artisan route:clear 2>&1 | Out-Null
& php artisan view:clear 2>&1 | Out-Null

Write-Host "[OK] Caches cleared" -ForegroundColor Green

# Complete
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Setup Complete!" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "To start the development server, run:" -ForegroundColor Yellow
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Then open: http://localhost:8000" -ForegroundColor Cyan
Write-Host ""

Read-Host "Press Enter to exit"
