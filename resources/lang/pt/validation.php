<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O atributo :attribute deve ser aceito.',
    'active_url'           => 'O atributo :attribute não é uma URL válida.',
    'after'                => 'O atributo :attribute deve ser uma data posterior a :date.',
    'after_or_equal'       => 'O atributo :attribute deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O atributo :attribute deve conter apenas letras.',
    'alpha_dash'           => 'O atributo :attribute deve conter apenas letras, números e traços.',
    'alpha_num'            => 'O atributo :attribute deve conter apenas letras e números.',
    'array'                => 'O atributo :attribute deve ser um vetor.',
    'before'               => 'O atributo :attribute deve ser uma data anterior a :date.',
    'before_or_equal'      => 'O atributo :attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O atributo :attribute deve estar entre :min e :max.',
        'file'    => 'O atributo :attribute deve estar entre :min e :max kilobytes.',
        'string'  => 'O atributo :attribute deve conter entre :min e :max caracteres.',
        'array'   => 'O atributo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O atributo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'O atributo :attribute confirmação não confere.',
    'date'                 => 'O atributo :attribute não é uma data válida.',
    'date_format'          => 'O atributo :attribute não confere com o formato :format.',
    'different'            => 'O atributo :attribute e :other devem ser diferentes.',
    'digits'               => 'O atributo :attribute deve conter :digits dígitos.',
    'digits_between'       => 'O atributo :attribute deve conter entre :min e :max dígitos.',
    'dimensions'           => 'O atributo :attribute possui dimensões inválidas de imagem.',
    'distinct'             => 'O atributo :attribute possui valor duplicado.',
    'email'                => 'O atributo :attribute deve ser um endereço de e-mail válido.',
    'exists'               => 'O atributo selecionado :attribute é inválido.',
    'file'                 => 'O atributo :attribute deve ser um arquivo.',
    'filled'               => 'O atributo :attribute deve conter um valor.',
    'image'                => 'O atributo :attribute deve ser uma imagem.',
    'in'                   => 'O atributo selecionado :attribute é inválido.',
    'in_array'             => 'O atributo :attribute não existe em :other.',
    'integer'              => 'O atributo :attribute deve ser um número inteiro.',
    'ip'                   => 'O atributo :attribute deve ser um endereço IP válido.',
    'ipv4'                 => 'O atributo :attribute deve ser um endereço IPv4 válido',
    'ipv6'                 => 'O atributo :attribute deve ser um endereço IPv6 válido.',
    'json'                 => 'O atributo :attribute deve ser uma cadeia de caracteres JSON válida.',
    'max'                  => [
        'numeric' => 'O atributo :attribute não pode ser maior do que :max.',
        'file'    => 'O atributo :attribute não pode ser maior do que :max kilobytes.',
        'string'  => 'O atributo :attribute não pode conter mais do que :max caracteres.',
        'array'   => 'O atributo :attribute não pode ter mais do que :max itens.',
    ],
    'mimes'                => 'O atributo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O atributo :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O atributo :attribute deve ser de no mínimo :min.',
        'file'    => 'O atributo :attribute deve ser de no mímino :min kilobytes.',
        'string'  => 'O atributo :attribute deve conter pelo menos :min caracteres.',
        'array'   => 'O atributo :attribute deve ter no mímino :min itens.',
    ],
    'not_in'               => 'O atributo selecionado :attribute é inválido.',
    'numeric'              => 'O atributo :attribute deve ser um número.',
    'present'              => 'O atributo :attribute deve estar presente.',
    'regex'                => 'O formato de atributo :attribute é inválido.',
    'required'             => 'O atributo :attribute é requerido.',
    'required_if'          => 'O atributo :attribute é requerido quando :other é :value.',
    'required_unless'      => 'O atributo :attribute é requerido  a menos que :other esteja em :values.',
    'required_with'        => 'O atributo :attribute é requerido quando :values está presente.',
    'required_with_all'    => 'O atributo :attribute é requerido quando :values estão presentes.',
    'required_without'     => 'O atributo :attribute é requerido quando :values não está presente.',
    'required_without_all' => 'O atributo :attribute é requerido quando nenhum de :values estejam presentes.',
    'same'                 => 'O atributo :attribute e :other devem conferir.',
    'size'                 => [
        'numeric' => 'O atributo :attribute deve ser :size.',
        'file'    => 'O atributo :attribute deve ter :size kilobytes.',
        'string'  => 'O atributo :attribute deve conter :size caracteres.',
        'array'   => 'O atributo :attribute deve conter :size itens.',
    ],
    'string'               => 'O atributo :attribute deve ser texto.',
    'timezone'             => 'O atributo :attribute deve ser uma zona válida.',
    'unique'               => 'O atributo :attribute já está sendo utilizado.',
    'uploaded'             => 'O atributo :attribute falhou em ser carregado.',
    'url'                  => 'O formato de atributo :attribute é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
