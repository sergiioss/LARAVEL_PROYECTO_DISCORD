# :computer: Tech Stack:
![Heroku](https://img.shields.io/badge/heroku-%23430098.svg?style=for-the-badge&logo=heroku&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![JWT](https://img.shields.io/badge/JWT-black?style=for-the-badge&logo=JSON%20web%20tokens) ![Postman](https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=postman&logoColor=white)
<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></p>

<h2>Relaciones de las tablas:</h2>
<p align="center"><img src="/fotos/relaciones.png"></p>

<p>En este proyecto se intenta replicar una aplicacion chat, donde se va a poder crear juegos, salas dentro del juego y chats. Del mismo modo se podran borrar, modificar, leer y crear.</p>


Endpoints:

<strong>Route::get('https://proyecto-discord.herokuapp.com/api')</strong>
- Devuelve un string "Bienvenido a mi app de chats".

<h3>Usuarios</h3>

<strong>Route::put('https://proyecto-discord.herokuapp.com/api/updateduser'</strong>
- Nos metemos dentro de nuestro perfil y podemos modificar 3 campos, username, steamusername y email.

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/register'</strong>

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/login'</strong>
- El usuario hace log in introduciendo el email y el password.

<strong>Route::get('https://proyecto-discord.herokuapp.com/api/info'</strong>
- Saca la informacion del perfil de usuario.

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/logout'</strong>
- El usuario hace log out invalidando el token.

<h3>Super Admin</h3>

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/user/add_admin/{id}</strong>
- Añade admin a un usuario. Solo puede realizarlo el superAdmin.

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/user/delete_admin/{id}'</strong>
- Borra el admin a un usuario. Solo puede realizarlo un superAdmin.

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/user/super_admin/{id}</strong>
- Añade superAdmin a un usuario. Solo puede realizarlo un superAdmin.

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/user/delete_super_admin/{id}</strong>
- Elimina un superAdmin de un usuario. Solo puede realizarlo un superAdmin.

<h3>Juegos</h3>

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/create'</strong>
- El usuario crea un juego.

<strong>Route::get('https://proyecto-discord.herokuapp.com/api/gameid'</strong>
- Busca todas las salas de los juegos creados.

<strong>Route::put('https://proyecto-discord.herokuapp.com/api/updatedgame/{id}</strong>
- Cambia el nombre de la sala de juego.

<strong>Route::delete('https://proyecto-discord.herokuapp.com/api/deletegame/{id}</strong>
- Elimina la sala del juego siempre y cuando la haya creado el mismo usuario.

<h3>Canales</h3>

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/create/channel/{id}</strong>
- Crea un canal dentro de un juego.

<strong>Route::get('https://proyecto-discord.herokuapp.com/api/channelall'</strong>
- Hace una busqueda de todos los canales del juego.

<strong>Route::put('https://proyecto-discord.herokuapp.com/api/updatedchannel/{id}</strong>
- Modifica el nombre del canal del juego.

<strong>Route::delete('https://proyecto-discord.herokuapp.com/api/deletechannel/{id}</strong>
- Elimina el canal del juego.

<strong>Route::put('https://proyecto-discord.herokuapp.com/api/loginchannel/{id}'</strong>
- Entras dentro del canal de chat del juego y puedes crear, modificar, leer todos los mensajes que has escrito y eliminarlos.

<strong>Route::put('https://proyecto-discord.herokuapp.com/api/logoutchannel/{id}'</strong>
- Haces logout del canal y no puedes enviar mensajes, ni modificarlos, ni traerte todos los mensajes y tampoco eliminarlos.

<h3>Mensajes</h3>

<strong>Route::post('https://proyecto-discord.herokuapp.com/api/create/message/{id}</strong>
- Crea un mensaje dentro del canal del juego.

<strong>Route::get('https://proyecto-discord.herokuapp.com/api/messagesall',</strong>
- Busca todos los mensajes del canal del juego.

<strong>Route::put('https://proyecto-discord.herokuapp.com/api/updatedmessage/{id}'</strong>
- Modifica el mensaje del canal del juego.

<strong>Route::delete('https://proyecto-discord.herokuapp.com/api/deletemessage/{id}</strong>
- Elimina el mensaje del canal del juego.





