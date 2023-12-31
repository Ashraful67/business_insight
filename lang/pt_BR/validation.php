<?php

return array (
  'accepted' => 'O :attribute deve ser aceito.',
  'accepted_if' => 'O :attribute deve ser aceito quando :other for :value.',
  'active_url' => 'O :attribute não é um URL válido.',
  'after' => 'O :attribute deve ser uma data posterior a :date.',
'after_or_equal' => 'O :attribute deve ser uma data após ou igual a :date.',
'alpha' => 'O :attribute deve conter apenas letras.',
'alpha_dash' => 'O :attribute deve conter apenas letras, números, traços e sublinhados.',
'alpha_num' => 'O :attribute deve conter apenas letras e números.',
'array' => 'O :attribute deve ser uma matriz.',
'before' => 'O :attribute deve ser uma data anterior a :date.',
'before_or_equal' => 'O :attribute deve ser uma data anterior ou igual a :date.',
'between' =>
array (
'array' => 'O :attribute deve ter entre :min e :max itens.',
'file' => 'O :attribute deve ter entre :min e :max kilobytes.',
'numeric' => 'O :attribute deve estar entre :min e :max.',
'string' => 'O :attribute deve ter entre :min e :max caracteres.',
),
'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
'confirmed' => 'A confirmação do :attribute não corresponde.',
'current_password' => 'A senha está incorreta.',
'date' => 'O :attribute não é uma data válida.',
'date_equals' => 'O :attribute deve ser uma data igual a :date.',
'date_format' => 'O :attribute não corresponde ao formato :format.',
'decimal' => 'O :attribute deve ter :decimal casas decimais.',
'declined' => 'O :attribute deve ser recusado.',
'declined_if' => 'O :attribute deve ser recusado quando :other for :value.',
'different' => 'O :attribute e :other devem ser diferentes.',
'digits' => 'O :attribute deve ter :digits dígitos.',
'digits_between' => 'O :attribute deve ter entre :min e :max dígitos.',
'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
'distinct' => 'O campo :attribute tem um valor duplicado.',
'doesnt_end_with' => 'O :attribute não pode terminar com um dos seguintes: :values.',
'doesnt_start_with' => 'O :attribute não pode começar com um dos seguintes: :values.',
'email' => 'O :attribute deve ser um endereço de e-mail válido.',
'ends_with' => 'O :attribute deve terminar com um dos seguintes: :values.',
'enum' => 'O :attribute selecionado é inválido.',
'exists' => 'O :attribute selecionado é inválido.',
'file' => 'O :attribute deve ser um arquivo.',
'filled' => 'O campo :attribute deve ter um valor.',
'gt' =>
array (
'array' => 'O :attribute deve ter mais de :value itens.',
'file' => 'O :attribute deve ser maior que :value kilobytes.',
'numeric' => 'O :attribute deve ser maior que :value.',
'string' => 'O :attribute deve ter mais de :value caracteres.',
),
'gte' =>
array (
'array' => 'O :attribute deve ter :value itens ou mais.',
'file' => 'O :attribute deve ser maior ou igual a :value kilobytes.',
'numeric' => 'O :attribute deve ser maior ou igual a :value.',
'string' => 'O :attribute deve ser maior ou igual a :value caracteres.',
),
'image' => 'O :attribute deve ser uma imagem.',
'in' => 'O :attribute selecionado é inválido.',
'in_array' => 'O campo :attribute não existe em :other.',
'integer' => 'O :attribute deve ser um número inteiro.',
'ip' => 'O :attribute deve ser um endereço de IP válido.',
'ipv4' => 'O :attribute deve ser um endereço IPv4 válido.',
'ipv6' => 'O :attribute deve ser um endereço IPv6 válido.',
'json' => 'O :attribute deve ser uma sequência JSON válida.',
'lt' =>
array (
'array' => 'O :attribute deve ter menos de :value itens.',
'file' => 'O :attribute deve ser menor que :value kilobytes.',
'numeric' => 'O :attribute deve ser menor que :value.',
'string' => 'O :attribute deve ter menos de :value caracteres.',
),
'lte' =>
array (
'array' => 'O :attribute não deve ter mais de :value itens.',
'file' => 'O :attribute deve ser menor ou igual a :value kilobytes.',
'numeric' => 'O :attribute deve ser menor ou igual a :value.',
'string' => 'O :attribute deve ser menor ou igual a :value caracteres.',
),
'mac_address' => 'O :attribute deve ser um endereço MAC válido.',
'max' =>
array (
'array' => 'O :attribute não deve ter mais de :max itens.',
'file' => 'O :attribute não deve ser maior que :max kilobytes.',
'numeric' => 'O :attribute não deve ser maior que :max.',
'string' => 'O :attribute não deve ser maior que :max caracteres.',
),
'mimes' => 'O :attribute deve ser um arquivo do tipo: :values.',
'mimetypes' => 'O :attribute deve ser um arquivo do tipo: :values.',
'min' =>
array (
'array' => 'O :attribute deve ter pelo menos :min itens.',
'file' => 'O :attribute deve ter pelo menos :min kilobytes.',
'numeric' => 'O :attribute deve ser no mínimo :min.',
'string' => 'O :attribute deve ter pelo menos :min caracteres.',
),
'multiple_of' => 'O :attribute deve ser um múltiplo de :value.',
'not_in' => 'O :attribute selecionado é inválido.',
'not_regex' => 'O formato do :attribute é inválido.',
'numeric' => 'O :attribute deve ser um número.',
'password' => 'A senha está incorreta.',
'present' => 'O campo :attribute deve estar presente.',
'prohibited' => 'O campo :attribute é proibido.',
'prohibited_if' => 'O campo :attribute é proibido quando :other é :value.',
'prohibited_unless' => 'O campo :attribute é proibido a menos que :other esteja em :values.',
'prohibits' => 'O campo :attribute proíbe que :other esteja presente.',
'regex' => 'O formato do :attribute é inválido.',
'required' => 'O campo :attribute é obrigatório.',
'required_without_label' => 'Preencha este campo obrigatório.',
'required_array_keys' => 'O campo :attribute deve conter entradas para: :values.',
'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
'required_unless' => 'O campo :attribute é obrigatório a menos que :other esteja em :values.',
'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
'same' => 'O :attribute e :other devem ser iguais.',
'size' =>
array (
'array' => 'O :attribute deve ter exatamente :size itens.',
'file' => 'O :attribute deve ser :size kilobytes.',
'numeric' => 'O :attribute deve ser :size.',
'string' => 'O :attribute deve ter :size caracteres.',
),
'starts_with' => 'O :attribute deve começar com um dos seguintes valores: :values.',
'string' => 'O :attribute deve ser uma sequência de caracteres.',
'timezone' => 'O :attribute deve ser uma timezone válida.',
'unique' => 'O :attribute já foi utilizado.',
'uploaded' => 'O :attribute falhou ao fazer o upload.',
'url' => 'O formato do :attribute é inválido.',
'uuid' => 'O :attribute deve ser um UUID válido.',
'recaptcha' => 'Falha na verificação ReCaptcha.',
'numeric_field' => 'O :attribute não é um número válido, digite um número válido como por exemplo 1200, 1200.00 ou 1200.255.',
'number' => 'O :attribute deve ser um número.',
'calling_prefix' => 'O :attribute deve começar com o código de chamada de país válido, por exemplo: +994',
'required_file' => 'Adicione um arquivo.',
'custom' =>
array (
'notifications' =>
array (
'*' =>
array (
'email' => 'Digite um endereço de email válido.',
),
),
'_privacy-policy' =>
array (
'accepted' => 'Você deve aceitar a política de privacidade.',
),
),
'import' =>
array (
'dependent' => ':attribute não pertence a :dependsOn, verifique se :attribute está relacionado a :dependsOn.',
'user' =>
array (
'invalid' => 'Você forneceu um usuário que não existe. Você deve adicionar o ID do usuário ou o nome completo do usuário.',
),
),
'attributes' =>
array (
),
);
