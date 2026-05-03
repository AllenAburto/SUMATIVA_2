TechHub Store
Evaluacion Sumativa 2 - Diseno y Programacion de Aplicaciones para Internet - Instituto Profesional AIEP

DESCRIPCION DEL PROYECTO

TechHub Store es una tienda virtual de productos tecnologicos que permite a los usuarios navegar mediante un catalogo de productos, agregar articulos al carrito, registrarse, iniciar sesion y realizar compras. Ademas cuenta con un panel de administracion donde se pueden gestionar los productos (agregar como editar) y revisar el estado de las ordenes.

El proyecto esta construido siguiendo el patron de diseno MVC (Modelo - Vista - Controlador), lo que significa que el codigo esta organizado por responsabilidades: los modelos manejan los datos, los controladores manejan la logica, y las vistas muestran el contenido al usuario.

TECNOLOGIAS UTILIZADAS

- PHP 8 con POO (clases, herencia, encapsulamiento)
- MySQL como motor de base de datos con relaciones entre tablas
- HTML5 y CSS3 para la estructura y el diseño visual de las paginas
- Bulma v1.0.2 como framework CSS cargado desde CDN
- JavaScript para interacciones dinamicas sin recargar la pagina (AJAX)
- Apache como servidor web a traves de XAMPP

INSTALACION

1. Copiar la carpeta Sumativa_2 completa dentro de C:/xampp/htdocs/
2. Iniciar Apache y MySQL desde el panel de control de XAMPP
3. Abrir phpMyAdmin en el navegador (http://localhost/phpmyadmin)
4. Crear la Base de Datos, en este caso usar el nombre techhub_store
5. Entrar a la Base de Datos creada e ir a la seccion Importar y seleccionar el archivo database/techhub_store.sql
6. Hacer clic en Continuar para crear la base de datos con todos los datos de ejemplo
7. Abrir la tienda en el navegador: http://localhost/Sumativa_2/index.php

CREDENCIALES DE PRUEBA

Administrador: admin@techhub.cl / admin123

ESTRUCTURA DEL PROYECTO

La carpeta raiz contiene los archivos de entrada y configuracion general. Dentro hay tres grandes secciones: Backend con toda la logica PHP, Frontend con los archivos de diseno y JavaScript, y views con las paginas HTML que el usuario ve.

Sumativa_2/
- index.php
- README.md
- Backend/
  - config/database.php
  - models/Model.php
  - models/Usuario.php
  - models/Producto.php
  - models/Carrito.php
  - models/Orden.php
  - controllers/ProductoController.php
  - controllers/UsuarioController.php
  - controllers/CarritoController.php
  - controllers/OrdenController.php
  - controllers/AdminController.php
  - ajax/buscar_productos.php
  - ajax/carrito_agregar.php
  - ajax/carrito_actualizar.php
  - ajax/carrito_eliminar.php
  - ajax/carrito_obtener.php
  - ajax/carrito_vaciar.php
  - ajax/admin_eliminar_producto.php
  - ajax/upload_imagen.php
- Frontend/
  - css/styles.css
  - js/app.js
  - js/productos.js
  - js/carrito.js
  - js/auth.js
  - js/admin.js
  - img/productos/
- views/
  - layout/header.php
  - layout/footer.php
  - home.php
  - catalogo.php
  - producto_detalle.php
  - login.php
  - registro.php
  - carrito.php
  - checkout.php
  - historial.php
  - orden_detalle.php
  - admin/dashboard.php
  - admin/productos.php
  - admin/producto_form.php
  - admin/ordenes.php
  - admin/sidebar.php
  - admin/sidebar_desktop.php
  - errors/404.php
- database/techhub_store.sql

DESCRIPCION DE CADA ARCHIVO

Archivos en la raiz del proyecto

index.php
Es el unico punto de entrada de la aplicacion. Cuando el usuario navega a cualquier pagina, todas las solicitudes pasan primero por este archivo. Lee el parametro "page" de la URL y decide que controlador ejecutar. Tambien define constantes como BASE_URL que se usan en todos los enlaces, y la funcion productoImg() que verifica si existe la imagen de un producto antes de mostrarla, evitando errores en el navegador.

**Base de datos**

database/techhub_store.sql
Archivo SQL que crea la base de datos completa. Define las cinco tablas principales: usuarios, productos, carritos, ordenes y detalles_orden, con sus relaciones entre ellas. Tambien inserta 15 productos de ejemplo distribuidos en cinco categorias (notebooks, tablets, accesorios, monitores y perifericos) con precios en pesos chilenos, y el usuario administrador con su contrasena ya cifrada. Importar este archivo en phpMyAdmin es suficiente para tener todo listo.

**Backend - Configuracion**

Backend/config/database.php
Clase que maneja la conexion a MySQL usando el patron Singleton. Esto significa que aunque se llame muchas veces durante una solicitud, la conexion a la base de datos se crea una sola vez y se reutiliza. Si la conexion falla, detiene la ejecucion y muestra un mensaje de error.

**Backend - Modelos**

Los modelos son las clases que se comunican directamente con la base de datos. Cada modelo representa una entidad del sistema.

Backend/models/Model.php
Clase base de la que heredan todos los demas modelos. Define la conexion a la base de datos en el constructor y provee metodos genericos para las operaciones mas comunes (obtener todos, obtener por id, crear, actualizar, eliminar). Usa prepared statements para evitar inyecciones SQL. Al ser abstracta, no se puede usar directamente sino que sirve como punto de partida para los modelos especificos.

Backend/models/Usuario.php
Maneja todo lo relacionado con los usuarios del sistema. El metodo authenticate() busca al usuario por email y verifica la contrasena cifrada. El metodo register() valida que el email tenga formato correcto, que la contrasena tenga al menos 6 caracteres, que el email no este ya registrado, y guarda la contrasena cifrada con bcrypt. Extiende Model.php.

Backend/models/Producto.php
Contiene las consultas relacionadas con el catalogo de productos. El metodo search() construye dinamicamente una consulta SQL segun los filtros que aplique el usuario (texto, categoria, orden). getDestacados() retorna solo los productos marcados como destacados para mostrarlos en la pagina de inicio. reducirStock() descuenta el stock de un producto de forma segura y retorna false si no hay suficiente cantidad disponible. Extiende Model.php.

Backend/models/Carrito.php
Gestiona el carrito de compras usando el identificador de sesion como llave, lo que permite que funcione tanto para usuarios registrados como anonimos. addItem() agrega un producto o suma la cantidad si ya estaba en el carrito. getItems() hace una consulta con JOIN para obtener nombre, precio e imagen de cada producto en una sola consulta. getTotal() y getCount() calculan el monto total y la cantidad de unidades usando funciones de agregacion SQL. Extiende Model.php.

Backend/models/Orden.php
Procesa la compra completa dentro de una transaccion MySQL. Primero valida que haya stock suficiente para cada producto del carrito. Si todo esta bien, crea el registro de la orden, inserta cada linea de detalle con su subtotal, reduce el stock de cada producto y vacia el carrito. Si algo falla en cualquier paso, deshace todos los cambios con ROLLBACK para mantener la consistencia de los datos. Extiende Model.php.

**Backend - Controladores**

Los controladores reciben las solicitudes del usuario, llaman a los modelos que necesitan y luego incluyen la vista correspondiente para mostrar el resultado.

Backend/controllers/ProductoController.php
Maneja tres flujos: la pagina de inicio (obtiene productos destacados), el catalogo (recibe los filtros desde la URL y los pasa al modelo), y la pagina de detalle de un producto (verifica que el producto exista y este activo antes de mostrarlo). Usa Producto.php e incluye las vistas home.php, catalogo.php y producto_detalle.php.

Backend/controllers/UsuarioController.php
Administra el ciclo completo de autenticacion. Muestra los formularios de login y registro, procesa el inicio de sesion creando las variables de sesion con el id, nombre, email y rol del usuario, y redirige segun el rol (administradores al panel, clientes al inicio). El metodo logout() vacia el carrito en la base de datos antes de destruir la sesion para que no queden datos huerfanos. Usa Usuario.php y Carrito.php.

Backend/controllers/CarritoController.php
Muestra el carrito con sus items y total, verifica que el usuario este logueado antes de mostrar el checkout, y procesa el formulario de pago llamando al modelo Orden. Si ocurre un error durante la compra (por ejemplo que el stock se haya agotado entre el momento de agregar al carrito y el momento de pagar), captura el mensaje y lo muestra al usuario con instrucciones claras. Usa Carrito.php, Producto.php y Orden.php.

Backend/controllers/OrdenController.php
Muestra el historial de compras del usuario autenticado. Al mostrar el detalle de una orden especifica, verifica que la orden pertenezca al usuario que esta viendo, impidiendo que un usuario vea los pedidos de otra persona. Si la orden no existe o no pertenece al usuario, muestra la pagina de error 404. Usa Orden.php.

Backend/controllers/AdminController.php
Controlador del panel de administracion. En el constructor verifica que el usuario tenga rol de administrador y si no, redirige al login. dashboard() consulta las estadisticas principales de la tienda. productoSave() valida el formulario y decide si crear o editar un producto segun si viene o no el campo id. updateOrdenEstado() actualiza el estado de una orden desde el panel. Usa Producto.php, Orden.php y Usuario.php.

**Backend - Endpoints AJAX**

Estos archivos no muestran paginas sino que responden solicitudes JavaScript con datos en formato JSON. Permiten actualizar partes de la pagina sin recargarla completamente.

Backend/ajax/buscar_productos.php
Recibe los filtros de busqueda enviados por JavaScript y retorna los productos que coinciden en formato JSON. Es invocado por productos.js cada vez que el usuario escribe en el buscador o cambia un filtro.

Backend/ajax/carrito_agregar.php
Valida que el producto exista y que no se supere el stock disponible antes de agregar al carrito. Calcula cuanta cantidad ya tiene el usuario en el carrito y cuanta puede agregar todavia. Retorna el nuevo contador del carrito para actualizar el numero que aparece en la barra de navegacion.

Backend/ajax/carrito_actualizar.php
Recibe el producto y la nueva cantidad deseada. Si la cantidad supera el stock disponible la ajusta automaticamente al maximo posible en lugar de rechazar la operacion, e informa al usuario del ajuste mediante un aviso. Retorna el estado completo actualizado del carrito.

Backend/ajax/carrito_eliminar.php
Elimina un producto especifico del carrito y retorna el estado actualizado con todos los items restantes, el nuevo total y el nuevo contador para que la pagina se actualice sin recargarse.

Backend/ajax/carrito_obtener.php
Lee el estado actual del carrito y retorna todos sus items con nombre, precio e imagen, el total monetario y la cantidad de unidades. Es llamado al cargar cada pagina para actualizar el badge del carrito en la barra de navegacion.

Backend/ajax/carrito_vaciar.php
Elimina todos los productos del carrito de una vez. Es invocado tanto por el boton de vaciar carrito en la pagina del carrito (con confirmacion previa del usuario), como automaticamente durante el logout para limpiar los datos de sesion.

Backend/ajax/admin_eliminar_producto.php
Verifica que el usuario sea administrador y luego desactiva el producto (pone activo en 0) en lugar de borrarlo completamente. Esto preserva el historial de ordenes anteriores que puedan tener ese producto. El JavaScript anima la desaparicion de la fila sin recargar la pagina.

Backend/ajax/upload_imagen.php
Procesa la subida de imagenes para los productos. Verifica que el archivo no supere 3MB y que sea realmente una imagen (jpeg, png, webp o gif) analizando su contenido interno y no solo la extension. Guarda el archivo con un nombre unico para evitar colisiones y retorna la URL para que el formulario pueda mostrar la previsualizacion.

**Frontend - Estilos y JavaScript**

Frontend/css/styles.css
Hoja de estilos propia del proyecto que complementa a Bulma. Define la grilla de productos usando CSS Grid con columnas que se ajustan automaticamente al ancho disponible. La barra de filtros usa Flexbox para alinearse correctamente. Implementa funciones responsivas para las siguientes resoluciones: movil base (menor a 769px), tablet (769px a 1023px), desktop (1024px en adelante) y pantallas anchas (desde 1216px). En el panel de administracion, el sidebar lateral se oculta en pantallas pequenas y aparece una navegacion horizontal en su lugar. Tambien incluye animaciones para las notificaciones y la zona de carga de imagenes.

Frontend/js/app.js
Script que se carga en todas las paginas. Activa el menu hamburguesa de Bulma en moviles, actualiza el badge del carrito en la barra de navegacion al cargar cada pagina, y define las funciones showToast() (notificaciones flotantes temporales) y formatPrice() (formato de precios en pesos chilenos) que usan los demas scripts.

Frontend/js/productos.js
Gestiona la busqueda en tiempo real del catalogo. Escucha los cambios en el campo de texto y los selectores de categoria y orden. Aplica un retraso de 300ms antes de enviar la solicitud al servidor para no hacer demasiadas peticiones mientras el usuario escribe. Al recibir la respuesta, genera el HTML de las cards de producto y lo inserta en la pagina sin recargarla.

Frontend/js/carrito.js
Maneja todas las operaciones del carrito desde el navegador. Permite agregar productos, cambiar cantidades con botones mas y menos, eliminar items individuales y vaciar el carrito completo. Muestra un aviso cuando la cantidad llega al limite de stock disponible. Todas las operaciones se hacen con AJAX para que la pagina no se recargue.

Frontend/js/auth.js
Valida los formularios de login y registro antes de enviarlos al servidor. Verifica que los campos no esten vacios, que el email tenga formato valido y que la contrasena de confirmacion coincida con la original. Los errores se muestran directamente bajo cada campo para que el usuario sepa exactamente que debe corregir.

Frontend/js/admin.js
Combina dos funcionalidades del panel de administracion. Por un lado gestiona el modal de confirmacion para eliminar productos, identificando el producto a eliminar desde el boton y ejecutando la solicitud AJAX al confirmar. Por otro lado maneja la zona de carga de imagenes con soporte para arrastrar y soltar, mostrando una barra de progreso durante la subida y la previsualizacion al terminar.

**Views - Plantillas de pagina compartidas**

views/layout/header.php
Genera el inicio de cada pagina HTML: el doctype, el viewport para moviles, el titulo dinamico, y los enlaces a Bulma, Font Awesome y los estilos propios. Renderiza la barra de navegacion con el logo, los enlaces principales y el menu de usuario que cambia segun si el visitante esta o no autenticado.

views/layout/footer.php
Cierra cada pagina con el pie de pagina informativo y carga los scripts JavaScript. Siempre carga app.js como base, y luego los scripts especificos que cada vista declare (por ejemplo el catalogo indica que necesita productos.js y carrito.js).

**Views - Paginas de la tienda**

views/home.php
Pagina de inicio con tres secciones: un banner principal con imagen y botones de accion, una seccion de categorias con acceso rapido a cada tipo de producto, y una grilla de productos destacados para llamar la atencion del visitante.

views/catalogo.php
Pagina del catalogo completo con barra de filtros y grilla de productos. Los productos se renderizan inicialmente desde PHP y las busquedas posteriores las maneja JavaScript insertando los resultados sin recargar la pagina. Cada card muestra imagen, categoria, precio y botones de accion. Si un producto no tiene stock, el boton de agregar al carrito se reemplaza por el texto Sin stock.

views/producto_detalle.php
Muestra toda la informacion de un producto: imagen, descripcion completa, marca, categoria, precio y disponibilidad de stock. Si hay stock disponible, permite al usuario elegir la cantidad antes de agregar al carrito. Si no hay stock, muestra el boton deshabilitado con el texto correspondiente.

views/login.php
Formulario de inicio de sesion con campos de email y contrasena. Muestra mensajes de error del servidor si las credenciales son incorrectas. Incluye enlace a la pagina de registro para usuarios nuevos y muestra las credenciales de prueba para facilitar la evaluacion del proyecto.

views/registro.php
Formulario de creacion de cuenta con campos de nombre, email, contrasena y confirmacion de contrasena. El campo de confirmacion valida en tiempo real si coincide con la contrasena. Muestra errores tanto del servidor como de la validacion del lado del cliente.

views/carrito.php
Pagina del carrito de compras con dos columnas: la lista de productos agregados y el resumen del pedido con el total. La lista se carga y actualiza via AJAX. El boton principal cambia entre ir al pago (usuario logueado) e ir al login (usuario anonimo). Incluye boton para vaciar el carrito con confirmacion previa.

views/checkout.php
Formulario de finalizacion de compra. Muestra los datos del usuario pre-completados y un campo para ingresar la direccion de envio. Al lado muestra el resumen de lo que se va a comprar con cantidades, precios y el total final. Si ocurre un error en el proceso (como falta de stock) muestra el mensaje con instrucciones para el usuario.

views/historial.php
Lista todas las ordenes realizadas por el usuario autenticado ordenadas por fecha. Muestra el numero de orden, la fecha, el total y el estado de cada una (pendiente, completada o cancelada). Permite acceder al detalle completo de cada orden.

views/orden_detalle.php
Muestra los datos completos de una orden: fecha, estado, direccion de envio, y la lista de productos comprados con imagen, nombre, cantidad, precio unitario y subtotal. Si el usuario llega a esta pagina tras completar una compra exitosa, muestra un mensaje de confirmacion verde.

views/errors/404.php
Pagina de error amigable que se muestra cuando el usuario intenta acceder a una ruta que no existe. Ofrece dos botones para volver al inicio o al catalogo, evitando que el usuario quede atrapado sin saber como continuar navegando.

**Views - Panel de administracion**

views/admin/dashboard.php
Pagina principal del panel de administracion. Muestra cuatro tarjetas con estadisticas generales: cantidad de productos activos, total de ordenes recibidas, numero de clientes registrados y suma de ingresos de ordenes completadas. Tambien ofrece accesos rapidos a las acciones mas frecuentes del administrador.

views/admin/productos.php
Lista todos los productos del sistema en formato tabla (en computador) o en tarjetas individuales (en tablet y movil). Muestra imagen miniatura, nombre, marca, categoria, precio, stock y estado de cada producto. Permite editar y eliminar productos directamente desde la lista.

views/admin/producto_form.php
Formulario para crear un nuevo producto o editar uno existente. En modo edicion pre-llena todos los campos con los datos actuales. Incluye una zona interactiva para cargar la imagen del producto: permite seleccionarla desde el explorador de archivos o arrastrarla directamente, muestra el progreso de carga y una previsualizacion al terminar.

views/admin/ordenes.php
Lista todas las ordenes del sistema de todos los usuarios, mostrando el nombre y email del cliente. Permite cambiar el estado de cada orden (pendiente, completada o cancelada) directamente desde la lista mediante un selector y un boton de actualizar, sin necesidad de entrar al detalle.

views/admin/sidebar.php
Navegacion horizontal que aparece en tablets y moviles (pantallas menores a 1024px). Muestra los accesos rapidos del panel de administracion con iconos y texto. El enlace de la seccion activa se resalta visualmente.

views/admin/sidebar_desktop.php
Barra lateral de navegacion que aparece en pantallas de escritorio (1024px o mas). Columna de 220px con fondo oscuro que contiene dos grupos de enlaces: Administracion (Dashboard, Productos, Ordenes) y Cuenta (Ver tienda, Salir). El enlace activo se resalta con el color primario del proyecto.

Frontend/img/productos/
Carpeta donde se guardan las imagenes de los productos subidas desde el panel de administracion. Cuando un producto no tiene imagen asignada o el archivo no existe, la aplicacion muestra un icono de reemplazo en lugar de generar un error en el navegador.


FUNCIONALIDADES PRINCIPALES

Catalogo y busqueda
Los usuarios pueden explorar todos los productos disponibles y filtrarlos por categoria o por precio. La busqueda por texto funciona en tiempo real: mientras el usuario escribe, los resultados se actualizan sin recargar la pagina. Cada producto tiene una pagina de detalle con toda su informacion y la opcion de elegir la cantidad antes de agregar al carrito.

Carrito de compras
El carrito funciona aunque el usuario no haya iniciado sesion, guardando los productos asociados al identificador de sesion del navegador. Los usuarios pueden modificar las cantidades, eliminar productos o vaciar el carrito. El sistema valida en todo momento que no se supere el stock disponible y muestra avisos claros cuando se llega al limite.

Registro e inicio de sesion
Los visitantes pueden crear una cuenta con nombre, email y contrasena. Las contrasenas se guardan cifradas en la base de datos. Al iniciar sesion, los administradores son redirigidos al panel de administracion y los clientes al inicio de la tienda. Al cerrar sesion se vacia automaticamente el carrito de la base de datos.

Proceso de compra
Los usuarios autenticados pueden finalizar su compra indicando una direccion de envio. El sistema procesa la orden dentro de una transaccion de base de datos para garantizar que todos los pasos (crear la orden, registrar los detalles y descontar el stock) se completen o no se haga ninguno. Si algo falla, el usuario recibe un mensaje claro explicando el problema.

Panel de administracion
Accessible solo para usuarios con rol de administrador. Desde el dashboard se ven las estadisticas generales de la tienda. En la seccion de productos se puede crear, editar y desactivar productos *incluyendo la carga de imagenes*. En la seccion de ordenes se puede cambiar el estado de cada pedido segun avance el proceso de entrega.