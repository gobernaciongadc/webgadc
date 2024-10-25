# gobernacion

Pagina web para la gobernación

Si estás utilizando un framework, como Laravel, asegúrate de que has ejecutado los comandos necesarios para configurar correctamente el almacenamiento de sesiones. Por ejemplo, en Laravel, puedes ejecutar php artisan config:cache para asegurarte de que la configuración esté actualizada y php artisan storage:link para crear un enlace simbólico al directorio de almacenamiento.

php artisan config:cache
php artisan view:cache
php artisan storage:link

bd
und_unidad organigrama null

con_semanarios
img_semanarios

<!-- Para tv en vivo transmisiones -->

CREATE TYPE plataforma_enum AS ENUM ('youtube', 'facebook');
CREATE TYPE estado_enum AS ENUM ('live', 'off');

CREATE TABLE transmisiones (
id SERIAL PRIMARY KEY,
programa VARCHAR(255) NOT NULL,
horario VARCHAR(255) NOT NULL,
descripcion TEXT NOT NULL,
url_youtube VARCHAR(255),
url_facebook VARCHAR(255),
plataforma plataforma_enum NOT NULL,
estado estado_enum NOT NULL DEFAULT 'off',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

<!-- Para gobernacion tv -->

-- Crear el ENUM plataforma_enum y estado_enum
--CREATE TYPE plataforma_enum AS ENUM ('youtube', 'facebook');
--CREATE TYPE estado_enum AS ENUM ('live', 'off');

-- Crear la tabla categoriatv
CREATE TABLE categoriatv (
id SERIAL PRIMARY KEY,
nombre VARCHAR(255) NOT NULL,
descripcion TEXT,
estado estado_enum NOT NULL DEFAULT 'off',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

-- Crear la tabla gobernaciontv
CREATE TABLE gobernaciontvs (
id SERIAL PRIMARY KEY,
programa VARCHAR(255) NOT NULL,
horario VARCHAR(255) NULL,
imagen VARCHAR(255) NULL,
descripcion TEXT NOT NULL,
url_youtube VARCHAR(255),
url_facebook VARCHAR(255),
plataforma plataforma_enum NOT NULL,
estado estado_enum NOT NULL DEFAULT 'off',
categoriatv_id INT REFERENCES categoriatv(id), -- Clave foránea
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

<!-- JAKU -->

-- Crear la tabla jakutv
CREATE TABLE jakutv (
id SERIAL PRIMARY KEY,
nombre VARCHAR(255) NOT NULL,
imagen VARCHAR(255) NOT NULL,
descripcion TEXT,
estado estado_enum NOT NULL DEFAULT 'off',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

-- Crear la tabla gestionjakutv
CREATE TABLE gestionjakutv (
id SERIAL PRIMARY KEY,
nombre VARCHAR(255) NOT NULL,
archivo VARCHAR(255) NOT NULL,
imagen_portada VARCHAR(255) NOT NULL,
estado estado_enum NOT NULL DEFAULT 'off',
categoriatv_id INT REFERENCES jakutv(id), -- Clave foránea
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

<!-- Radio TV -->

-- Crear la tabla jakutv
CREATE TABLE radiotv (
id SERIAL PRIMARY KEY,
url_radio VARCHAR(255) NOT NULL,
descripcion TEXT,
estado estado_enum NOT NULL DEFAULT 'off',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

<!-- Modal INICIO -->

CREATE TABLE modaltv (
id SERIAL PRIMARY KEY,
url_documento VARCHAR(255) NOT NULL,
imagen VARCHAR(255) NOT NULL,
descripcion TEXT,
estado estado_enum NOT NULL DEFAULT 'off',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

<!-- Servicio al ciudadano -->

CREATE TABLE ciudadanotv (
id SERIAL PRIMARY KEY,
url_documento VARCHAR(255) NOT NULL,
imagen VARCHAR(255) NOT NULL,
descripcion TEXT,
estado estado_enum NOT NULL DEFAULT 'live',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);

<!-- InteresTV -->

CREATE TABLE interestv (
id SERIAL PRIMARY KEY,
imagen VARCHAR(255) NOT NULL,
descripcion TEXT,
estado estado_enum NOT NULL DEFAULT 'off',
created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW()
);
