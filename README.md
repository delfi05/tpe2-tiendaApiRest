## API REST para el recurso de TIENDA

## Importar la base de datos
- importar desde PHPMyAdmin (o cualquiera) database/db_tienda.php


## Pueba con postman
El endpoint de la API es: http://localhost/web2/Ferreyra-tp2rest/api/cliente

Ejemplos de uso:

    [GET]-> .../api/cliente (accede al listado clientes)

    [GET]-> .../api/cliente/3 (accede al cliente con ID 3)

    [POST]-> .../api/cliente/ (lee el contenido del body y agrega un nuevo cliente)

    [PUT]-> .../api/cliente/11 (lle el contenido del body y edita el cliente)

    [DELETE]-> .../api/cliente/2 (elimina el cliente con id 2) 

    FORMATO POST/PUT: Para hacer una inserción (POST) o una edición (PUT), se deben ingresar los datos a como se muestran a continuación.
            {
                nombre: "Delfina",
                apellido: "Ferreyra",
                dni: "42773616"
            }

Otras herramientas:
FILTRAR Y ORDENAR CONTENIDO
   - ASCENDENTEMENTE -> .../cliente?sort=nombre&order=asc (ordena los clientes ascendentemente)
   - DESCENDENTEMENTE -> .../cliente?sort=nombre&order=desc (ordena los clientes descendentemente)
   - FILTRADO DE NOMBRE -> .../cliente?filtername=delfina (filtra los nombres de los clientes y solo deja las columnas que tengan el nombre delfina)
   - PAGINACIÓN -> .../cliente?page=1&limit=2 (divide a los clientes en paginas, y ademas limita cuandos elementos ver en cada una)
