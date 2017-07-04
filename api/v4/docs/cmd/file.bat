cd ..\..\..\..
if not exist "./frontend/web/doc/restapi/v4" mkdir "./frontend/web/doc/restapi/v4"
raml2html "./api/v4/docs/api.raml" > "./frontend/web/doc/restapi/v4/index.html"
pause
