/////////JUGADORES

.OBTENER TODOS LOS JUGADORES:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/players.
    Para traer todos los jugadores existentes.


.OBTENER JUGADOR:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/players/:ID.
    Para traer a un jugador en especifico, solicitado por Id.


.OBTENER JUGADOR POR ORDEN:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/players?sort=NombreDelCampoSolicitado&order=asc/desc.
    Para traer a los jugadores dependiendo de un campo, en un orden especifico sea Ascendente o Descendente.


.OBTENER JUGADOR POR PAGINACION:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/players?page=INT&limit=INT.
    Para traer a los jugadores por paginacion con un limite especificado de equipos.


.CREAR JUGADOR:
    METODO : POST.
    URL : http://localhost/web2/tpe_parte2/api/players.
    Para crear a un jugador nuevo.
    PD:autentificación necesaria.


.ELIMINAR JUGADOR:
    METODO : DELETE.
    URL : http://localhost/web2/tpe_parte2/api/players/:ID.
    Para eliminar un jugador existente.


.ACTUALIZAR JUGADOR:
    METODO : PUT.
    URL : http://localhost/web2/tpe_parte2/api/players/:ID.
    Para actualizar un jugador existente.
    PD:autentificación necesaria.


///////////EQUIPOS

.OBTENER TODOS LOS EQUIPOS:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/teams. 
    Para traer todos los equipos existentes.


.OBTENER EQUIPO:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/teams/:ID.
    Para traer a un equipo en especifico, solicitado por Id.


.OBTENER EQUIPO POR ORDEN:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/teams?sort=NombreDelCampoSolicitado&order=asc/desc.
    Para traer a los equipos dependiendo de un campo, en un orden especifico sea Ascendente o Descendente.


.OBTENER EQUIPO POR PAGINACION:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/teams?page=INT&limit=INT.
    Para traer a los equipos por paginacion con un limite especificado de equipos.


.CREAR EQUIPO:
    METODO : POST.
    URL : http://localhost/web2/tpe_parte2/api/teams.
    Para crear a un equipo nuevo.
    PD:autentificación necesaria.


.ELIMINAR EQUIPO:
    METODO : DELETE.
    URL : http://localhost/web2/tpe_parte2/api/teams/:ID.
    Para eliminar un equipo existente.
    TIENE QUE ELIMINAR TODOS LOS JUGADORES PERTENECIENTES AL EQUIPO QUE QUIERE ELIMINAR PARA PODER ELIMINAR EL EQUIPO.


.ACTUALIZAR TEAMS:
    METODO : PUT.
    URL : http://localhost/web2/tpe_parte2/api/teams/:ID.
    Para actualizar un equipo existente.
    PD:autentificación necesaria.




/////////////AUTENTIFICACION

.OBTENER TOKEN:
    METODO : GET.
    URL : http://localhost/web2/tpe_parte2/api/auth/token.
    Para obtener el token de seguridad para poder realizar mas metodos.
    PD:Con auterizacion basic primero y el token se pone en token bearer.




