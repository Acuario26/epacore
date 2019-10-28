@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../enniel/ami/bin/ami
php "%BIN_TARGET%" %*
