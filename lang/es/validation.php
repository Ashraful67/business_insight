<?php

return [
    'accepted' => 'El :attribute debe ser aceptada',
    'accepted_if' => 'El :attribute debe ser aceptada cuando :other es :value.',
    'active_url' => 'El :attribute no es una URL válida',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute solo debe contener letras',
    'alpha_dash' => 'El :attribute solo debe contener letras guiones y guiones bajos',
    'alpha_num' => 'El :attribute solo debe contener letras y números',
    'array' => 'El :attribute solo debe ser una matriz',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'array' => 'El :attribute debe ser entre :min y :max elementos',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
        'numeric' => 'El :attribute debe ser entre :min y :max.',
        'string' => 'El :attribute debe ser entre :min y :max caracteres',
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso',
    'confirmed' => 'La confirmación de :attribute no coincide',
    'current_password' => 'La contraseña es incorrecta',
    'date' => 'El :attribute no es una fecha válida',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el :format.',
    'decimal' => 'El :attribute debe tener decimales :decimal',
    'declined' => 'El :attribute debe ser rechazado',
    'declined_if' => 'El :attribute debe ser rechazado cuando :other es :value.',
    'different' => 'El :attribute y :other debe ser diferente',
    'digits' => 'El :attribute debe ser de :digits dígitos.',
    'digits_between' => 'El :attributedebe ser entre :min y :max dígitos.',
    'dimensions' => 'El :attribute tiene dimensiones de imágenes no válidas.',
    'distinct' => 'El campo :attribute tiene un valor duplicado',
    'doesnt_end_with' => 'El :attribute no puede terminar con uno de los siguientes: :values.',
    'doesnt_start_with' => 'El :attributeno puede comenzar con uno de los siguientes: :values.',
    'email' => 'El :attribute debe tener un correo electrónico válido',
    'ends_with' => 'El :attribute debe terminar con uno de los siguientes: :values.',
    'enum' => 'El :attribute seleccionado es inválido',
    'exists' => 'El :attribute seleccionado es inválido',
    'file' => 'El :attribute debe serun archivo',
    'filled' => 'El campo :attribute debe tener un valor',
    'gt' => [
        'array' => 'El :attribute debe tener más elementos de :value',
        'file' => 'El :attribute debe ser mayor que :value kilobytes.',
        'numeric' => 'El :attribute debe ser mayor que :value.',
        'string' => 'Los caracteres :attribute deben ser mayores que :value.',
    ],
    'gte' => [
        'array' => 'El :attribute debe tener elementos :value o más',
        'file' => 'El :attribute debe ser mayor o igual que :value kilobytes.',
        'numeric' => 'El :attribute debe ser mayor o igual que :value.',
        'string' => 'Los caracteres :attribute deben ser mayores o iguales que :value.',
    ],
    'image' => 'El :attribute debe ser una imagen',
    'in' => 'El :attribute seleccionado is inválido',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El :attribute debe ser un número entero',
    'ip' => 'El :attribute debe tener una dirección de IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser una cadena JSON válida.',
    'lt' => [
        'array' => 'El atributo :attribute debe tener menos elementos :value.',
        'file' => 'El :attribute debe ser inferior a :value kilobytes.',
        'numeric' => 'El :attribute debe ser menor que :value.',
        'string' => 'El :attribute debe tener menos caracteres que :value.',
    ],
    'lte' => [
        'array' => 'El :attribute no debe tener más elementos :value',
        'file' => 'El :attributedebe ser menor o igual que :value kilobytes.',
        'numeric' => 'El :attribute debe ser menor o igual que :value.',
        'string' => 'El :attribute debe ser menor o igual que los caracteres :value',
    ],
    'mac_address' => 'El :attribute debe ser una dirección MAC válida.',
    'max' => [
        'array' => 'El :attribute no debe tener más elementos que :max',
        'file' => 'El :attribute no debe ser mayor que :max kilobytes.',
        'numeric' => 'El :attribute no debe ser mayor que :max.',
        'string' => 'El :attribute no debe tener más de :max caracteres',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => 'El :attribute debe tener al menos :min elementos',
        'file' => 'El :attribute debe tener al menos :min kilobytes.',
        'numeric' => 'El :attribute debe ser al menos :min.',
        'string' => 'El :attribute debe tener al menos :min caracteres.',
    ],
    'multiple_of' => 'El :attribute debe ser un múltiplo de :value.',
    'not_in' => 'El :attribute seleccionado no es válido.',
    'not_regex' => 'El formato de :attribute no es válido.',
    'numeric' => 'El :attribute debe ser un número.',
    'password' => 'La contraseña es incorrecta',
    'present' => 'El campo :attribute debe estar presente.',
    'prohibited' => 'El campo :attribute está prohibido.',
    'prohibited_if' => 'El campo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless' => 'El campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits' => 'El campo :attribute prohíbe la presencia de :other.',
    'regex' => 'El formato :attribute no es válido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_without_label' => 'Por favor, rellene este campo.',
    'required_array_keys' => 'El campo :attribute debe contener entradas para: :values.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando no está presente ninguno de los :values.',
    'same' => ':attribute y :other deben coincidir.',
    'size' => [
        'array' => 'El :attribute debe contener elementos :size',
        'file' => 'El :attribute debe ser :size kilobytes.',
        'numeric' => 'El :attribute debe ser :size.',
        'string' => 'El :attribute debe tener :size characters.',
    ],
    'starts_with' => 'El :attribute debe empezar por uno de los siguientes: :values.',
    'string' => 'El :attribute debe ser una cadena de texto.',
    'timezone' => 'El :attribute debe ser una zona horaria válida.',
    'unique' => 'El :attribute ya está ocupado.',
    'uploaded' => 'No se ha podido cargar el :attribute',
    'url' => 'El :attribute debe ser una URL válida.',
    'uuid' => 'El :attribute debe ser un UUID válido.',
    'recaptcha' => 'Falló la verificación ReCaptcha.',
    'numeric_field' => 'El :attribute no es un número válido, introduzca un número válido por ejemplo 1200, 1200.00 o 1200.255.',
    'number' => 'El :attribute debe ser un número',
    'calling_prefix' => 'El :attribute debe comenzar con un código de llamada de país válido, por ejemplo: +994',
    'required_file' => 'Por favor, añada un archivo.',
    'custom' => [
        'notifications' => [
            '*' => [
                'email' => 'Introduzca una dirección de correo electrónico válida.',
            ],
        ],
        '_privacy-policy' => [
            'accepted' => 'Debe aceptar la política de privacidad',
        ],
    ],
    'import' => [
        'dependent' => 'El :attribute no pertenece al :dependsOn, asegúrese de que el :attribute esté relacionado con el :dependsOn.',
        'user' => [
            'invalid' => 'Ha proporcionado un usuario que no existe. Debe agregar la identificación de usuario o el nombre completo del usuario.',
        ],
    ],
    'attributes' => [
    ],
];
