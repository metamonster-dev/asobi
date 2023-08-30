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

    'accepted' => ':attribute을(를) 동의하지 않았습니다.',
    'accepted_if' => ':attribute는 :other가 :value인 경우 허용되어야 합니다.',
    'active_url' => ':attribute 값이 유효한 URL이 아닙니다.',
    'after' => ':attribute 값이 :date 보다 이후 날짜가 아닙니다.',
    'after_or_equal' => ':attribute는 :date 이후의 날짜여야 합니다.',
    'alpha' => ':attribute 값에 문자 외의 값이 포함되어 있습니다.',
    'alpha_dash' => ':attribute 값에 문자, 숫자, 대쉬(-) 외의 값이 포함되어 있습니다.',
    'alpha_num' => ':attribute 값에 문자와 숫자 외의 값이 포함되어 있습니다.',
    'array' => ':attribute 값이 유효한 목록 형식이 아닙니다.',
    'ascii' => ':attribute에는 1바이트 영숫자 문자와 기호만 포함해야 합니다.',
    'before' => ':attribute 값이 :date 보다 이전 날짜가 아닙니다.',
    'before_or_equal' => ':attribute는 :date 이전 날짜여야 합니다.',
    'between' => [
        'array' => ':attribute 값이 :min ~ :max 개를 벗어납니다.',
        'file' => ':attribute 값이 :min ~ :max 킬로바이트를 벗어납니다.',
        'numeric' => ':attribute 값이 :min ~ :max 값을 벗어납니다.',
        'string' => ':attribute 값이 :min ~ :max 글자가 아닙니다.',
    ],
    'boolean' => ':attribute 값이 true 또는 false 가 아닙니다.',
    'confirmed' => ':attribute 와 :attribute 확인 값이 서로 다릅니다.',
    'current_password' => '비밀번호가 올바르지 않습니다.',
    'date' => ':attribute 값이 유효한 날짜가 아닙니다.',
    'date_equals' => ':attribute는 :date와 동일한 날짜여야 합니다.',
    'date_format' => ':attribute 값이 :format 형식과 일치하지 않습니다.',
    'decimal' => ':attribute에는 :decimal 소수 자릿수가 있어야 합니다.',
    'declined' => ':attribute는 거부되어야 합니다.',
    'declined_if' => ':attribute는 :other가 :value인 경우 거부되어야 합니다.',
    'different' => ':attribute 값이 :other은(는) 서로 다르지 않습니다.',
    'digits' => ':attribute 값이 :digits 자릿수가 아닙니다.',
    'digits_between' => ':attribute 값이 :min ~ :max 자릿수를 벗어납니다.',
    'dimensions' => ':attribute에 잘못된 이미지 크기가 있습니다.',
    'distinct' => ':attribute 값에 중복된 항목이 있습니다.',
    'doesnt_end_with' => ':attribute는 다음 중 하나로 끝나지 않을 수 있습니다: :values.',
    'doesnt_start_with' => ':attribute는 다음 중 하나로 시작할 수 없습니다: :values.',
    'email' => ':attribute 값이 이메일 형식에 맞지 않습니다.',
    'ends_with' => ':attribute는 다음 중 하나로 끝나야 합니다: :values.',
    'enum' => '선택한 속성이 잘못되었습니다.',
    'exists' => ':attribute 값에 해당하는 리소스가 존재하지 않습니다.',
    'file' => ':attribute는 파일이어야 합니다.',
    'filled' => ':attribute 값은 필수 항목입니다.',
    'gt' => [
        'array' => ':attribute에는 :value보다 많은 항목이 있어야 합니다.',
        'file' => ':attribute는 :value 킬로바이트보다 커야 합니다.',
        'numeric' => ':attribute는 :value보다 커야 합니다.',
        'string' => ':attribute는 :value 문자보다 커야 합니다.',
    ],
    'gte' => [
         'array' => ':attribute에는 :value 이상의 항목이 있어야 합니다.',
         'file' => ':attribute는 :value 킬로바이트보다 크거나 같아야 합니다.',
         'numeric' => ':attribute는 :value보다 크거나 같아야 합니다.',
         'string' => ':attribute는 :value 문자보다 크거나 같아야 합니다.',
     ],
    'image' => ':attribute 값이 이미지가 아닙니다.',
    'in' => ':attribute 값이 유효하지 않습니다.',
    'in_array' => ':attribute 값이 :other 필드의 요소가 아닙니다.',
    'integer' => ':attribute 값이 정수가 아닙니다.',
    'ip' => ':attribute 값이 유효한 IP 주소가 아닙니다.',
    'ipv4' => ':attribute는 유효한 IPv4 주소여야 합니다.',
    'ipv6' => ':attribute는 유효한 IPv6 주소여야 합니다.',
    'json' => ':attribute 값이 유효한 JSON 문자열이 아닙니다.',
    'lowercase' => ':attribute는 소문자여야 합니다.',
    'lt' => [
        'array' => ':attribute에는 :value보다 작은 항목이 있어야 합니다.',
         'file' => ':attribute는 :value 킬로바이트보다 작아야 합니다.',
         'numeric' => ':attribute는 :value보다 작아야 합니다.',
         'string' => ':attribute는 :value 문자보다 작아야 합니다.',
     ],
    'lte' => [
        'array' => ':attribute에는 :value개 이상의 항목이 없어야 합니다.',
        'file' => ':attribute는 :value 킬로바이트보다 작거나 같아야 합니다.',
        'numeric' => ':attribute는 :value보다 작거나 같아야 합니다.',
        'string' => ':attribute는 :value 문자보다 작거나 같아야 합니다.',
    ],
    'mac_address' => ':attribute는 유효한 MAC 주소여야 합니다.',
    'max' => [
        'array' => ':attribute 값이 :max 개보다 많습니다.',
        'file' => ':attribute 값이 :max 킬로바이트보다 큽니다.',
        'numeric' => ':attribute 값이 :max 보다 큽니다.',
        'string' => ':attribute 값이 :max 글자보다 많습니다.',
    ],
    'max_digits' => ':attribute는 :max보다 클 수 없습니다.',
    'mimes' => ':attribute 값이 :values 와(과) 다른 형식입니다.',
    'mimetypes' => ':attribute는 다음 유형의 파일이어야 합니다: :values.',
    'min' => [
        'array' => ':attribute 값이 :max 개보다 적습니다.',
        'file' => ':attribute 값이 :min 킬로바이트보다 작습니다.',
        'numeric' => ':attribute 값이 :min 보다 작습니다.',
        'string' => ':attribute 값이 :min 글자 이상으로 작성하셔야합니다.',
    ],
    'min_digits' => ':attribute는 :min보다 같거나 큰 숫자여야 합니다.',
    'missing' => ':attribute 필드가 없어야 합니다.',
    'missing_if' => ':other가 :value인 경우 :attribute 필드가 누락되어야 합니다.',
    'missing_unless' => ':other가 :value가 아니면 :attribute 필드가 없어야 합니다.',
    'missing_with' => ':values가 있는 경우 :attribute 필드가 없어야 합니다.',
    'missing_with_all' => ':values가 있는 경우 :attribute 필드가 없어야 합니다.',
    'multiple_of' => ':attribute는 :value의 배수여야 합니다.',
    'not_in' => ':attribute 값이 유효하지 않습니다.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute 값이 숫자가 아닙니다.',
    'password' => [
        'letters' => ':attribute는 적어도 하나의 문자를 포함해야 합니다.',
        'mixed' => ':attribute는 적어도 하나의 대문자와 하나의 소문자를 포함해야 합니다.',
        'numbers' => ':attribute는 적어도 하나의 숫자를 포함해야 합니다.',
        'symbols' => ':attribute는 적어도 하나의 기호를 포함해야 합니다.',
        'uncompromised' => '제공된 :attribute가 데이터 유출에 나타났습니다. 다른 :속성을 선택하세요.',
    ],
    'present' => ':attribute 필드가 누락되었습니다.',
    'prohibited' => ':attribute 필드는 금지되어 있습니다.',
    'prohibited_if' => ':other가 :value인 경우 :attribute 필드는 금지됩니다.',
    'prohibited_unless' => ':other가 :values에 없으면 :attribute 필드는 금지됩니다.',
    'prohibits' => ':attribute 필드는 :other가 존재하는 것을 금지합니다.',
    'regex' => ':attribute 값의 형식이 유효하지 않습니다.',
    'required' => ':attribute 항목은 필수 항목입니다.',
    'required_array_keys' => ':attribute 필드는 다음 항목을 포함해야 합니다: :values.',
    'required_if' => ':attribute 값이 누락되었습니다 (:other 값이 :value 일 때는 필수).',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => ':attribute 값이 누락되었습니다 (:other 값이 :value 이(가) 아닐 때는 필수).',
    'required_with' => ':attribute 값이 누락되었습니다 (:values 값이 있을 때는 필수).',
    'required_with_all' => ':attribute 값이 누락되었습니다 (:values 값이 있을 때는 필수).',
    'required_without' => ':attribute 값이 누락되었습니다 (:values 값이 없을 때는 필수).',
    'required_without_all' => ':attribute 값이 누락되었습니다 (:values 값이 없을 때는 필수).',
    'same' => ':attribute 값이 :other 와 서로 다릅니다.',
    'size' => [
        'array' => ':attribute 값이 :size 개가 아닙니다.',
        'file' => ':attribute 값이 :size 킬로바이트가 아닙니다.',
        'numeric' => ':attribute 값이 :size 가 아닙니다.',
        'string' => ':attribute 값이 :size 글자가 아닙니다.',
    ],
    'starts_with' => ':attribute는 다음 중 하나로 시작해야 합니다: :values.',
    'string' => ':attribute 값이 글자가 아닙니다.',
    'timezone' => ':attribute 값이 올바른 시간대가 아닙니다.',
    'unique' => ':attribute 값은 이미 사용 중입니다.',
    'uploaded' => ':attribute를 업로드하지 못했습니다.',
    'uppercase' => ':attribute는 대문자여야 합니다.',
    'url' => ':attribute 값이 유효한 URL이 아닙니다.',
    'ulid' => ':attribute는 유효한 ULID여야 합니다.',
    'uuid' => ':attribute는 유효한 UUID여야 합니다.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
