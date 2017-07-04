cd ..\..
rmdir /S /Q "./frontend/web/doc/rest-api"
md "./frontend/web/doc/rest-api"
raml2html "./api/docs/api.raml" > "./api/modules/doc/views/default/index.php"
pause
