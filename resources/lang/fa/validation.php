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

    'accepted'             => ':attribute باید پذیرفته شود',
    'active_url'           => ':attribute این یک نشانی وب اشتباه است',
    'after'                => ':attribute باید یک روز بعد از این تاریخ باشد :date.',
    'alpha'                => ':attribute می بایست تنها شامل حروف باشد',
    'alpha_dash'           => ':attribute می بایست تنها شامل حروف، اعداد و خط تیره باشد',
    'alpha_num'            => ':attribute می بایست تنها شامل حروف و اعداد باشد',
    'array'                => ':attribute باید آرایه باشد',
    'before'               => ':attribute باید یک روز قبل از این تاریخ باشد :date.',
    'between'              => [
        'numeric' => ':attribute باید بین :min و :max. باشد',
        'file'    => ':attribute باید بین :min و :max کیلوبایت باشد',
        'string'  => ':attribute باید بین :min و :max حروف باشد',
        'array'   => ':attribute باید بین :min و :max موارد باشد',
    ],
    'boolean'              => ':attribute این بخش باید درست یا غلط باشد',
    'confirmed'            => ':attribute تاییدیه مطابقت ندارد',
    'date'                 => ':attribute تاریخ درست نمی باشد',
    'date_format'          => ':attribute با این قالب مطابقت ندارد :format.',
    'different'            => ':attribute و :other باید متفاوت باشد',
    'digits'               => ':attribute باید :digits رقم باشد',
    'digits_between'       => ':attribute باید بین :min و :max رقم باشد',
    'distinct'             => ':attribute این بخش دارای ارزش های تکراری است',
    'email'                => ':attribute می بایست یک پست الکترونیک صحیح باشد',
    'exists'               => ':attribute انتخاب شده معتبر نیست',
    'filled'               => ':attribute این بخش الزامیست',
    'image'                => ':attribute می بایست یک تصویر باشد',
    'in'                   => ':attribute انتخاب شده معتبر نیست',
    'in_array'             => ':attribute این بخش موجود نیست در :other.',
    'integer'              => ':attribute باید یک عدد صحیح باشد',
    'ip'                   => ':attribute باید یک IP آدرس صحیح باشد',
    'json'                 => ':attribute باید رشته JSON باشد',
    'max'                  => [
        'numeric' => ':attribute نباید بزرگتر از :max. باشد',
        'file'    => ':attribute نباید بزرگتر از :max کیلوبایت باشد',
        'string'  => ':attribute نباید بزرگتر از :max حروف باشد',
        'array'   => ':attribute نباید بیشتر از :max موارد باشد',
    ],
    'mimes'                => ':attribute باید یک فایل از type: :values. باشد',
    'min'                  => [
        'numeric' => ':attribute باید حداقل :min. باشد',
        'file'    => ':attribute باید حداقل :min کیلوبایت باشد',
        'string'  => ':attribute باید حداقل :min حروف باشد',
        'array'   => ':attribute باید حداقل :min موارد باشد',
    ],
    'not_in'               => ':attribute انتخابی درست نمیباشد',
    'numeric'              => ':attribute باید یک عدد باشد',
    'present'              => ':attribute این بخش باید زمان حال باشد',
    'regex'                => ':attribute این فرمت صحیح نیست',
    'required'             => ':attribute این بخش الزامیست',
    'required_if'          => ':attribute این بخش الزامیست زمانی که :other باشد :value.',
    'required_unless'      => ':attribute این بخش الزامیست بغیر از :other باشد :values.',
    'required_with'        => ':attribute این بخش الزامیست زمانی که :values زمان حال باشد ',
    'required_with_all'    => ':attribute این بخش الزامیست زمانی که :values زمان حال باشد',
    'required_without'     => ':attribute این بخش الزامیست زمانی که :values زمان حال نباشد',
    'required_without_all' => ':attribute این بخش الزامیست زمانی که هیچ کدام از :values زمان حال نباشد',
    'same'                 => ':attribute و :other باید یکسان باشد',
    'size'                 => [
        'numeric' => ':attribute باید :size. باشد',
        'file'    => ':attribute باید :size کیلوبایت باشد',
        'string'  => ':attribute باید :size حروف باشد',
        'array'   => ':attribute باید شامل :size موارد باشد',
    ],
    'string'               => ':attribute باید یک رشته باشد',
    'timezone'             => ':attribute باید یک منطقه معتبر باشد',
    'unique'               => ':attribute قبلا انتخاب شده است',
    'url'                  => ':attribute این قالب صحیح نیست',
    'hash'                 => ':attribute با رمز عبور همخوانی ندارد',
    'verification'         => 'کد تأیید نامعتبر است',

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
