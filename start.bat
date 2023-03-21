@echo off
symfony server:start -d
symfony -d yarn run dev-server
%*
pause