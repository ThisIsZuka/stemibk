if not "%minimized%"=="" goto :minimized
set minimized=true
@echo off
cd "C:\xampp123\htdocs\stemi_app\public\"

start /min cmd /C "nodemon server.js"
goto :EOF
:minimized