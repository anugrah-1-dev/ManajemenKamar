$proj    = "C:\Users\Point\Downloads\mk-test\ManajemenKamar-pkl"
$myExe   = "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqld.exe"
$myIni   = "C:\laragon\bin\mysql\mysql-8.4.3-winx64\my.ini"
$noOpen   = $args -contains "-noopen"

function Test-Port([int]$port) {
    $t = New-Object Net.Sockets.TcpClient
    try { $t.Connect("127.0.0.1", $port); $t.Close(); $true } catch { $false }
}

if (-not (Test-Port 3306)) {
    if (Test-Path $myExe) {
        Start-Process -FilePath $myExe -ArgumentList "--defaults-file=$myIni" -WindowStyle Hidden
        $i = 0
        while ($i -lt 30 -and -not (Test-Port 3306)) { Start-Sleep -Milliseconds 500; $i++ }
        Write-Host "MySQL: start (port 3306)"
    } else {
        Write-Host "MySQL: tidak ditemukan di $myExe"
    }
} else {
    Write-Host "MySQL: sudah jalan"
}

if (-not (Test-Port 8000)) {
    Start-Process -FilePath "php" -ArgumentList "artisan", "serve", "--port=8000" -WorkingDirectory $proj -WindowStyle Hidden
    $i = 0
    while ($i -lt 20 -and -not (Test-Port 8000)) { Start-Sleep -Milliseconds 500; $i++ }
    Write-Host "Laravel: start (http://127.0.0.1:8000)"
} else {
    Write-Host "Laravel: sudah jalan"
}

if (-not $noOpen) {
    $chrome = @(
        "C:\Program Files\Google\Chrome\Application\chrome.exe",
        "C:\Program Files (x86)\Google\Chrome\Application\chrome.exe",
        "$env:LOCALAPPDATA\Google\Chrome\Application\chrome.exe"
    ) | Where-Object { Test-Path $_ } | Select-Object -First 1

    if ($chrome) {
        Start-Process $chrome "http://127.0.0.1:8000"
        Write-Host "Chrome: dibuka"
    } else {
        Write-Host "Chrome: tidak ditemukan"
        Start-Process "http://127.0.0.1:8000"
    }
}
