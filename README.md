# Localization-Manager

**Install**

sets db settings `/ProjectPath/App/Config.php` (for master and slave)

go to directory `/ProjectPath`

execute php for installation => `php sqlDump/sqlDump.php`

Done!.

`user : admin`

`pass : admin`

List localization example 

**_Request;_**

`http://localhost/api/locale?project=Project1&language=tr&version=1.01`

**_Response;_**

`{
  "status": true,
  "code": 0,
  "message": null,
  "data": [
    {
      "id": "14",
      "valueText": "Merhabalar!",
      "keyText": "title",
      "language": "tr",
      "project": "Project1",
      "version": "1.01"
    },
    {
      "id": "16",
      "valueText": "yumruk",
      "keyText": "fist",
      "language": "tr",
      "project": "Project1",
      "version": "1.01"
    }
  ]
}`