# Proyecto Miga de Oro

Este es un proyecto desarrollado con Laravel que proporciona una plataforma para gestionar tareas y una web dentro de una panadería.

## Estado del Proyecto

- Este proyecto está actualmente en desarrollo activo.

## Colaboradores del proyecto
- Laura Garrido
- Miguel Zanotto
- Jorge Alonso
- Joselyn Obando
- Kevin Bermudez

## Requisitos

- PHP >= 7.4
- Composer
- Laravel >= 8.x
- Docker

## Instalación

1. Clona este repositorio en tu máquina local:

git clone https://github.com/Alonso2002-jpg/Project-Panaderia-Laravel.git

2. Instala las dependencias del proyecto usando Composer:

cd Proyect-Panaderia-Laravel
composer install

3. Copia el archivo de configuración `.env.example` y renómbralo a `.env`:

cp .env.example .env

4. Configura tu base de datos en el archivo `.env` y ejecuta las migraciones:

php artisan migrate

5. Inicia el servidor local:

php artisan serve

6. Visita `http://localhost:8000` en tu navegador para ver la aplicación en funcionamiento. o abre el puerto dentro de Docker. Mostrandose como el puerto '80:80'.

## Uso

- Regístrate como usuario para acceder a todas las funcionalidades.
- Inicia sesión en tu cuenta para comenzar a gestionar los productos de la tienda.
- Agrega nuevos productos, edita la información existente y elimina productos no deseados.

## Estructura de Directorios

- **app/**: Contiene la lógica de la aplicación.
- **bootstrap/**: Archivos de inicio de la aplicación.
- **config/**: Archivos de configuración.
- **database/**: Migraciones y semillas de la base de datos.
- **public/**: Archivos públicos accesibles desde el navegador.
- **resources/**: Vistas, archivos de idioma y recursos adicionales.
- **routes/**: Rutas de la aplicación.
- **storage/**: Archivos generados por la aplicación.
- **tests/**: Pruebas automatizadas para la web y endpoints de la panaderia.

## Tabla de funcion básicas del Carrito

| Ruta                                      | Controlador          | Método     | Descripción                                                                   | Middleware           |
|-------------------------------------------|----------------------|------------|-------------------------------------------------------------------------------|----------------------|
| /cart                                     | CartController       | GET        | Muestra el carrito de compras.                                                | auth, admin          |
| /cart                                     | CartController       | PUT        | Actualiza un elemento en el carrito de compras.                               | auth, admin          |
| /cart                                     | CartController       | DELETE     | Elimina un elemento del carrito de compras.                                   | auth, admin          |

## ¿Que hace nuestro carrito?
El carrito de compras es una funcionalidad esencial en cualquier plataforma de comercio electrónico que permite a los usuarios seleccionar y organizar los productos que desean comprar antes de proceder al pago. Nuestro carrito de compras ofrece una experiencia intuitiva y conveniente para los usuarios, permitiéndoles agregar, eliminar y modificar productos fácilmente.

- Una de las características destacadas de nuestro carrito es su capacidad para mostrar de manera clara y concisa los productos seleccionados, junto con su cantidad y precio unitario. Los usuarios pueden visualizar el subtotal de cada producto y el total acumulado de la compra en tiempo real, lo que les proporciona una visión completa de su orden antes de proceder al pago.

- Además de la funcionalidad básica de agregar y eliminar productos, nuestro carrito de compras también permite a los usuarios realizar acciones como actualizar la cantidad de un artículo específico o eliminar productos no deseados con facilidad. Esto proporciona flexibilidad y control total sobre la selección de productos, lo que mejora la experiencia de compra del usuario.

- Otra característica clave es la capacidad de nuestro carrito para gestionar múltiples productos y cantidades, lo que permite a los usuarios realizar compras tanto de artículos individuales como de múltiples unidades de un mismo producto. Esto es especialmente útil para aquellos que desean comprar grandes cantidades de un artículo específico o agregar varios productos a su orden de una sola vez.



## Tabla de Funciones básicas de Productos
| Ruta                                      | Controlador          | Método     | Descripción                                                                   | Middleware           |
|-------------------------------------------|----------------------|------------|-------------------------------------------------------------------------------|----------------------|
| /products                                 | ProductsController   | GET        | Muestra una lista de todos los productos.                                    | auth, admin          |
| /products/create                          | ProductsController   | GET        | Muestra el formulario para crear un nuevo producto.                          | auth, admin          |
| /products                                | ProductsController   | POST       | Guarda un nuevo producto en la base de datos.                                | auth, admin          |
| /products/{product}                      | ProductsController   | GET        | Muestra los detalles de un producto específico.                              |                      |
| /products/{product}/edit                 | ProductsController   | GET        | Muestra el formulario para editar un producto existente.                     | auth, admin          |
| /products/{product}                      | ProductsController   | PUT/PATCH  | Actualiza la información de un producto en la base de datos.                 | auth, admin          |
| /products/{product}                      | ProductsController   | DELETE     | Elimina un producto de la base de datos.                                     | auth, admin          |
| /products/{product}/edit-image           | ProductsController   | GET        | Muestra el formulario para editar la imagen de un producto.                  | auth, admin          |
| /products/{product}/edit-image           | ProductsController   | PATCH      | Actualiza la imagen de un producto en la base de datos.                      | auth, admin          |

## ¿Que hacé nuestro Producto?
Una de las principales funcionalidades de nuestro producto es su capacidad para proporcionar a los usuarios una vista completa y detallada de cada artículo. Desde su nombre y descripción hasta su precio y disponibilidad, nuestro producto ofrece información clara y concisa para ayudar a los clientes a tomar decisiones informadas de compra.

- Además de la visualización de detalles, nuestro producto ofrece opciones de interacción intuitivas que permiten a los usuarios realizar acciones como editar, actualizar o eliminar un producto según sus necesidades. Con funciones de edición de fácil acceso, los clientes pueden personalizar sus selecciones de productos de acuerdo con sus preferencias individuales.

- La gestión eficiente de la información del producto es otra característica destacada. Nuestro producto garantiza la integridad y precisión de los datos almacenados, lo que facilita la actualización y mantenimiento de la base de datos de productos. Los usuarios pueden confiar en la exactitud de la información presentada, lo que contribuye a una experiencia de compra sin problemas y sin sorpresas desagradables.

## Tabla de Funciones básicas en Categorias
| Ruta                                      | Controlador          | Método     | Descripción                                                                   | Middleware           |
|-------------------------------------------|----------------------|------------|-------------------------------------------------------------------------------|----------------------|
| /categories                               | CategoriesController | GET        | Muestra una lista de todas las categorías.                                   | auth, admin          |
| /categories/create                        | CategoriesController | GET        | Muestra el formulario para crear una nueva categoría.                        | auth, admin          |
| /categories                               | CategoriesController | POST       | Guarda una nueva categoría en la base de datos.                              | auth, admin          |
| /categories/{category}                    | CategoriesController | GET        | Muestra los detalles de una categoría específica.                            |                      |
| /categories/{category}/edit               | CategoriesController | GET        | Muestra el formulario para editar una categoría existente.                   | auth, admin          |
| /categories/{category}                    | CategoriesController | PUT/PATCH  | Actualiza la información de una categoría en la base de datos.               | auth, admin          |
| /categories/{category}                    | CategoriesController | DELETE     | Elimina una categoría de la base de datos.                                   | auth, admin          |
| /categories/{category}/edit-image         | CategoriesController | GET        | Muestra el formulario para editar la imagen de una categoría.                | auth, admin          |
| /categories/{category}/edit-image         | CategoriesController | PATCH      | Actualiza la imagen de una categoría en la base de datos.                    | auth, admin          |

## ¿Que hacé nuestra Categoría?
Una de las principales funcionalidades de nuestra categoría es su capacidad para mostrar una lista completa y organizada de todas las categorías disponibles. Desde categorías principales hasta subcategorías específicas, nuestra solución proporciona una visión global de la estructura de productos, permitiendo a los usuarios explorar y descubrir fácilmente diferentes opciones.

- Además de la visualización de categorías, nuestra solución ofrece funcionalidades de gestión robustas que permiten a los administradores crear, editar y eliminar categorías según sea necesario. Con formularios intuitivos y opciones de edición accesibles, los administradores pueden personalizar y mantener la estructura de categorías de manera eficiente y sin complicaciones.

- Nuestra categoría también se destaca por su capacidad para mostrar detalles completos y descriptivos de cada categoría, incluyendo su nombre, descripción y opciones de imagen. Esto proporciona a los usuarios una comprensión clara de cada categoría y les ayuda a tomar decisiones informadas sobre qué productos explorar dentro de cada una.

- Además, nuestra solución está diseñada para ser altamente flexible y escalable. Con la capacidad de gestionar un gran volumen de categorías y adaptarse a las necesidades cambiantes del negocio, garantizamos que nuestra plataforma de categorización pueda crecer y evolucionar junto con el crecimiento del catálogo de productos.

## Tabla de Funciones básicas en Proveedores
| Ruta                                      | Controlador          | Método     | Descripción                                                                   | Middleware           |
|-------------------------------------------|----------------------|------------|-------------------------------------------------------------------------------|----------------------|
| /providers                                | ProvidersController  | GET        | Muestra una lista de todos los proveedores.                                   | auth, admin          |
| /providers/create                         | ProvidersController  | GET        | Muestra el formulario para crear un nuevo proveedor.                          | auth, admin          |
| /providers                                | ProvidersController  | POST       | Guarda un nuevo proveedor en la base de datos.                                | auth, admin          |
| /providers/{provider}/edit                | ProvidersController  | GET        | Muestra el formulario para editar un proveedor existente.                      | auth, admin          |
| /providers/{provider}                     | ProvidersController  | PUT/PATCH  | Actualiza la información de un proveedor en la base de datos.                  | auth, admin          |
| /providers/{provider}                     | ProvidersController  | DELETE     | Elimina un proveedor de la base de datos.                                      | auth, admin          |

## ¿Qué hacé nuestro Proveedor?
Nuestro proveedor es un componente crucial en el ecosistema de nuestra plataforma, encargado de garantizar un suministro constante y confiable de productos para satisfacer las necesidades de nuestros clientes. Más que simplemente un socio comercial, nuestro proveedor es un colaborador estratégico que contribuye al éxito y la reputación de nuestra empresa.

- Una de las principales funcionalidades de nuestro proveedor es su capacidad para proporcionar una lista exhaustiva y actualizada de todos los proveedores disponibles. Desde proveedores locales hasta proveedores internacionales, nuestra solución ofrece una visión completa de las opciones disponibles, permitiendo a los usuarios explorar y seleccionar proveedores según sus necesidades específicas.

- Además de la visualización de proveedores, nuestra solución ofrece funcionalidades de gestión sólidas que permiten a los administradores crear, editar y eliminar proveedores según sea necesario. Con formularios intuitivos y opciones de edición accesibles, los administradores pueden personalizar y mantener la lista de proveedores de manera eficiente y sin complicaciones.

- Nuestro proveedor también se destaca por su capacidad para mostrar detalles completos y descriptivos de cada proveedor, incluyendo su nombre, información de contacto y opciones de ubicación. Esto proporciona a los usuarios una comprensión clara de cada proveedor y les ayuda a tomar decisiones informadas sobre qué proveedores seleccionar para sus necesidades comerciales

## Tabla de Funciones básicas en Personal
| Ruta                                      | Controlador          | Método     | Descripción                                                                   | Middleware           |
|-------------------------------------------|----------------------|------------|-------------------------------------------------------------------------------|----------------------|
| /staff                                    | StaffController      | GET        | Muestra una lista de todo el personal.                                         | auth, admin          |
| /staff/create                             | StaffController      | GET        | Muestra el formulario para crear un nuevo miembro del personal.                | auth, admin          |
| /staff                                    | StaffController      | POST       | Guarda un nuevo miembro del personal en la base de datos.                      | auth, admin          |
| /staff/{staff}                            | StaffController      | GET        | Muestra los detalles de un miembro del personal específico.                     | auth, admin          |
| /staff/{staff}/edit                       | StaffController      | GET        | Muestra el formulario para editar un miembro del personal existente.            | auth, admin          |
| /staff/{staff}                            | StaffController      | PUT/PATCH  | Actualiza la información de un miembro del personal en la base de datos.        | auth, admin          |
| /staff/{staff}                            | StaffController      | DELETE     | Elimina un miembro del personal de la base de datos.                            | auth, admin          |
| /staff/{staff}/edit-image                 | StaffController      | GET        | Muestra el formulario para editar la imagen de un miembro del personal.         | auth, admin          |
| /staff/{staff}/update-image               | StaffController      | PATCH      | Actualiza la imagen de un miembro del personal en la base de datos.             | auth, admin          |
| /staff/{staff}/recover                    | StaffController      | PUT        | Restaura un miembro del personal eliminado previamente.                         | auth, admin          |

## ¿Qué hacé nuestro Personal?
Nuestro personal es el núcleo de nuestra organización, desempeñando un papel fundamental en la prestación de servicios de alta calidad y en la satisfacción de las necesidades de nuestros clientes. Más que simplemente empleados, nuestro personal es un equipo dedicado y capacitado que trabaja en conjunto para garantizar el éxito y la excelencia en todas las áreas de nuestra empresa.

- Una de las principales funcionalidades de nuestro personal es su capacidad para proporcionar un servicio excepcional y una atención personalizada a nuestros clientes. Desde el servicio de atención al cliente hasta el soporte técnico, nuestro equipo de personal se esfuerza por superar las expectativas y brindar una experiencia positiva a cada cliente que interactúa con nuestra empresa.

- Además de la prestación de servicios, nuestro personal también desempeña funciones de gestión y administración interna para garantizar el buen funcionamiento de la empresa. Desde la gestión de inventario hasta la coordinación de horarios, nuestro equipo de personal trabaja diligentemente para mantener la eficiencia operativa y cumplir con los objetivos comerciales establecidos.

- Nuestro personal también se destaca por su capacidad para colaborar y trabajar en equipo, aprovechando las habilidades individuales y colectivas para lograr resultados sobresalientes. Con una cultura de trabajo colaborativo y un ambiente de apoyo, fomentamos el crecimiento profesional y el desarrollo personal de cada miembro de nuestro equipo.

## Licencia

- Este proyecto está bajo la Licencia Creative Commons.

## Contacto

- Para preguntas, comentarios o sugerencias, por favor contáctanos en nuestro repositorio de GitHub: [Proyecto Miga de Oro](https://github.com/Alonso2002-jpg/Project-Panaderia-Laravel)

