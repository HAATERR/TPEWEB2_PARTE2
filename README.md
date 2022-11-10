/////////JUGADORES



.OBTENER TODOS LOS JUGADORES:
GET api/players.


.OBTENER JUGADOR:
GET api/players/:ID.

.OBTENER JUGADOR POR ORDEN:
GET api/players?sort=id&order=asc/desc.


.CREAR JUGADOR:
POST api/players.

PD:autentificación necesaria.


.ELIMINAR JUGADOR:
DELETE api/players/:ID.

PD:autentificación necesaria.


.ACTUALIZAR JUGADOR:
PUT api/players/:ID.

PD:autentificación necesaria.


///////////EQUIPOS

.OBTENER TODOS LOS EQUIPOS:
GET api/teams.


.OBTENER EQUIPO:
GET api/teams/:ID.


.CREAR EQUIPO:
POST api/teamas.

PD:autentificación necesaria.


.ELIMINAR EQUIPO:
DELETE api/teams/:ID.

TIENE QUE ELIMINAR TODOS LOS JUGADORES PERTENECIENTES AL EQUIPO QUE QUIERE ELIMINAR PARA PODER ELIMINAR EL EQUIPO.

PD:autentificación necesaria.


.ACTUALIZAR TEAMS:
PUT api/teams/:ID.

PD:autentificación necesaria.




/////////////AUTENTIFICACION

.OBTENER TOKEN:
GET api/auth/token

PD:Con auterizacion basic primero y el token se pone en token bearer.




