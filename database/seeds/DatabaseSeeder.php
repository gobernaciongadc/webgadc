<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //TIPO UNIDAD
        $tiu_id1 = DB::table('tiu_tipo_unidad')->insertGetId([
            'tipo' => 0,
            'descripcion' => 'Despacho',
            'estado' => 'AC'
        ], 'tiu_id');
        $tiu_id2 = DB::table('tiu_tipo_unidad')->insertGetId([
            'tipo' => 1,
            'descripcion' => 'Secretaria',
            'estado' => 'AC'
        ], 'tiu_id');
        $tiu_id3 = DB::table('tiu_tipo_unidad')->insertGetId([
            'tipo' => 2,
            'descripcion' => 'Dirección',
            'estado' => 'AC'
        ], 'tiu_id');
        $tiu_id4 = DB::table('tiu_tipo_unidad')->insertGetId([
            'tipo' => 3,
            'descripcion' => 'Unidad',
            'estado' => 'AC'
        ], 'tiu_id');
        $tiu_id5 = DB::table('tiu_tipo_unidad')->insertGetId([
            'tipo' => 4,
            'descripcion' => 'Servicio',
            'estado' => 'AC'
        ], 'tiu_id');

        //BIOGRAFIA BASE
        $bio_id1 = DB::table('bio_biografia')->insertGetId([
            'nombres' => 'Esther',
            'apellidos' => 'Soria Gonzáles',
            'imagen_foto' => 'imama.jpg',
            'profesion' => 'Contadora pública y política boliviana',
            'resenia' => 'Esther Soria Gonzales es la nueva gobernadora de Cochabamba, de forma interina, tras la renuncia irrevocable de Iván Jorge Canelas Alurralde. Tras su juramento, prometió dar continuidad a las obras y proyectos programados, y convocó a la pacificación departamental y del país. El 11 de noviembre, Canelas presentó su dimisión formal ante la Asamblea Legislativa Departamental (ALD), aunque día antes confirmó a OPINIÓN esa decisión. Argumentó que dejó el cargo por problemas políticos y con la intención de coadyuvar en la pacificación de la ciudad',
            'estado' => 'AC'
        ], 'bio_id');

        $bio_id2 = DB::table('bio_biografia')->insertGetId([
            'nombres' => 'Roció',
            'apellidos' => 'Molina Travesi',
            'imagen_foto' => 'imama.jpg',
            'profesion' => 'Periodista ',
            'resenia' => 'En el año 2015 fue electa concejal por la ciudad de Cochabamba en representación del Movimiento al Socialismo. Actualmente es Presidenta de la Comisión de la Mujer de este órgano',
            'estado' => 'AC'
        ], 'bio_id');

        //UNIDAD INICIAL
        $und_id1 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Gobierno Autonomo Departamental de Cochabamba',
            'mision' => 'Conceptual y legalmente, la Misión es la razón de ser del Gobierno Autónomo Departamental de Cochabamba, expresada en objetivos permanentes, la misma que se establece en concordancia con el instrumento jurídico de creación de la entidad, así como con la Constitución Política del Estado y otras disposiciones legales sobre la organización del Sector Público.',
            'vision' => 'La visión es la declaración del GADC sobre lo que aspira a ser y sobre las expectativas para el futuro; significa el reto de la institución para cumplir su misión.
             La Visión del órgano ejecutivo Gobierno Autónomo Departamental de Cochabamba',
            'objetivo' => 'El Gobernador del Departamento en el ejercicio de sus atribuciones y competencias, electo por voto universal y directo, armonizará las políticas del  Departamento con las políticas nacionales y optimizará los mecanismos operativos de la Gobernación, con la finalidad de mejorar la eficacia y eficiencia de la provisión de bienes y servicios a la sociedad',
            'historia' => 'Formular políticas y estrategias orientadas a asegurar una gestión pública Institucional eficiente y transparente, promoviendo el desarrollo del Departamento a través de la ejecución de planes, programas y proyectos.',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066',
            'email' => 'gestionsocial@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39430748839804,
            'longitud' => -66.15755438804625,
            'imagen_direccion' => '16075618175fd17259e5ea3.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id1
        ], 'und_id');
        // $this->call(UserSeeder::class);
        $usr1 = DB::table('users')->insertGetId([
            'name' => 'Administrador Pagina',
            'email' => 'admin@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('123123'), // Aquí se genera el hash de "123123"
            'remember_token' => null,
            'created_at' => '2020-10-18 00:00:00',
            'updated_at' => '2020-10-18 00:00:00',
            'estado' => 'AC',
            'und_id' => $und_id1
        ]);

        $tid_tipo_documento1 = DB::table('tid_tipo_documento')->insertGetId([
            'descripcion' => 'Convocatorias',
            'estado' => 'AC'
        ], 'tid_id');
        $tid_tipo_documento2 = DB::table('tid_tipo_documento')->insertGetId([
            'descripcion' => 'Reglamentos',
            'estado' => 'AC'
        ], 'tid_id');
        $tid_tipo_documento3 = DB::table('tid_tipo_documento')->insertGetId([
            'descripcion' => 'Resoluciones',
            'estado' => 'AC'
        ], 'tid_id');

        $tipo_documento_legal1 = DB::table('tdl_tipo_documento_legal')->insertGetId([
            'descripcion' => 'Decretos',
            'estado' => 'AC'
        ], 'tdl_id');
        $tipo_documento_legal2 = DB::table('tdl_tipo_documento_legal')->insertGetId([
            'descripcion' => 'Estatutos',
            'estado' => 'AC'
        ], 'tdl_id');
        $tipo_documento_legal3 = DB::table('tdl_tipo_documento_legal')->insertGetId([
            'descripcion' => 'Leyes',
            'estado' => 'AC'
        ], 'tdl_id');
        $tipo_documento_legal4 = DB::table('tdl_tipo_documento_legal')->insertGetId([
            'descripcion' => 'Resoluciones',
            'estado' => 'AC'
        ], 'tdl_id');


        $par1 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 1,
            'codigo' => 'TIPO-IMAGEN-1',
            'valor1' => '1',
            'valor2' => '1920',
            'valor3' => '480',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par2 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 2,
            'codigo' => 'TIPO-IMAGEN-2',
            'valor1' => '2',
            'valor2' => '1920',
            'valor3' => '470',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par3 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 3,
            'codigo' => 'TIPO-IMAGEN-3',
            'valor1' => '3',
            'valor2' => '1110',
            'valor3' => '470',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par4 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 4,
            'codigo' => 'TIPO-IMAGEN-4',
            'valor1' => '4',
            'valor2' => '1110',
            'valor3' => '350',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par5 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 5,
            'codigo' => 'TIPO-IMAGEN-5',
            'valor1' => '5',
            'valor2' => '850',
            'valor3' => '550',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par6 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 6,
            'codigo' => 'TIPO-IMAGEN-6',
            'valor1' => '6',
            'valor2' => '730',
            'valor3' => '480',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par7 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 7,
            'codigo' => 'TIPO-IMAGEN-7',
            'valor1' => '7',
            'valor2' => '690',
            'valor3' => '220',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par8 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 8,
            'codigo' => 'TIPO-IMAGEN-8',
            'valor1' => '8',
            'valor2' => '600',
            'valor3' => '600',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par9 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 9,
            'codigo' => 'TIPO-IMAGEN-9',
            'valor1' => '9',
            'valor2' => '540',
            'valor3' => '210',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par10 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 10,
            'codigo' => 'TIPO-IMAGEN-10',
            'valor1' => '10',
            'valor2' => '540',
            'valor3' => '170',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par11 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 11,
            'codigo' => 'TIPO-IMAGEN-11',
            'valor1' => '11',
            'valor2' => '450',
            'valor3' => '330',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par12 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 12,
            'codigo' => 'TIPO-IMAGEN-12',
            'valor1' => '12',
            'valor2' => '350',
            'valor3' => '350',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par13 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 13,
            'codigo' => 'TIPO-IMAGEN-13',
            'valor1' => '13',
            'valor2' => '350',
            'valor3' => '210',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par14 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 14,
            'codigo' => 'TIPO-IMAGEN-14',
            'valor1' => '14',
            'valor2' => '350',
            'valor3' => '140',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par15 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 15,
            'codigo' => 'TIPO-IMAGEN-15',
            'valor1' => '15',
            'valor2' => '255',
            'valor3' => '210',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par16 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 16,
            'codigo' => 'TIPO-IMAGEN-16',
            'valor1' => '16',
            'valor2' => '255',
            'valor3' => '165',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par17 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 17,
            'codigo' => 'TIPO-IMAGEN-17',
            'valor1' => '17',
            'valor2' => '255',
            'valor3' => '155',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par18 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 18,
            'codigo' => 'TIPO-IMAGEN-18',
            'valor1' => '18',
            'valor2' => '120',
            'valor3' => '120',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');


        $par19 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 19,
            'codigo' => 'ZOOM-PRODUCTOR-MAPA-1',
            'valor1' => '16',
            'valor2' => '-17.392409',
            'valor3' => '-66.159072',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par20 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 20,
            'codigo' => 'LATITUD-INICIAL-PRODUCTOR',
            'valor1' => '16',
            'valor2' => '-17.392409',
            'valor3' => '-66.159072',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par21 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 21,
            'codigo' => 'LONGITUD-INICIAL-PRODUCTOR',
            'valor1' => '16',
            'valor2' => '-17.392409',
            'valor3' => '-66.159072',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par22 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 22,
            'codigo' => 'MAX-PRODUCTO-IMAGEN',
            'valor1' => '5',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');
        $par23 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 23,
            'codigo' => 'DIAS-PRODUCTO-NUEVO',
            'valor1' => '10',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par24 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 24,
            'codigo' => 'TIPO-IMAGEN-19',
            'valor1' => '19',
            'valor2' => '112',
            'valor3' => '27',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par25 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 25,
            'codigo' => 'TIPO-IMAGEN-20',
            'valor1' => '20',
            'valor2' => '550',
            'valor3' => '850',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par26 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 26,
            'codigo' => 'TIPO-IMAGEN-21',
            'valor1' => '21',
            'valor2' => '164',
            'valor3' => '38',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par27 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 27,
            'codigo' => 'TIPO-IMAGEN-22',
            'valor1' => '22',
            'valor2' => '1100',
            'valor3' => '1700',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par28 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 28,
            'codigo' => 'TIPO-IMAGEN-23',
            'valor1' => '23',
            'valor2' => '1740',
            'valor3' => '900',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par29 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 29,
            'codigo' => 'UNIDAD-PLANIFICACION',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par30 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 30,
            'codigo' => 'UNIDAD-GACETA',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par32 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 31,
            'codigo' => 'TIPO-IMAGEN-24',
            'valor1' => '31',
            'valor2' => '350',
            'valor3' => '170',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par33 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 32,
            'codigo' => 'TIPO-IMAGEN-25',
            'valor1' => '32',
            'valor2' => '350',
            'valor3' => '140',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par34 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 33,
            'codigo' => 'ANCHO-IMAGEN-ORGANIGRAMA',
            'valor1' => '33',
            'valor2' => '800',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par35 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 34,
            'codigo' => 'TIENE-PROGRAMAS',
            'valor1' => '0',
            'valor2' => '0',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par36 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 35,
            'codigo' => 'TIENE-PROYECTOS',
            'valor1' => '0',
            'valor2' => '0',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par37 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 36,
            'codigo' => 'TIENE-DOCUMENTOS',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par38 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 37,
            'codigo' => 'TIENE-DENUNCIAS',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par39 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 38,
            'codigo' => 'TIENE-PUBLICACION-CIENTIFICA',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par40 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 39,
            'codigo' => 'TIENE-ESTADISTICAS',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par41 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 40,
            'codigo' => 'TIENE-EVENTOS',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par42 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 41,
            'codigo' => 'TIENE-SERVICIO-PUBLICO',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par43 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 42,
            'codigo' => 'TIENE-PRODUCTOS',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par44 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 43,
            'codigo' => 'TIENE-UBICACIONES',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        $par45 = DB::table('par_parametrica')->insertGetId([
            'par_id' => 44,
            'codigo' => 'UNIDAD-CONTRATACION',
            'valor1' => '0',
            'valor2' => '',
            'valor3' => '',
            'valor4' => '',
            'valor5' => '',
            'estado' => 'AC'
        ], 'par_id');

        //CONTROL DE ACCESOS Y ROLES
        //MENU 1
        $sis1 = DB::table('sis_sistema')->insertGetId([
            'descripcion' => 'Organización',
            'estado' => 'AC',
            'orden' => 1
        ], 'sis_id');
        $mod1_1 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Despacho',
            'estado' => 'AC',
            'orden' => 1,
            'sis_id' => $sis1
        ], 'mod_id');
        $acc1_1_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 73,
            'mod_id' => $mod1_1
        ], 'acc_id');
        $acc1_1_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 2,
            'codigo' => 74,
            'mod_id' => $mod1_1
        ], 'acc_id');
        $mod1_2 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Secretarias',
            'estado' => 'AC',
            'orden' => 2,
            'sis_id' => $sis1
        ], 'mod_id');
        $acc1_2_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 75,
            'mod_id' => $mod1_2
        ], 'acc_id');
        $acc1_2_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 76,
            'mod_id' => $mod1_2
        ], 'acc_id');
        $acc1_2_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 77,
            'mod_id' => $mod1_2
        ], 'acc_id');
        $acc1_2_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Inhabilitar',
            'estado' => 'AC',
            'operacion' => 'Inhabilitar',
            'orden' => 4,
            'codigo' => 78,
            'mod_id' => $mod1_2
        ], 'acc_id');
        $acc1_2_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Mapa Organigrama',
            'estado' => 'AC',
            'operacion' => 'Mapa Organigrama',
            'orden' => 5,
            'codigo' => 79,
            'mod_id' => $mod1_2
        ], 'acc_id');
        $mod1_3 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Direcciones',
            'estado' => 'AC',
            'orden' => 3,
            'sis_id' => $sis1
        ], 'mod_id');
        $acc1_3_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 80,
            'mod_id' => $mod1_3
        ], 'acc_id');
        $acc1_3_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 81,
            'mod_id' => $mod1_3
        ], 'acc_id');
        $acc1_3_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 82,
            'mod_id' => $mod1_3
        ], 'acc_id');
        $acc1_3_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Inhabilitar',
            'estado' => 'AC',
            'operacion' => 'Inhabilitar',
            'orden' => 4,
            'codigo' => 83,
            'mod_id' => $mod1_3
        ], 'acc_id');
        $acc1_3_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Mapa Organigrama',
            'estado' => 'AC',
            'operacion' => 'Mapa Organigrama',
            'orden' => 5,
            'codigo' => 84,
            'mod_id' => $mod1_3
        ], 'acc_id');
        $mod1_4 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Unidades',
            'estado' => 'AC',
            'orden' => 4,
            'sis_id' => $sis1
        ], 'mod_id');
        $acc1_4_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 85,
            'mod_id' => $mod1_4
        ], 'acc_id');
        $acc1_4_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 86,
            'mod_id' => $mod1_4
        ], 'acc_id');
        $acc1_4_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 87,
            'mod_id' => $mod1_4
        ], 'acc_id');
        $acc1_4_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Inhabilitar',
            'estado' => 'AC',
            'operacion' => 'Inhabilitar',
            'orden' => 4,
            'codigo' => 88,
            'mod_id' => $mod1_4
        ], 'acc_id');
        $acc1_4_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Mapa Organigrama',
            'estado' => 'AC',
            'operacion' => 'Mapa Organigrama',
            'orden' => 5,
            'codigo' => 89,
            'mod_id' => $mod1_4
        ], 'acc_id');
        $mod1_5 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Servicios',
            'estado' => 'AC',
            'orden' => 5,
            'sis_id' => $sis1
        ], 'mod_id');
        $acc1_5_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 90,
            'mod_id' => $mod1_5
        ], 'acc_id');
        $acc1_5_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 91,
            'mod_id' => $mod1_5
        ], 'acc_id');
        $acc1_5_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 92,
            'mod_id' => $mod1_5
        ], 'acc_id');
        $acc1_5_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Inhabilitar',
            'estado' => 'AC',
            'operacion' => 'Inhabilitar',
            'orden' => 4,
            'codigo' => 93,
            'mod_id' => $mod1_5
        ], 'acc_id');
        $acc1_5_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Mapa Organigrama',
            'estado' => 'AC',
            'operacion' => 'Mapa Organigrama',
            'orden' => 5,
            'codigo' => 94,
            'mod_id' => $mod1_5
        ], 'acc_id');
        //MENU 2
        $sis2 = DB::table('sis_sistema')->insertGetId([
            'descripcion' => 'Mi Unidad',
            'estado' => 'AC',
            'orden' => 2
        ], 'sis_id');
        $mod2_1 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Mi Unidad',
            'estado' => 'AC',
            'orden' => 1,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_1_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 1,
            'codigo' => 1,
            'mod_id' => $mod2_1
        ], 'acc_id');
        $mod2_2 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Galería Imágenes',
            'estado' => 'AC',
            'orden' => 2,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_2_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 2,
            'mod_id' => $mod2_2
        ], 'acc_id');
        $acc2_2_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 3,
            'mod_id' => $mod2_2
        ], 'acc_id');
        $acc2_2_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 4,
            'mod_id' => $mod2_2
        ], 'acc_id');
        $acc2_2_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 5,
            'mod_id' => $mod2_2
        ], 'acc_id');
        $acc2_2_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 6,
            'mod_id' => $mod2_2
        ], 'acc_id');
        $mod2_3 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Noticias',
            'estado' => 'AC',
            'orden' => 3,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_3_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 7,
            'mod_id' => $mod2_3
        ], 'acc_id');
        $acc2_3_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 8,
            'mod_id' => $mod2_3
        ], 'acc_id');
        $acc2_3_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 9,
            'mod_id' => $mod2_3
        ], 'acc_id');
        $acc2_3_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 10,
            'mod_id' => $mod2_3
        ], 'acc_id');
        $acc2_3_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 11,
            'mod_id' => $mod2_3
        ], 'acc_id');
        $acc2_3_6 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista de Imágenes',
            'estado' => 'AC',
            'operacion' => 'Lista de Imágenes',
            'orden' => 6,
            'codigo' => 12,
            'mod_id' => $mod2_3
        ], 'acc_id');
        $mod2_4 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Videos y Audios',
            'estado' => 'AC',
            'orden' => 4,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_4_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 13,
            'mod_id' => $mod2_4
        ], 'acc_id');
        $acc2_4_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 14,
            'mod_id' => $mod2_4
        ], 'acc_id');
        $acc2_4_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 15,
            'mod_id' => $mod2_4
        ], 'acc_id');
        $acc2_4_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 16,
            'mod_id' => $mod2_4
        ], 'acc_id');
        $acc2_4_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 17,
            'mod_id' => $mod2_4
        ], 'acc_id');
        $mod2_5 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Convocatorias',
            'estado' => 'AC',
            'orden' => 5,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_5_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 18,
            'mod_id' => $mod2_5
        ], 'acc_id');
        $acc2_5_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 19,
            'mod_id' => $mod2_5
        ], 'acc_id');
        $acc2_5_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 20,
            'mod_id' => $mod2_5
        ], 'acc_id');
        $acc2_5_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 21,
            'mod_id' => $mod2_5
        ], 'acc_id');
        $acc2_5_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 22,
            'mod_id' => $mod2_5
        ], 'acc_id');
        $mod2_6 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Estadisticas',
            'estado' => 'AC',
            'orden' => 6,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_6_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 23,
            'mod_id' => $mod2_6
        ], 'acc_id');
        $acc2_6_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 24,
            'mod_id' => $mod2_6
        ], 'acc_id');
        $acc2_6_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 25,
            'mod_id' => $mod2_6
        ], 'acc_id');
        $acc2_6_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 26,
            'mod_id' => $mod2_6
        ], 'acc_id');
        $acc2_6_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 27,
            'mod_id' => $mod2_6
        ], 'acc_id');
        $mod2_7 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Eventos',
            'estado' => 'AC',
            'orden' => 7,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_7_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 28,
            'mod_id' => $mod2_7
        ], 'acc_id');
        $acc2_7_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 29,
            'mod_id' => $mod2_7
        ], 'acc_id');
        $acc2_7_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 30,
            'mod_id' => $mod2_7
        ], 'acc_id');
        $acc2_7_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 31,
            'mod_id' => $mod2_7
        ], 'acc_id');
        $acc2_7_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 32,
            'mod_id' => $mod2_7
        ], 'acc_id');
        $mod2_8 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Documentos Legales',
            'estado' => 'AC',
            'orden' => 8,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_8_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 33,
            'mod_id' => $mod2_8
        ], 'acc_id');
        $acc2_8_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 34,
            'mod_id' => $mod2_8
        ], 'acc_id');
        $acc2_8_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 35,
            'mod_id' => $mod2_8
        ], 'acc_id');
        $acc2_8_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 36,
            'mod_id' => $mod2_8
        ], 'acc_id');
        $acc2_8_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 37,
            'mod_id' => $mod2_8
        ], 'acc_id');
        $mod2_9 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Documentos',
            'estado' => 'AC',
            'orden' => 9,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_9_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 38,
            'mod_id' => $mod2_9
        ], 'acc_id');
        $acc2_9_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 39,
            'mod_id' => $mod2_9
        ], 'acc_id');
        $acc2_9_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 40,
            'mod_id' => $mod2_9
        ], 'acc_id');
        $acc2_9_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 41,
            'mod_id' => $mod2_9
        ], 'acc_id');
        $acc2_9_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 42,
            'mod_id' => $mod2_9
        ], 'acc_id');
        $mod2_10 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Publicaciones',
            'estado' => 'AC',
            'orden' => 10,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_10_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 43,
            'mod_id' => $mod2_10
        ], 'acc_id');
        $acc2_10_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 44,
            'mod_id' => $mod2_10
        ], 'acc_id');
        $acc2_10_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 45,
            'mod_id' => $mod2_10
        ], 'acc_id');
        $acc2_10_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 46,
            'mod_id' => $mod2_10
        ], 'acc_id');
        $acc2_10_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 47,
            'mod_id' => $mod2_10
        ], 'acc_id');
        $mod2_11 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Guía Tramites',
            'estado' => 'AC',
            'orden' => 11,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_11_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 48,
            'mod_id' => $mod2_11
        ], 'acc_id');
        $acc2_11_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 49,
            'mod_id' => $mod2_11
        ], 'acc_id');
        $acc2_11_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 50,
            'mod_id' => $mod2_11
        ], 'acc_id');
        $acc2_11_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 51,
            'mod_id' => $mod2_11
        ], 'acc_id');
        $acc2_11_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 52,
            'mod_id' => $mod2_11
        ], 'acc_id');
        $mod2_12 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Servicios Públicos',
            'estado' => 'AC',
            'orden' => 12,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_12_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 53,
            'mod_id' => $mod2_12
        ], 'acc_id');
        $acc2_12_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 54,
            'mod_id' => $mod2_12
        ], 'acc_id');
        $acc2_12_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 55,
            'mod_id' => $mod2_12
        ], 'acc_id');
        $acc2_12_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 56,
            'mod_id' => $mod2_12
        ], 'acc_id');
        $acc2_12_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 57,
            'mod_id' => $mod2_12
        ], 'acc_id');
        $mod2_13 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Programas',
            'estado' => 'AC',
            'orden' => 13,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_13_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 58,
            'mod_id' => $mod2_13
        ], 'acc_id');
        $acc2_13_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 59,
            'mod_id' => $mod2_13
        ], 'acc_id');
        $acc2_13_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 60,
            'mod_id' => $mod2_13
        ], 'acc_id');
        $acc2_13_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 61,
            'mod_id' => $mod2_13
        ], 'acc_id');
        $acc2_13_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 62,
            'mod_id' => $mod2_13
        ], 'acc_id');
        $mod2_14 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Productos',
            'estado' => 'AC',
            'orden' => 14,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_14_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 63,
            'mod_id' => $mod2_14
        ], 'acc_id');
        $acc2_14_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 64,
            'mod_id' => $mod2_14
        ], 'acc_id');
        $acc2_14_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 65,
            'mod_id' => $mod2_14
        ], 'acc_id');
        $acc2_14_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 66,
            'mod_id' => $mod2_14
        ], 'acc_id');
        $acc2_14_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 67,
            'mod_id' => $mod2_14
        ], 'acc_id');
        $mod2_15 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Rendición de Cuentas',
            'estado' => 'AC',
            'orden' => 15,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_15_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 68,
            'mod_id' => $mod2_15
        ], 'acc_id');
        $acc2_15_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 69,
            'mod_id' => $mod2_15
        ], 'acc_id');
        $acc2_15_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 70,
            'mod_id' => $mod2_15
        ], 'acc_id');
        $acc2_15_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 71,
            'mod_id' => $mod2_15
        ], 'acc_id');
        $acc2_15_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 72,
            'mod_id' => $mod2_15
        ], 'acc_id');
        $mod2_16 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Proyectos',
            'estado' => 'AC',
            'orden' => 16,
            'sis_id' => $sis2
        ], 'mod_id');
        $acc2_16_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 153,
            'mod_id' => $mod2_16
        ], 'acc_id');
        $acc2_16_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 154,
            'mod_id' => $mod2_16
        ], 'acc_id');
        $acc2_16_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 155,
            'mod_id' => $mod2_16
        ], 'acc_id');
        $acc2_16_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 156,
            'mod_id' => $mod2_16
        ], 'acc_id');
        $acc2_16_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 157,
            'mod_id' => $mod2_16
        ], 'acc_id');
        //MENU 3
        $sis3 = DB::table('sis_sistema')->insertGetId([
            'descripcion' => 'Administración',
            'estado' => 'AC',
            'orden' => 3
        ], 'sis_id');
        $mod3_1 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Sugerencias',
            'estado' => 'AC',
            'orden' => 1,
            'sis_id' => $sis3
        ], 'mod_id');
        $acc3_1_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 95,
            'mod_id' => $mod3_1
        ], 'acc_id');
        $acc3_1_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Ver',
            'estado' => 'AC',
            'operacion' => 'Ver',
            'orden' => 2,
            'codigo' => 96,
            'mod_id' => $mod3_1
        ], 'acc_id');
        $mod3_2 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Denuncias',
            'estado' => 'AC',
            'orden' => 2,
            'sis_id' => $sis3
        ], 'mod_id');
        $acc3_2_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 97,
            'mod_id' => $mod3_2
        ], 'acc_id');
        $acc3_2_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Ver',
            'estado' => 'AC',
            'operacion' => 'Ver',
            'orden' => 2,
            'codigo' => 98,
            'mod_id' => $mod3_2
        ], 'acc_id');
        $mod3_3 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Encuestas',
            'estado' => 'AC',
            'orden' => 3,
            'sis_id' => $sis3
        ], 'mod_id');
        $acc3_3_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 99,
            'mod_id' => $mod3_3
        ], 'acc_id');
        $acc3_3_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 100,
            'mod_id' => $mod3_3
        ], 'acc_id');
        $acc3_3_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 101,
            'mod_id' => $mod3_3
        ], 'acc_id');
        $acc3_3_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 102,
            'mod_id' => $mod3_3
        ], 'acc_id');
        $acc3_3_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 103,
            'mod_id' => $mod3_3
        ], 'acc_id');
        $acc3_3_6 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Ver Resultados',
            'estado' => 'AC',
            'operacion' => 'Ver Resultados',
            'orden' => 6,
            'codigo' => 104,
            'mod_id' => $mod3_3
        ], 'acc_id');
        $mod3_4 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Planes',
            'estado' => 'AC',
            'orden' => 4,
            'sis_id' => $sis3
        ], 'mod_id');
        $acc3_4_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 105,
            'mod_id' => $mod3_4
        ], 'acc_id');
        $acc3_4_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 106,
            'mod_id' => $mod3_4
        ], 'acc_id');
        $acc3_4_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 107,
            'mod_id' => $mod3_4
        ], 'acc_id');
        $acc3_4_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 108,
            'mod_id' => $mod3_4
        ], 'acc_id');
        $acc3_4_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 109,
            'mod_id' => $mod3_4
        ], 'acc_id');
        $mod3_5 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Sistemas de Apoyo',
            'estado' => 'AC',
            'orden' => 5,
            'sis_id' => $sis3
        ], 'mod_id');
        $acc3_5_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 110,
            'mod_id' => $mod3_5
        ], 'acc_id');
        $acc3_5_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 111,
            'mod_id' => $mod3_5
        ], 'acc_id');
        $acc3_5_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 112,
            'mod_id' => $mod3_5
        ], 'acc_id');
        $acc3_5_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 113,
            'mod_id' => $mod3_5
        ], 'acc_id');
        $acc3_5_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 114,
            'mod_id' => $mod3_5
        ], 'acc_id');
        $mod3_6 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Publicidad',
            'estado' => 'AC',
            'orden' => 6,
            'sis_id' => $sis3
        ], 'mod_id');
        $acc3_6_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 115,
            'mod_id' => $mod3_6
        ], 'acc_id');
        $acc3_6_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 116,
            'mod_id' => $mod3_6
        ], 'acc_id');
        $acc3_6_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 117,
            'mod_id' => $mod3_6
        ], 'acc_id');
        $acc3_6_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 118,
            'mod_id' => $mod3_6
        ], 'acc_id');
        $acc3_6_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Inhabilitar',
            'estado' => 'AC',
            'operacion' => 'Inhabilitar',
            'orden' => 5,
            'codigo' => 119,
            'mod_id' => $mod3_6
        ], 'acc_id');
        //MENU 4
        $sis4 = DB::table('sis_sistema')->insertGetId([
            'descripcion' => 'Tipologías',
            'estado' => 'AC',
            'orden' => 4
        ], 'sis_id');
        $mod4_1 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Biografías',
            'estado' => 'AC',
            'orden' => 1,
            'sis_id' => $sis4
        ], 'mod_id');
        $acc4_1_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 120,
            'mod_id' => $mod4_1
        ], 'acc_id');
        $acc4_1_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 121,
            'mod_id' => $mod4_1
        ], 'acc_id');
        $acc4_1_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 122,
            'mod_id' => $mod4_1
        ], 'acc_id');
        $acc4_1_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 4,
            'codigo' => 123,
            'mod_id' => $mod4_1
        ], 'acc_id');
        $mod4_2 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Hoy en la Historia',
            'estado' => 'AC',
            'orden' => 2,
            'sis_id' => $sis4
        ], 'mod_id');
        $acc4_2_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 124,
            'mod_id' => $mod4_2
        ], 'acc_id');
        $acc4_2_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 125,
            'mod_id' => $mod4_2
        ], 'acc_id');
        $acc4_2_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 126,
            'mod_id' => $mod4_2
        ], 'acc_id');
        $acc4_2_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 127,
            'mod_id' => $mod4_2
        ], 'acc_id');
        $acc4_2_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 128,
            'mod_id' => $mod4_2
        ], 'acc_id');
        $mod4_3 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Preguntas Frecuentes',
            'estado' => 'AC',
            'orden' => 3,
            'sis_id' => $sis4
        ], 'mod_id');
        $acc4_3_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 129,
            'mod_id' => $mod4_3
        ], 'acc_id');
        $acc4_3_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 130,
            'mod_id' => $mod4_3
        ], 'acc_id');
        $acc4_3_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 131,
            'mod_id' => $mod4_3
        ], 'acc_id');
        $acc4_3_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 132,
            'mod_id' => $mod4_3
        ], 'acc_id');
        $acc4_3_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 133,
            'mod_id' => $mod4_3
        ], 'acc_id');
        $mod4_4 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Agenda Oficial',
            'estado' => 'AC',
            'orden' => 4,
            'sis_id' => $sis4
        ], 'mod_id');
        $acc4_4_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 134,
            'mod_id' => $mod4_4
        ], 'acc_id');
        $acc4_4_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 135,
            'mod_id' => $mod4_4
        ], 'acc_id');
        $acc4_4_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 136,
            'mod_id' => $mod4_4
        ], 'acc_id');
        $acc4_4_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Publicar',
            'estado' => 'AC',
            'operacion' => 'Publicar',
            'orden' => 4,
            'codigo' => 137,
            'mod_id' => $mod4_4
        ], 'acc_id');
        $acc4_4_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 5,
            'codigo' => 138,
            'mod_id' => $mod4_4
        ], 'acc_id');
        $mod4_5 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Ubicaciones',
            'estado' => 'AC',
            'orden' => 5,
            'sis_id' => $sis4
        ], 'mod_id');
        $acc4_5_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 139,
            'mod_id' => $mod4_5
        ], 'acc_id');
        $acc4_5_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 140,
            'mod_id' => $mod4_5
        ], 'acc_id');
        $acc4_5_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 141,
            'mod_id' => $mod4_5
        ], 'acc_id');
        $acc4_5_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 4,
            'codigo' => 142,
            'mod_id' => $mod4_5
        ], 'acc_id');
        //MENU 5
        $sis5 = DB::table('sis_sistema')->insertGetId([
            'descripcion' => 'Usuarios',
            'estado' => 'AC',
            'orden' => 5
        ], 'sis_id');
        $mod5_1 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Roles',
            'estado' => 'AC',
            'orden' => 1,
            'sis_id' => $sis5
        ], 'mod_id');
        $acc5_1_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 143,
            'mod_id' => $mod5_1
        ], 'acc_id');
        $acc5_1_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 144,
            'mod_id' => $mod5_1
        ], 'acc_id');
        $acc5_1_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 145,
            'mod_id' => $mod5_1
        ], 'acc_id');
        $acc5_1_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Eliminar',
            'estado' => 'AC',
            'operacion' => 'Eliminar',
            'orden' => 4,
            'codigo' => 146,
            'mod_id' => $mod5_1
        ], 'acc_id');
        $mod5_2 = DB::table('mod_modulo')->insertGetId([
            'descripcion' => 'Usuarios',
            'estado' => 'AC',
            'orden' => 1,
            'sis_id' => $sis5
        ], 'mod_id');
        $acc5_2_1 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Lista',
            'estado' => 'AC',
            'operacion' => 'Lista',
            'orden' => 1,
            'codigo' => 147,
            'mod_id' => $mod5_2
        ], 'acc_id');
        $acc5_2_2 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Agregar',
            'estado' => 'AC',
            'operacion' => 'Agregar',
            'orden' => 2,
            'codigo' => 148,
            'mod_id' => $mod5_2
        ], 'acc_id');
        $acc5_2_3 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Editar',
            'estado' => 'AC',
            'operacion' => 'Editar',
            'orden' => 3,
            'codigo' => 149,
            'mod_id' => $mod5_2
        ], 'acc_id');
        $acc5_2_4 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Cambiar Contraseña',
            'estado' => 'AC',
            'operacion' => 'Cambiar Contraseña',
            'orden' => 4,
            'codigo' => 150,
            'mod_id' => $mod5_2
        ], 'acc_id');
        $acc5_2_5 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Roles',
            'estado' => 'AC',
            'operacion' => 'Roles',
            'orden' => 5,
            'codigo' => 151,
            'mod_id' => $mod5_2
        ], 'acc_id');
        $acc5_2_6 = DB::table('acc_acceso')->insertGetId([
            'descripcion' => 'Inhabilitar',
            'estado' => 'AC',
            'operacion' => 'Inhabilitar',
            'orden' => 6,
            'codigo' => 152,
            'mod_id' => $mod5_2
        ], 'acc_id');
        //END CONTROL DE ACCESOS Y ROLES

        //UNIDADES
        $und_id2 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Planificación',
            'mision' => 'La Secretaria Departamental de Planificación, se constituye en la principal instancia del Órgano Ejecutivo Departamental, que lleva adelante los procesos de planificación departamental, territo­rial e institucional, garantizando la integralidad y participación de los actores sociales, productivos e instituciones.',
            'vision' => 'Por otro lado articula la planificación departa­mental, regional y municipal, apoyando al mejora­miento de las capacidades de inversión y progra­mación de operaciones.',
            'objetivo' => '’Planificar, coordinar y promover el desarrollo integral del Departamento de Cochabamba, mediante la elaboración, seguimiento y evaluación del Plan de Desarrollo Departamental, Plan de Ordenamiento Territorial y el Plan Estratégico Institucional en coordinación con las demás Secretarías Departamentales, Entidades Territoriales Autónomas, Organizaciones Sociales, Comunitarias, Productivas, Entidades Privadas, Entidades Descentralizadas y Desconcentradas Nacionales',
            'historia' => 'Historia de Secretaria',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066',
            'email' => 'planificacion@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '1.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id3 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Finanzas y Administración',
            'mision' => 'La Secretaría Departamental de Finanzas y Administración, es el principal brazo financiero y administrativo del Órgano Ejecutivo del Gobierno, coordina e implementa con todas las secretarías departamentales, las políticas dirigidas a generar ingresos y recaudaciones para impulsar el desarrollo integral, la elaboración de presupuestos de cada gestión; además de realizar conjuntamente proyectos tecnológicos  y actualización de los diferentes programas y sistemas que se utilizan en la institución',
            'vision' => 'Bajo su responsabilidad está el presupuesto de recursos y gastos, la contabilidad financiera, la administración del sistema de tesorería y crédito público. También se encarga de realizar gestiones de financiamiento y de administración de los recursos de uso y dominio departamental; además de asesorar a la gobernación en los ámbitos administrativo, económico y financiero',
            'objetivo' => 'Aplicar políticas nacionales y departamentales en la gestión administrativa y financiera, aplicando los Subsistemas de Administración Gubernamental establecidos por la Ley 1178 y otras disposiciones y normativas conexas, que sean de competencia de la Gobernación, administrando eficientemente lo recursos humanos, materiales, económicos y financieros del Gobierno Autónomo Departamental.',
            'historia' => 'Historia de Secretaria',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '2.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');


        $und_id4 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Desarrollo Humano Integral',
            'mision' => 'La Secretaría Departamental de Desarrollo Humano, dirige los siguientes servicios departamentales: el Servicio departamentalde Gestión Social (SEDEGES), el Servicio Departamental de Salud (SEDES) y el servicio Departamental Del Deporte (SEDEDE), también coordina y supervisa las actividades que desarrolla el Complejo Hospitalario Viedma.',
            'vision' => 'Implementa y promueve políticas y acciones que colaboran a la: despatriarcalización,protección, mantenimiento y promoción del patrimonio cultural departamental',
            'objetivo' => 'Implementar políticas y acciones con igualdad de oportunidades, en gestión social, salud, educación, deportes, cultura e interculturalidad, en el marco del proceso de descolonización, despatriarcalización y complementariedad, que coadyuven a vivir bien',
            'historia' => 'historia de Secretaría',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '4.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066’',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id5 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Coordinación General',
            'mision' => 'La Secretaría Departamental de Coordinación General',
            'vision' => 'vision de secretaria',
            'objetivo' => 'objetivo de despacho',
            'historia' => 'Historia de Secretaria',
            'organigrama' => '2.jpg',
            'imagen_icono' => '4.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '4444444-4555555',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id6 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Desarrollo Productivo y Economía Plural',
            'mision' => 'Desarrollar políticas, planes, programas y proyectos de apoyo y fomento a los sectores agrícola, pecuario, industrial, hidrocarburífero y turístico, en base al modelo de economía plural y en aplicación de las directrices previstas en el Plan Nacional de Desarrollo, los Planes Sectoriales y el Plan  Departamental de Cochabamba',
            'vision' => 'Desarrollar políticas, planes, programas y proyectos de apoyo y fomento a los sectores agrícola, pecuario, industrial, hidrocarburífero y turístico, en base al modelo de economía plural y en aplicación de las directrices previstas en el Plan Nacional de Desarrollo, los Planes Sectoriales y el Plan  Departamental de Cochabamba',
            'objetivo' => 'Esta Secretaría tiene por objetivo desarrollar y potenciar las capacidades productivas de la economía plural del departamento en el marco de la complementariedad para generar mayores excedentes, ingresos y empleo para el desarrollo departamental, bajo el enfoque integral y complementario entre las regiones y al interior de ellas',
            'historia' => 'historia de despacho',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066',
            'email' => 'despacho@gmail.com',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');


        //UNIDAD INICIAL
        $und_id7 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Minería',
            'mision' => 'Instancia ejecutiva, técnica,  operativa, administrativa y especializada, dependiente del Gobierno Autónomo Departamental, responsable de generar políticas, programas y proyectos estratégicos, efectuar el control, fiscalización y administración de la regalía minera, prestar asistencia técnica y medioambiental que promueve el fortalecimiento tecnológico de la actividad minero metalúrgica, en el marco de la política minera nacional, con eficiencia, eficacia y transparencia, con la participación de los operadores y población del departamento',
            'vision' => 'Líder en la generación de políticas públicas para el sector minero y pilar fundamental del desarrollo del departamento que impulsa la industrialización a través de proyectos integrales, sustentables y de alto impacto, con oportunidad, calidad técnica e innovadora, para una gestión eficiente, eficaz y transparente, con personal idóneo y comprometido',
            'objetivo' => 'Promover el desarrollo de la industria minera en el Departamento’',
            'historia' => 'historia de despacho',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066',
            'email' => 'mineria@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');

        //UNIDAD INICIAL
        $und_id8 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de los Derechos de la Madre Tierra',
            'mision' => 'La Secretaria Departamental de los Derechos de la Madre Tierra, desarrolla sus funciones, promoviendo el manejo integral de los recursos naturales, la preservación,conservación, mejoramiento y restauración de la biodiversidad, la gestión y el control de la calidad ambiental, el manejo integral de los recursos hídricos y la gestión de riesgos y cambio climático del Departamento de Cochabamba’',
            'vision' => 'Instancia que formula, dirigey aplica la política ambiental departamental y nacional, en recursos naturales, medio ambiente, gestión del agua y los derechos de la Madre Tierra, en concordancia con la política nacional y los planes departamentales de desarrollo y ordenamiento territorial',
            'objetivo' => 'Coordinar la formulación, implementación, seguimiento y evaluación de políticas de conservación y aprovechamiento sostenible de los Recursos Naturales, Forestales, Áreas Protegidas y Gestión y Control Ambiental para el vivir bien del pueblo cochabambino’',
            'historia' => 'Historia de Secretaria',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'madretierra@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id9 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Secretaría Departamental de Obras y Servicios',
            'mision' => 'La Secretaría Departamental de Obras y Servicios, es la instancia que propone proyectos de ley y decretos departamentales en el sector de obras y servicios, ya sean de infraestructura física vial, ferroviaria, aeroportuaria o de transporte departamental, electrificación rural, vivienda y otros servicios básicos, para el desarrollo económico y social del departamento.',
            'vision' => 'Realiza un estudio de preinversión para cooperar al desarrollo en el marco de las disposiciones de las Normas Básicas del Sistema Nacional de Inversión Pública; de esta manera regula y hace un seguimiento a los emprendimientos e inversiones que realiza el Gobierno Central en el departamento, en proyectos vinculados a su competencia',
            'objetivo' => 'Realiza un estudio de preinversión para cooperar al desarrollo en el marco de las disposiciones de las Normas Básicas del Sistema Nacional de Inversión Pública; de esta manera regula y hace un seguimiento a los emprendimientos e inversiones que realiza el Gobierno Central en el departamento, en proyectos vinculados a su competencia',
            'historia' => 'Historia de Secretaria',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'madretierra@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id2,
            'und_padre_id' => $und_id1
        ], 'und_id');
        ///----------------------SERVICIOS-------------------------------------
        $und_id10 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Servicio Departamental de Gestión Social',
            'mision' => 'El Servicio Departamental de Gestión Social  a nivel departamental y en el ámbito de su competencia, tiene como misión fundamental la de aplicar las políticas y normas nacionales, emitidas por el órgano competente, sobre asuntos de género, generacionales, familia y servicios sociales, mediante el apoyo técnico a las instancias responsables y la supervisión del cumplimiento de los objetivos y resultados propuestos, así como la de coordinar los programas y proyectos en materia de gestión social',
            'vision' => 'El Servicio Departamental de Gestión Social  de Cochabamba, será una institución técnica de alto desempeño, reconocida a nivel departamental  y nacional a través de la Red Nacional de Servicios Departamentales de Gestión Social (REDNAGES)  por sus valores y principios, y los grandes logros alcanzados en su labor de proteger a la población más vulnerable  que son nuestros niños, adolescentes y ancianos  del departamento',
            'objetivo' => 'Cumplir y hacer cumplir las políticas y normas establecidas en asuntos de género, generacionales, familia y servicios sociales.',
            'historia' => 'Historia del Servicio',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'gestionsocial@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id5,
            'und_padre_id' => $und_id4
        ], 'und_id');

        $und_id11 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Servicio Departamental del Deporte',
            'mision' => 'El Servicio Departamental del Deporte consolidado en una herramienta de gestión y manejo de los recursos deportivos, eficaz, eficiente  transparente que coadyuve al desarrollo humano, a la formación en valores a una cultura que contribuya a consolidar la identidad y prestigio sobre la base de una perspectiva de gestión, integrada territorialmente, sustentada en los aportes del conocimiento científico, que favorezca la inclusión social y contribuya con deportistas de alto nivel competitivo a las selecciones nacionales e internacionales en diferentes deportes’',
            'vision' => 'Contribuir al fomento y promoción del deporte así como la cultura desarrollando su acción, orientando, promoviendo, asistiendo y fiscalizando las actividades deportivas desarrolladas en el Departamento en conformidad con los planes, programas y proyectos que sobre bases científicas contribuyan al Desarrollo Humano Integral, a la capacidad de trabajo, potencialidades morfo funcionales de los deportistas promoviendo la integración, la inserción social de todos los sectores de la población con la participación de todos los actores de la sociedad civil en igualdad de oportunidades’',
            'objetivo' => 'Poner a consideración del Consejo Departamental del Deporte – CONDEDE, el Plan de Desarrollo Deportivo Departamental – PLADETAL, el cual deberá guardar coherencia programática con los objetivos estratégicos del Plan de Desarrollo Deportivo Nacional – PLADENAL..',
            'historia' => 'historia de servicio',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066’',
            'email' => 'gestionsocial@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id5,
            'und_padre_id' => $und_id4
        ], 'und_id');

        $und_id12 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Servicio Departamental Agropecuario',
            'mision' => 'El SEDAG tiene como misión, mejorar los niveles de producción y productividad agropecuaria y forestal del Departamento, para elevar el nivel de vida de la población rural. Esta misión será realizada mediante la promoción, supervisión y apoyo a las actividades agropecuarias, de desarrollo rural y aprovechamiento de recursos naturales renovables y de desarrollo alternativo, que se ejecutan en el ámbito de su jurisdicción territorial, a través de planes, programas y proyectos Departamentales.',
            'vision' => 'El SEDAG se consolida como la unidad Departamental capaz de promover, articular, integrar y dinamizar a los actores del desarrollo agropecuario y agroindustrial, en el contexto del desarrollo rural, productivo y competitivo de Cochabamba.',
            'objetivo' => 'El Servicio Departamental Agropecuario (SEDAG) como brazo operativo de la Secretaría Departamental de Desarrollo Productivo y Economía Plural del Gobierno Autónomo Departamental de Cochabamba, tiene el agrado de presentar la Memoria Institucional, correspondiente a la gestión 2011, misma que refleja los principales resultados obtenidos en los proyectos administrados por la institución.',
            'historia' => 'historia de despacho',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'gestionsocial@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Cochabamba',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id5,
            'und_padre_id' => $und_id6
        ], 'und_id');

        $und_id13 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Servicio Departamental de Caminos',
            'mision' => 'El SEDCAM',
            'vision' => 'El SEDCAM',
            'objetivo' => 'Mantenimiento de Rutas',
            'historia' => 'Historia del Servicio',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4299379',
            'email' => 'sedcam@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Cochabamba',
            'direccion' => 'Av. Villazon Km 1',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id5,
            'und_padre_id' => $und_id9
        ], 'und_id');

        $und_id14 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Servicio Departamental de Salud',
            'mision' => 'Somos una institución pública, desconcentrada, ejercemos  el rol, normador y rector en salud, cumplimos  y hacemos cumplir las normas en salud a nivel Departamental, en el marco de la constitución Política del estado, para contribuir a mejorar la salud de la población Cochabambina',
            'vision' => 'El Servicio Departamental de Salud Cochabamba es una institución líder del sector salud a nivel nacional ejerciendo rectoría Departamental con participación social, cumpliendo con la Constitución Política del estado, aplicando el Sistema Único de Salud (SUS) a través de la política de Salud Familiar Comunitaria e intercultural (SAFCI), para alcanzar el Vivir bien',
            'objetivo' => 'El Servicio Departamental de Salud (SEDES) es la instancia que desempeña sus funciones de acuerdo a la Constitución Política del Estado, encargada de cumplir con las actividades de Salud a nivel Departamental, de manera que contribuya al bienestar social de nuestro departamento.',
            'historia' => 'Historia del Servicio',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4299379',
            'email' => 'salud@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Cochabamba',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id5,
            'und_padre_id' => $und_id4
        ], 'und_id');


        $und_id15 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Servicio Departamental de Cuencas',
            'mision' => 'El Programa de Manejo Integral de Cuencas (PROMIC), es la instancia que busca reducir los daños causados por las inundaciones periódicas en el valle de Cochabamba, implementando proyectos de manejo integral de cuencas en micro cuencas priorizadas.',
            'vision' => 'El Gobierno Autónomo Departamental de Cochabamba, por mandato constitucional y con el propósito de cumplir la demanda de los municipios y las Organizaciones Sociales, que habitan las diferentes cuencas cochabambinas, tomó la decisión de crear el Servicio Departamental de Cuencas (SDC), como respuesta a la necesidad de relacionamiento de armonía y respeto a la Madre Tierra para “Vivir Bien” ',
            'objetivo' => 'Acondicionamiento hidráulico del cauce principal del rio Rocha desde la confluencia Tacata hasta el sector Pico de Loro Fase I. 2.',
            'historia' => 'Historia del Servicio',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4299379',
            'email' => 'cuencas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Cochabamba',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id5,
            'und_padre_id' => $und_id7
        ], 'und_id');


        //--------------------------   DIRECCION   --------------------------------

        $und_id16 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Asuntos Jurídicos y Normativos',
            'mision' => 'La Dirección de Asuntos Jurídicos y Normativos tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales',
            'vision' => 'La Dirección de Asuntos Jurídicos y Normativos tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales',
            'objetivo' => 'La Dirección de Asuntos Jurídicos y Normativos tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales',
            'historia' => 'La Dirección de Asuntos Jurídicos y Normativos tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4299379',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id1
        ], 'und_id');


        $und_id17 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Auditoria Interna',
            'mision' => 'Dirección de Auditoria Interna',
            'vision' => 'La Dirección de Asuntos Jurídicos y Normativos tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales',
            'objetivo' => 'La Dirección de Asuntos Jurídicos y Normativos tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales',
            'historia' => 'Dirección de Auditoria Interna',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id18 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Relaciones Internacionales',
            'mision' => 'Dirección de Relaciones Internacionales’',
            'vision' => 'La Dirección de Relaciones Internacionales tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales ',
            'objetivo' => 'La Dirección de Relaciones Internacionales tiene los objetivos de asesorar a la Máxima Autoridad Ejecutiva en todos los aspectos jurídicos - legales ',
            'historia' => 'La Dirección de Relaciones Internacionales, tiene los objetivos de relacionar a la Gobernación con pueblos, países, instituciones extranjeras y agencias de cooperación internacional para captar',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id19 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Finanzas',
            'mision' => 'La Dirección Finanzas, es el principal brazo financiero y administrativo del Órgano Ejecutivo del Gobierno, coordina e implementa con todas las secretarías departamentales, las políticas dirigidas a generar ingresos y recaudaciones para impulsar el desarrollo integral, la elaboración de presupuestos de cada gestión; además de realizar conjuntamente proyectos tecnológicos  y actualización de los diferentes programas y sistemas que se utilizan en la institución',
            'vision' => 'Bajo su responsabilidad está el presupuesto de recursos y gastos, la contabilidad financiera, la administración del sistema de tesorería y crédito público. También se encarga de realizar gestiones de financiamiento y de administración de los recursos de uso y dominio departamental; además de asesorar a la gobernación en los ámbitos administrativo, económico y financiero',
            'objetivo' => 'Aplicar políticas nacionales y departamentales en la gestión administrativa y financiera, aplicando los Subsistemas de Administración Gubernamental establecidos por la Ley 1178 y otras disposiciones y normativas conexas, que sean de competencia de la Gobernación, administrando eficientemente lo recursos humanos, materiales, económicos y financieros del Gobierno Autónomo Departamental',
            'historia' => 'La Dirección de Relaciones Internacionales, tiene los objetivos de relacionar a la Gobernación con pueblos, países, instituciones extranjeras y agencias de cooperación internacional para captar',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id3
        ], 'und_id');


        $und_id20 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Administración',
            'mision' => 'La Dirección de Administración, es el principal brazo financiero y administrativo del Órgano Ejecutivo del Gobierno, coordina e implementa con todas las secretarías departamentales, las políticas dirigidas a generar ingresos y recaudaciones para impulsar el desarrollo integral, la elaboración de presupuestos de cada gestión; además de realizar conjuntamente proyectos tecnológicos  y actualización de los diferentes programas y sistemas que se utilizan en la institución',
            'vision' => 'Bajo su responsabilidad está el presupuesto de recursos y gastos, la contabilidad financiera, la administración del sistema de tesorería y crédito público. También se encarga de realizar gestiones de financiamiento y de administración de los recursos de uso y dominio departamental; además de asesorar a la gobernación en los ámbitos administrativo, económico y financiero',
            'objetivo' => 'Aplicar políticas nacionales y departamentales en la gestión administrativa y financiera, aplicando los Subsistemas de Administración Gubernamental establecidos por la Ley 1178 y otras disposiciones y normativas conexas, que sean de competencia de la Gobernación, administrando eficientemente lo recursos humanos, materiales, económicos y financieros del Gobierno Autónomo Departamental ',
            'historia' => 'La Dirección de Finanzas es la encargada de promover mejoras en los procedimientos operativos, elaborando el balance de gestión y los estados contables y financieros necesarios para mostrar los resultados de la gestión presupuestaria patrimonial y económica financiera de la Entidad.',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id4
        ], 'und_id');

        $und_id21 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'La Dirección de Igualdad de Oportunidades',
            'mision' => 'La Dirección de Igualdad de Oportunidades (DIO), se encuentra enmarcada en la propuesta estratégica para la promoción de la Igualdad de Oportunidades y Desarrollo Integral Comunitario, en concordancia con el enfoque y las articulaciones políticas definidas en el Plan Territorial de Desarrollo Departamental (PTDD), dado que las desigualdades afectan en forma diferente, con causas y características específicas a grupos en situación de exclusión identificados, que además de estrategias integrales requieren de estrategias específicas.',
            'vision' => 'Superar toda forma de discriminación, desigualdad y violencia por razones de género, edad, discapacidad o por factores económicos, político - culturales; en el marco del reconocimiento y respeto a las diferencias y necesidades específicas de los diferentes sectores poblacionales como: Mujeres, Niñas, Niños y Adolescentes, Jóvenes, Adulto Mayor, Personas con Discapacidad y otros, permitiendo el ejercicio pleno de los derechos en condiciones de equidad en una sociedad más incluyente y un Estado descolonizado y despatriarcalizado ',
            'objetivo' => 'Implementar políticas y acciones con igualdad de oportunidades, en gestión social, salud, educación, deportes, cultura e interculturalidad, en el marco del proceso de descolonización, despatriarcalización y complementariedad, que coadyuven a vivir bien',
            'historia' => 'La Dirección de Igualdad de Oportunidades (DIO), elabora políticas públicasen favor de la igualdad y el desarrollo integral comunitario, que orienten con una visión futura las acciones de igualdad de oportunidades, de manera transversal e intersectorial, plasmado en el Plan Departamental Integralde Igualdad de Oportunidades (PDIIO), como apoyo a la construcción del Vivir Bien',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id3
        ], 'und_id');

        $und_id22 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Culturas e Inteculturalidad',
            'mision' => 'La Dirección de Culturas e Interculturalidad del Gobierno Autónomo Departamental de Cochabamba es una institución pública que promueve una sociedad inclusiva y plural, mediante el diseño, planificación e implementación de políticas culturales, interculturales y patrimoniales articulando a todos los actores sociales en espacios de encuentro para la creatividad, diversidad e interculturalidad con personal altamente calificado desde una gestión pública con participación social y comunitaria',
            'vision' => 'La Dirección de Culturas e Interculturalidad  del Gobierno Autónomo Departamental de Cochabamba es una institución valorada, fortalecida y consolidada en el departamento como entidad que produce líneas directivas en cuanto a políticas públicas de cultura, interculturalidad y descolonización promoviendo la diversidad y convivencia de la sociedad en pluralidad y armonía',
            'objetivo' => 'Fortalecer las identidades culturales y patrimoniales de los Pueblos indígena originario campesinos, actores culturales, comunidades  y colectivos interculturales de los 47 municipios del Departamento de Cochabamba',
            'historia' => 'La Dirección de Culturas e Interculturalidad,se encarga de formular y desarrollar políticas que contribuyan a que la diversidad cultural y los procesos de descolonización, sean la base del desarrollo departamental, impulsando y difundiendo todas  las manifestaciones culturales generadas en el departamento’',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id4
        ], 'und_id');


        $und_id23 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Integración con Regiones, Municipios y Autonomías',
            'mision' => 'La Dirección de Integración con Regiones, Municipios y Autonomías Indígena Originario Campesinos, es un segmento de la estructura orgánica del Gobierno Autónomo Departamental de Cochabamba, que promueve escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y el Régimen Autónomo Indígena Originario Campesino',
            'vision' => 'Al 2019, DIRMA I.O.C., líder de la gestión pública institucional del Gobierno Autónomo Departamental de Cochabamba, concreta y consolida escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y el Régimen Autónomo Indígena Originario Campesino’',
            'objetivo' => 'Generar escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y Régimen Autónomo Indígena Originario Campesino',
            'historia' => 'La Dirección de Integración con Regiones Municipios y Autonomías es la entidad que se encarga de mejorarlas capacidades institucionales, técnicas y administrativas de los Gobiernos Autónomos Municipales',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id5
        ], 'und_id');

        $und_id24 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Coordinación con Movimientos Sociales',
            'mision' => 'La Dirección de Integración con Regiones, Municipios y Autonomías Indígena Originario Campesinos, es un segmento de la estructura orgánica del Gobierno Autónomo Departamental de Cochabamba, que promueve escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y el Régimen Autónomo Indígena Originario Campesino',
            'vision' => 'Al 2019, DIRMA I.O.C., líder de la gestión pública institucional del Gobierno Autónomo Departamental de Cochabamba, concreta y consolida escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y el Régimen Autónomo Indígena Originario Campesino',
            'objetivo' => 'Generar escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y Régimen Autónomo Indígena Originario Campesino',
            'historia' => 'La Dirección de Coordinación con Movimientos Sociales, impulsa la participación ciudadana y el acceso a la información, elaborando propuestas para organizar encuentros de diálogo, creando mecanismos y sistemas de información comunicacional',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id5
        ], 'und_id');

        $und_id24 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Seguridad Ciudadana',
            'mision' => 'La Dirección de Seguridad Ciudadana, Municipios y Autonomías Indígena Originario Campesinos, es un segmento de la estructura orgánica del Gobierno Autónomo Departamental de Cochabamba, que promueve escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y el Régimen Autónomo Indígena Originario Campesino',
            'vision' => 'Al 2019, DIRMA I.O.C., líder de la gestión pública institucional del Gobierno Autónomo Departamental de Cochabamba, concreta y consolida escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y el Régimen Autónomo Indígena Originario Campesino',
            'objetivo' => 'Generar escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y Régimen Autónomo Indígena Originario Campesino',
            'historia' => 'La Dirección de Seguridad Ciudadana es la entidad establece los mecanismos administrativos internos, para articular las políticas Departamentales de Seguridad Ciudadana con las Unidades Seccionales del Departamento de Cochabamba. Junto  al  Comando Departamental de la Policía, tienen la función de regularizar en la atención adecuada ante la demanda de autoridades locales, departamentales y nacionales',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id5
        ], 'und_id');

        $und_id25 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Turismo',
            'mision' => 'La Dirección de Integración con Regiones, Municipios y Autonomías Indígena Originario Campesinos, es un segmento de la estructura orgánica del Gobierno Autónomo Departamental de Cochabamba, que promueve escenarios de articulación e integración',
            'vision' => 'Al 2019, DIRMA I.O.C., líder de la gestión pública institucional del Gobierno Autónomo Departamental de Cochabamba, concreta y consolida escenarios de articulación e integración',
            'objetivo' => 'Generar escenarios de articulación e integración entre el Gobierno Nacional, Departamental, Municipal, Regional y Régimen Autónomo Indígena Originario Campesino',
            'historia' => 'La Unidad de Turismo es la administradora del Registro Departamental de Turismo, ejerce el control de la actividad turística en el departamento de Cochabamba, regula y supervisa las operaciones de todas las empresas prestadoras de servicios turísticos bajo la aplicación de la legislación turística sectorial',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id6
        ], 'und_id');

        $und_id26 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Planificación Agropecuaria',
            'mision' => 'Desarrollar políticas, planes, programas y proyectos de apoyo y fomento a los sectores agrícola, pecuario, industrial, hidrocarburífero y turístico',
            'vision' => 'Desarrollar políticas, planes, programas y proyectos de apoyo y fomento a los sectores agrícola, pecuario, industrial, hidrocarburífero y turístico’',
            'objetivo' => 'Promover la planificación  del desarrollo productivo agropecuario del Departamento de Cochabamba, identificando y encaminando las necesidades y demandas para generar condiciones adecuadas para el emprendimiento de actividades productivas agropecuarias',
            'historia' => 'La Dirección de Planificación Agropecuaria, es una entidad dependiente de la Secretaría Departamental De Desarrollo Productivo Y Economía Plural, creada con la finalidad de promover y facilitar el diseño e implementación de planes',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id6
        ], 'und_id');

        $und_id27 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Riegos',
            'mision' => 'Gestión y ejecución de programas y proyectos de riego en coordinación con las organizaciones sociales dedicadas al riego',
            'vision' => 'Cochabamba solidaria y productiva, con políticas de desarrollo de riego concertadas con los actores sociales y enfocado para que el riego sea un elemento dinamizador de procesos productivos que garantice la seguridad alimentaria y la generación de empleos “para vivir bien',
            'objetivo' => 'Proponer, definir políticas y estrategias para el desarrollo productivo del sector agropecuario a través de sistemas de riego estratégicos con tecnologías apropiadas.',
            'historia' => 'La Dirección de Riegos es la encargada de generar proyectos de riego para el apoyo al desarrollo agrícola en el departamento de Cochabamba, gestionando así, los recursos económicos internos y externos para la ejecución y supervisión de los mismos',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id6
        ], 'und_id');


        $und_id28 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Hidrocarburos, Desarrollo Industrial y Micro Empresa',
            'mision' => 'Ser el referente Departamental en Desarrollo Hidrocarburífero, Industrial y Tecnológico, articulando e integrando a todas las instituciones Públicas, Privadas y Organizaciones Sociales del Departamento',
            'vision' => 'Formular políticas y estrategias para el desarrollo de la economía plural en los sectores industrial e hidrocarburífero creando a través de la adición de valor agregado e incentivando la complementariedad y reciprocidad',
            'objetivo' => 'Promover el Desarrollo Hidrocarburífero en toda la cadena productiva a través de políticas, programas, proyectos y estrategias que contribuyan a la economía del Departamento garantizando una adecuada fiscalización a los ingresos provenientes de las regalías e IDH y participaciones',
            'historia' => 'La Dirección de Hidrocarburos, Desarrollo Industrial y Micro Empresa desarrolla actividades, de promoción productiva, para el fortalecimiento de las unidades económicas productivas para el Desarrollo Industrial, Microempresarial y Artesanal, realizando las acciones y gestiones correspondientes con los municipios para la elaboración de programas y proyectos productivos',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'desarrollo@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id6
        ], 'und_id');

        $und_id29 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Fortalecimiento Minero',
            'mision' => 'Instancia ejecutiva, técnica,  operativa, administrativa y especializada, dependiente del Gobierno Autónomo Departamental, responsable de generar políticas, programas y proyectos estratégicos, efectuar el control, fiscalización y administración de la regalía minera, prestar asistencia técnica y medioambiental que promueve el fortalecimiento tecnológico de la actividad minero metalúrgica, en el marco de la política minera nacional, con eficiencia, eficacia y transparencia, con la participación de los operadores y población del departamento',
            'vision' => 'Líder en la generación de políticas públicas para el sector minero y pilar fundamental del desarrollo del departamento que impulsa la industrialización a través de proyectos integrales, sustentables y de alto impacto, con oportunidad, calidad técnica e innovadora, para una gestión eficiente, eficaz y transparente, con personal idóneo y comprometido',
            'objetivo' => 'Promover el desarrollo de la industria minera en el Departamento',
            'historia' => 'La Dirección de Fortalecimiento Minero, es la encargada de desempeñar funciones delegadas por instancias superiores, que encomienden  a realizar acciones correspondientes con los municipios para la elaboración de convenios y proyectos productivos concurrentes de minería, propone leyes',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'mineria@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id7
        ], 'und_id');

        $und_id30 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Recursos Naturales y Medio Ambiente',
            'mision' => 'La Secretaria Departamental de los Derechos de la Madre Tierra, desarrolla sus funciones, promoviendo el manejo integral de los recursos naturales',
            'vision' => 'Instancia que formula, dirigey aplica la política ambiental departamental y nacional, en recursos naturales, medio ambiente, gestión del agua y los derechos de la Madre Tierra, en concordancia con la política nacional y los planes departamentales de desarrollo y ordenamiento territorial',
            'objetivo' => 'Coordinar la formulación, implementación, seguimiento y evaluación de políticas de conservación y aprovechamiento sostenible de los Recursos Naturales, Forestales, Áreas Protegidas y Gestión y Control Ambiental para el vivir bien del pueblo cochabambino',
            'historia' => 'La Dirección de Recursos Naturales y Medio Ambiente, es la autoridad ambiental departamental que tiene como objetivo central: Proteger los recursos naturales y precautelar un ambiente saludable para toda la población cochabambina',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'madretierra @gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id8
        ], 'und_id');

        $und_id31 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Planificación y Gestión Integral del Agua',
            'mision' => 'La Secretaria Departamental de los Derechos de la Madre Tierra, desarrolla sus funciones, promoviendo el manejo integral de los recursos naturales',
            'vision' => 'Instancia que formula, dirigey aplica la política ambiental departamental y nacional, en recursos naturales, medio ambiente, gestión del agua y los derechos de la Madre Tierra, en concordancia con la política nacional y los planes departamentales de desarrollo y ordenamiento territorial',
            'objetivo' => 'Coordinar la formulación, implementación, seguimiento y evaluación de políticas de conservación y aprovechamiento sostenible de los Recursos Naturales, Forestales, Áreas Protegidas y Gestión y Control Ambiental para el vivir bien del pueblo cochabambino',
            'historia' => 'La Dirección de Recursos Naturales y Medio Ambiente, es la autoridad ambiental departamental que tiene como objetivo central: Proteger los recursos naturales y precautelar un ambiente saludable para toda la población cochabambina',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'madretierra @gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id8
        ], 'und_id');

        $und_id32 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Obras Civiles',
            'mision' => 'La Secretaría Departamental de Obras y Servicios, es la instancia que propone proyectos de ley y decretos departamentales en el sector de obras y servicios, ya sean de infraestructura física vial, ferroviaria, aeroportuaria o de transporte departamental, electrificación rural, vivienda y otros servicios básicos, para el desarrollo económico y social del departamento.',
            'vision' => 'Realiza un estudio de preinversión para cooperar al desarrollo en el marco de las disposiciones de las Normas Básicas del Sistema Nacional de Inversión Pública; de esta manera regula y hace un seguimiento a los emprendimientos e inversiones que realiza el Gobierno Central en el departamento, en proyectos vinculados a su competencia',
            'objetivo' => 'Realiza un estudio de preinversión para cooperar al desarrollo en el marco de las disposiciones de las Normas Básicas del Sistema Nacional de Inversión Pública; de esta manera regula y hace un seguimiento a los emprendimientos e inversiones que realiza el Gobierno Central en el departamento, en proyectos vinculados a su competencia',
            'historia' => 'La Dirección de Obras Civiles, es la encargada de fiscalizar las obras de construcciones civiles asignadas a la Secretaría Departamental de Obras y Servicios, verificando el cumplimiento de cronogramas de avances físicos y otras condiciones contractuales',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'madretierra @gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id9
        ], 'und_id');


        $und_id33 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Dirección de Transportes y Telecomunicaciones',
            'mision' => 'La Secretaría Departamental de Obras y Servicios, es la instancia que propone proyectos de ley y decretos departamentales en el sector de obras y servicios, ya sean de infraestructura física vial, ferroviaria, aeroportuaria o de transporte departamental, electrificación rural, vivienda y otros servicios básicos, para el desarrollo económico y social del departamento',
            'vision' => 'Realiza un estudio de preinversión para cooperar al desarrollo en el marco de las disposiciones de las Normas Básicas del Sistema Nacional de Inversión Pública; de esta manera regula y hace un seguimiento a los emprendimientos e inversiones que realiza el Gobierno Central en el departamento, en proyectos vinculados a su competencia',
            'objetivo' => 'Realiza un estudio de preinversión para cooperar al desarrollo en el marco de las disposiciones de las Normas Básicas del Sistema Nacional de Inversión Pública; de esta manera regula y hace un seguimiento a los emprendimientos e inversiones que realiza el Gobierno Central en el departamento, en proyectos vinculados a su competencia',
            'historia' => 'La Dirección de Transportes y Telecomunicaciones, es la entidad que toma conocimiento y que coordina acciones con instituciones públicas nacionales y empresas nacionales sobre temas de transportes y telecomunicaciones en el ámbito departamental',
            'organigrama' => 'imagenorganigrama.jpg',
            'imagen_icono' => '16075618175fd17259e5ea3.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'madretierra@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.37390073150918,
            'longitud' => -66.12836060311132,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id3,
            'und_padre_id' => $und_id9
        ], 'und_id');
        //UNIDADES------------------------------------------------

        $und_id34 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Unidad de Transparencia',
            'mision' => 'La Unidad de Transparencia y Lucha contra la Corrupción de la Gobernación, tiene el objetivo de generar políticas de Transparencia de la gestión pública',
            'vision' => 'la Unidad de Transparencia y Lucha contra la Corrupción de la Gobernación, tiene el objetivo de generar políticas de Transparencia de la gestión pública',
            'objetivo' => 'la Unidad de Transparencia y Lucha contra la Corrupción de la Gobernación, tiene el objetivo de generar políticas de Transparencia de la gestión pública',
            'historia' => 'En el marco supremo de la Constitución Política del Estado Plurinacional, Ley Marcelo Quiroga Santa Cruz y el Decreto Supremo 29894, la Unidad de Transparencia y Lucha contra la Corrupción de la Gobernación, tiene el objetivo de generar políticas de Transparencia de la gestión pública,  prevención e investigación administrativa de actos de corrupción en el Gobierno Autónomo Departamental de Cochabamba, todas sus dependencias y sus unidades desconcentradas',
            'organigrama' => '2.jpg',
            'imagen_icono' => '4.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id4,
            'und_padre_id' => $und_id1
        ], 'und_id');

        $und_id35 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'La Unidad de Planeamiento Territorial y Estrategias',
            'mision' => 'La Unidad de Planeamiento Territorial y Estrategias realiza el seguimiento',
            'vision' => 'La Unidad de Planeamiento Territorial y Estrategias realiza el seguimiento',
            'objetivo' => 'Promover el desarrollo integral del Departamento de Cochabamba, mediante la elaboración, seguimiento y evaluación del Plan de Desarrollo Departamental',
            'historia' => 'La Unidad de Planeamiento Territorial y Estrategias realiza el seguimiento, monitoreo y  evaluación del Plan de Ordenamiento Territorial (PDOT), Plan Departamental de Cochabamba para Vivir Bien (PDCVB), y el Plan Estratégico Institucional (PEI).',
            'organigrama' => '2.jpg',
            'imagen_icono' => '4.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id4,
            'und_padre_id' => $und_id2
        ], 'und_id');


        $und_id36 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Unidad de Contrataciones',
            'mision' => 'La Unidad de Contratación, es la entidad que coordina los requerimientos de bienes, obras, servicios generales y consultorías con las secretarías, direcciones, unidades, servicios desconcentrados',
            'vision' => 'La Unidad de Contratación, es la entidad que coordina los requerimientos de bienes, obras, servicios generales y consultorías con las secretarías, direcciones, unidades, servicios desconcentrados',
            'objetivo' => 'objetivo',
            'historia' => 'La Unidad de Contratación, es la entidad que coordina los requerimientos de bienes, obras, servicios generales y consultorías con las secretarías, direcciones, unidades, servicios desconcentrados',
            'organigrama' => '2.jpg',
            'imagen_icono' => '4.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777777',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id4,
            'und_padre_id' => $und_id20
        ], 'und_id');

        $und_id37 = DB::table('und_unidad')->insertGetId([
            'nombre' => 'Gaceta',
            'mision' => 'Editar periódica, cronológica y oportunamente la Gaceta Oficial que contenga Leyes, Decretos Supremos, Resoluciones Supremas, Convenios y Tratados Internacionales',
            'vision' => 'Constituirse en el órgano oficial de publicación y difusión permanente de la normativa legal del país.',
            'objetivo' => 'Editar periódica, cronológica y oportunamente la Gaceta Oficial que contenga Leyes, Decretos Supremos, Resoluciones Supremas, Convenios y Tratados Internacionales',
            'historia' => 'Gaceta Oficial de Bolivia, dependiente del Ministerio de la Presidencia, como entidad desconcentrada y como Editor Oficial del Organo Ejecutivo, se encuentra a cargo de Leyes, Decretos Supremos, Resoluciones Supremas y otros de orden legal.  Por una parte, el principio de la publicidad de nuestro ordenamiento jurídico se patentiza en cada ejemplar de Gaceta Oficial',
            'organigrama' => '2.jpg',
            'imagen_icono' => '4.jpeg',
            'estado' => 'AC',
            'celular_wp' => '77777778',
            'telefonos' => '591 4 4258066',
            'email' => 'finanzas@gobernaciondecochabamba.bo',
            'link_facebook' => 'https://www.facebook.com/GobernacionDeCochabamba',
            'link_instagram' => 'linkinstagram',
            'link_twiter' => 'linktwiter',
            'link_youtube' => 'https://www.youtube.com/channel/UCi9ScsXo7rULoT_4Vxt3NYg',
            'lugar' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'direccion' => 'Av. Aroma No. 327 Plaza San Sebastián',
            'latitud' => -17.39942,
            'longitud' => -66.15986,
            'imagen_direccion' => '4.jpeg',
            'bio_id' => $bio_id1,
            'tiu_id' => $tiu_id4,
            'und_padre_id' => $und_id1
        ], 'und_id');
    }
}
